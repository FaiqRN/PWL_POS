<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        return view('barang.index', compact('breadcrumb'));
    }

    public function list(){
        $barang = Barang::with('kategori');
        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori->kategori_nama;
            })
            ->addColumn('aksi', function ($barang) {
                return view('barang.action-buttons', compact('barang'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create(){
        $kategoris = Kategori::all();
        $barangCode = Barang::generateUniqueCode();
        return view('barang.create', compact('kategoris', 'barangCode'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|unique:m_barang,barang_kode|max:10',
            'barang_nama' => 'required|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'errors' => $validator->errors()
            ]);
        }

        try {
            $barang = Barang::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Barang berhasil ditambahkan.',
                'data' => $barang
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating barang: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menambahkan barang.'
            ], 500);
        }
    }

    public function edit($id){
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|max:10|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama' => 'required|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'errors' => $validator->errors()
            ]);
        }

        try {
            $barang = Barang::findOrFail($id);
            $barang->update($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Barang berhasil diperbarui.',
                'data' => $barang
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating barang: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memperbarui barang.'
            ], 500);
        }
    }

    public function show($id){
        $barang = Barang::with('kategori')->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function destroy($id){
        try {
            $barang = Barang::findOrFail($id);
            $barang->delete();
            return response()->json([
                'status' => true,
                'message' => 'Barang berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting barang: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus barang.'
            ], 500);
        }
    }

    public function import_ajax(Request $request){
        $validator = Validator::make($request->all(), [
            'file_barang' => 'required|mimes:xlsx|max:1024'
        ], [
            'file_barang.required' => 'File harus diupload',
            'file_barang.mimes' => 'File harus berformat xlsx',
            'file_barang.max' => 'Ukuran file maksimal 1MB'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $file = $request->file('file_barang');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, false, true);

            if (count($data) <= 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'File tidak memiliki data'
                ]);
            }

            $insert = [];
            foreach ($data as $index => $row) {
                if ($index === 1) continue; 

                if (empty($row['A']) || empty($row['B']) || empty($row['C']) || 
                    empty($row['D']) || empty($row['E'])) {
                    continue;
                }

                $insert[] = [
                    'kategori_id' => $row['A'],
                    'barang_kode' => $row['B'],
                    'barang_nama' => $row['C'],
                    'harga_beli' => $row['D'],
                    'harga_jual' => $row['E'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (empty($insert)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data valid untuk diimport'
                ]);
            }

            Barang::insertOrIgnore($insert);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimport'
            ]);

        } catch (\Exception $e) {
            Log::error('Error importing barang: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memproses file'
            ]);
        }
    }
    public function export_excel(){
        try {
            $barang = Barang::with('kategori')
                ->select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
                ->orderBy('kategori_id')
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'DATA BARANG');
            $sheet->mergeCells('A1:G1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $headers = ['No', 'Kode Barang', 'Nama Barang', 'Kategori', 'Harga Beli', 'Harga Jual', 'Tanggal Export'];
            foreach (range('A', 'G') as $index => $column) {
                $sheet->setCellValue($column.'3', $headers[$index]);
            }

            $headerStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'E2EFDA',
                    ],
                ],
            ];
            $sheet->getStyle('A3:G3')->applyFromArray($headerStyle);

            $row = 4;
            foreach ($barang as $index => $item) {
                $sheet->setCellValue('A'.$row, $index + 1);
                $sheet->setCellValue('B'.$row, $item->barang_kode);
                $sheet->setCellValue('C'.$row, $item->barang_nama);
                $sheet->setCellValue('D'.$row, $item->kategori->kategori_nama);
                $sheet->setCellValue('E'.$row, $item->harga_beli);
                $sheet->setCellValue('F'.$row, $item->harga_jual);
                $sheet->setCellValue('G'.$row, now()->format('d/m/Y H:i'));

                
                $sheet->getStyle('E'.$row)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('F'.$row)->getNumberFormat()->setFormatCode('#,##0');

                $row++;
            }

            $dataStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ];
            $sheet->getStyle('A3:G'.($row-1))->applyFromArray($dataStyle);

            foreach (range('A', 'G') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            $filename = 'Data Barang - ' . date('d-m-Y H.i.s') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            Log::error('Error exporting barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengexport data.');
        }
    }
    public function export_pdf(){
        try {
            $barang = Barang::with('kategori')
                ->select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
                ->orderBy('kategori_id')
                ->orderBy('barang_kode')
                ->get();

            $pdf = PDF::loadView('barang.export_pdf', ['barang' => $barang]);
            
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
                'dpi' => 150,
                'defaultFont' => 'sans-serif'
            ]);

            return $pdf->stream('Data Barang - ' . date('d-m-Y H.i.s') . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error exporting PDF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengexport PDF.');
        }
    }
}