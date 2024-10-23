<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StokController extends Controller{
    
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $users = UserModel::all();

        return view('stok.index', compact('breadcrumb', 'suppliers', 'barangs', 'users'));
    }

    public function list(){
        $stok = Stok::with(['supplier', 'barang', 'user'])
            ->orderBy('stok_tanggal', 'desc');

        return DataTables::of($stok)
            ->addIndexColumn()
            ->editColumn('stok_tanggal', function ($stok) {
                return date('d/m/Y H:i', strtotime($stok->stok_tanggal));
            })
            ->addColumn('supplier_nama', function ($stok) {
                return $stok->supplier ? $stok->supplier->supplier_nama : '-';
            })
            ->addColumn('barang_nama', function ($stok) {
                return $stok->barang ? $stok->barang->barang_nama : '-';
            })
            ->addColumn('user_nama', function ($stok) {
                return $stok->user ? $stok->user->nama : '-';
            })
            ->addColumn('aksi', function ($stok) {
                return view('stok.action-buttons', compact('stok'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $users = UserModel::all();

        return view('stok.create', compact('breadcrumb', 'suppliers', 'barangs', 'users'));
    }

    public function store(Request $request){
        $request->validate([
            'supplier_id' => 'required|exists:m_supplier,supplier_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'user_id' => 'required|exists:m_user,user_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            Stok::create($request->all());
            
            DB::commit();
            return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id){
        $stok = Stok::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $users = UserModel::all();

        return view('stok.edit', compact('stok', 'breadcrumb', 'suppliers', 'barangs', 'users'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'supplier_id' => 'required|exists:m_supplier,supplier_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'user_id' => 'required|exists:m_user,user_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $stok = Stok::findOrFail($id);
            $stok->update($request->all());
            
            DB::commit();
            return redirect()->route('stok.index')->with('success', 'Stok berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id){
        try {
            $stok = Stok::findOrFail($id);
            $stok->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public static function kurangiStok($barangId, $jumlah, $userId){
        $stokAwal = Stok::where('barang_id', $barangId)
            ->where('stok_jumlah', '>', 0)
            ->sum('stok_jumlah');

        if ($stokAwal < $jumlah) {
            throw new \Exception('Stok tidak mencukupi');
        }

        $stoks = Stok::where('barang_id', $barangId)
            ->where('stok_jumlah', '>', 0)
            ->orderBy('stok_tanggal', 'asc')
            ->get();

        $sisaJumlah = $jumlah;
        foreach ($stoks as $stok) {
            if ($sisaJumlah <= 0) break;

            $pengurangan = min($stok->stok_jumlah, $sisaJumlah);
            $stok->stok_jumlah -= $pengurangan;
            $stok->save();

            $sisaJumlah -= $pengurangan;
        }
    }
    public function export_excel(){
        try {
            $stok = Stok::with(['supplier', 'barang', 'user'])
                ->orderBy('stok_tanggal', 'desc')
                ->get();
    
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            
            $headers = ['No', 'Tanggal', 'Supplier', 'Barang', 'User', 'Jumlah'];
            foreach (range('A', 'F') as $index => $column) {
                $sheet->setCellValue($column.'1', $headers[$index]);
            }
    
            
            $headerStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '800080'] 
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ];
            $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
    
            
            $row = 2;
            foreach ($stok as $index => $item) {
                $sheet->setCellValue('A'.$row, $index + 1);
                $sheet->setCellValue('B'.$row, date('d/m/Y H:i', strtotime($item->stok_tanggal)));
                $sheet->setCellValue('C'.$row, $item->supplier ? $item->supplier->supplier_nama : '-');
                $sheet->setCellValue('D'.$row, $item->barang ? $item->barang->barang_nama : '-');
                $sheet->setCellValue('E'.$row, $item->user ? $item->user->nama : '-');
                $sheet->setCellValue('F'.$row, $item->stok_jumlah);
    
                
                if ($row % 2 == 0) {
                    $sheet->getStyle('A'.$row.':F'.$row)
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('FFB6C1'); 
                }
    
                
                $sheet->getStyle('A'.$row.':F'.$row)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ]);
    
                $sheet->getStyle('F'.$row)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    
                $row++;
            }
    
            $sheet->getStyle('F2:F'.($row-1))->getNumberFormat()
                ->setFormatCode('#,##0');
    

            foreach (range('A', 'F') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
    
            
            $sheet->getPageSetup()->setPrintArea('A1:F'.($row-1));
    
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Data Stok.xlsx"');
            header('Cache-Control: max-age=0');
    
            $writer = new Xlsx($spreadsheet);
            ob_end_clean();
            $writer->save('php://output');
            exit;
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat export Excel: ' . $e->getMessage());
        }
    }
    
    public function export_pdf(){
        try {
            $stok = Stok::with(['supplier', 'barang', 'user'])
                ->orderBy('stok_tanggal', 'desc')
                ->get();
    
            $pdf = PDF::loadView('stok.export_pdf', [
                'stok' => $stok,
                'tanggal' => date('d/m/Y H:i:s')
            ]);
    
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('Data Stok.pdf');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat export PDF: ' . $e->getMessage());
        }
    }
}
