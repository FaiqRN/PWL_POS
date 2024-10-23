<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Barang;
use App\Models\UserModel;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PenjualanController extends Controller{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar penjualan yang terdaftar dalam sistem',
            'list' => ['Home', 'Penjualan']
        ];

        return view('penjualan.index', compact('breadcrumb'));
    }

    public function list(){
        $penjualan = Penjualan::with(['user', 'details.barang']);
        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_items', function ($penjualan) {
                return $penjualan->details->sum('jumlah');
            })
            ->addColumn('total_harga', function ($penjualan) {
                return $penjualan->details->sum(function($detail) {
                    return $detail->jumlah * $detail->harga;
                });
            })
            ->addColumn('user_nama', function ($penjualan) {
                return $penjualan->user->nama;
            })
            ->addColumn('aksi', function ($penjualan) {
                return view('penjualan.action-buttons', compact('penjualan'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create(){
        $users = UserModel::all();
        $barangs = Barang::select('m_barang.*')
            ->selectRaw('(SELECT COALESCE(SUM(stok_jumlah), 0) FROM t_stok WHERE barang_id = m_barang.barang_id) as stok_total')
            ->having('stok_total', '>', 0)
            ->get();
        $penjualanKode = Penjualan::generateKodePenjualan();
    
        return view('penjualan.create', compact('users', 'barangs', 'penjualanKode'));
    }

    public function getBarangInfo($id){
        $barang = Barang::findOrFail($id);
        $stok = Stok::where('barang_id', $id)->sum('stok_jumlah');

        return response()->json([
            'harga_jual' => $barang->harga_jual,
            'stok' => $stok
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => 'required',
            'pembeli' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            'harga' => 'required|array'
        ]);
    
        DB::beginTransaction();
        try {
            
            $penjualan = Penjualan::create([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_kode' => Penjualan::generateKodePenjualan(),
                'penjualan_tanggal' => $request->tanggal
            ]);
    
            foreach ($request->barang_id as $key => $barangId) {
                $stokTersedia = Stok::where('barang_id', $barangId)
                    ->sum('stok_jumlah');
    
                if ($stokTersedia < $request->jumlah[$key]) {
                    throw new \Exception('Stok tidak mencukupi untuk barang yang dipilih');
                }
    
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barangId,
                    'jumlah' => $request->jumlah[$key],
                    'harga' => $request->harga[$key]
                ]);
    
                Stok::create([
                    'barang_id' => $barangId,
                    'user_id' => $request->user_id,
                    'stok_tanggal' => $request->tanggal,
                    'stok_jumlah' => -$request->jumlah[$key],
                    'supplier_id' => null
                ]);
            }
    
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Penjualan berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::with('details')->findOrFail($id);
            
            foreach ($penjualan->details as $detail) {
                Stok::create([
                    'barang_id' => $detail->barang_id,
                    'user_id' => $penjualan->user_id,
                    'stok_tanggal' => now(),
                    'stok_jumlah' => $detail->jumlah
                ]);
            }
            
            $penjualan->details()->delete();
            $penjualan->delete();
            
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Penjualan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function export_excel(){
        try {
            $penjualan = Penjualan::with(['user', 'details.barang'])
                ->orderBy('penjualan_tanggal', 'desc')
                ->get();
    
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $headers = ['No', 'Tanggal', 'Kode Penjualan', 'Pembeli', 'Nama Barang', 'Jumlah', 'Harga', 'Subtotal', 'Total', 'User'];
            foreach (range('A', 'J') as $index => $column) {
                $sheet->setCellValue($column.'1', $headers[$index]);
            }
    
            $headerStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FF69B4'] 
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
            $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
    
            $row = 2;
            $no = 1;
            foreach ($penjualan as $p) {
                $firstRow = true;
                $totalPenjualan = 0;
                
                foreach ($p->details as $detail) {
                    $subtotal = $detail->jumlah * $detail->harga;
                    $totalPenjualan += $subtotal;
    
                    $sheet->setCellValue('A'.$row, $no);
                    $sheet->setCellValue('B'.$row, date('d/m/Y H:i', strtotime($p->penjualan_tanggal)));
                    $sheet->setCellValue('C'.$row, $p->penjualan_kode);
                    $sheet->setCellValue('D'.$row, $p->pembeli);
                    $sheet->setCellValue('E'.$row, $detail->barang->barang_nama);
                    $sheet->setCellValue('F'.$row, $detail->jumlah);
                    $sheet->setCellValue('G'.$row, $detail->harga);
                    $sheet->setCellValue('H'.$row, $subtotal);
                    if ($firstRow) {
                        $sheet->setCellValue('I'.$row, $totalPenjualan);
                        $sheet->setCellValue('J'.$row, $p->user->nama);
                    }
    
                    if ($row % 2 == 0) {
                        $sheet->getStyle('A'.$row.':J'.$row)
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->setStartColor(new Color('FFE6F3')); 
                    }
    
                    $sheet->getStyle('A'.$row.':J'.$row)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN
                            ]
                        ]
                    ]);
    
                    $sheet->getStyle('F'.$row.':I'.$row)->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    
                    $row++;
                    $firstRow = false;
                }
                $no++;
            }
    
            $sheet->getStyle('G2:I'.$row)->getNumberFormat()
                ->setFormatCode('#,##0');
    

            foreach (range('A', 'J') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
    
            
            $sheet->getPageSetup()->setPrintArea('A1:J'.($row-1));
    
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Data Penjualan.xlsx"');
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
           $penjualan = Penjualan::with(['user', 'details.barang'])
               ->orderBy('penjualan_tanggal', 'desc')
               ->get();
    
           $pdf = PDF::loadView('penjualan.export_pdf', [
               'penjualan' => $penjualan,
               'tanggal' => date('d/m/Y H:i:s')
           ]);
    
           $pdf->setPaper('A4', 'landscape');
           return $pdf->download('Data Penjualan.pdf');
    
       } catch (\Exception $e) {
           return redirect()->back()->with('error', 'Terjadi kesalahan saat export PDF: ' . $e->getMessage());
       }
    }
}
