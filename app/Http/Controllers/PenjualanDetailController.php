<?php


namespace App\Http\Controllers;


use App\Models\PenjualanDetail;
use App\Models\Penjualan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class PenjualanDetailController extends Controller{


    public function index(Request $request){
        $breadcrumb = (object) [
            'title' => 'Daftar Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan']
        ];
   
        $activemenu = 'PenjualanDetail';
   
        if ($request->ajax()) {
            return $this->getPenjualanDetailData();
        }
   
        return view('PenjualanDetail.index', compact('breadcrumb', 'activemenu'));
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Tambah']
        ];


        $penjualans = Penjualan::all();
        $barangs = Barang::all();


        return view('PenjualanDetail.create', compact('breadcrumb', 'penjualans', 'barangs'));
    }


    public function store(Request $request){
        $validated = $request->validate([
            'penjualan_id' => 'required|exists:t_penjualan,penjualan_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
        ]);
       
        try {
            PenjualanDetail::create($validated);
            return redirect()->route('PenjualanDetail.index')->with('success', 'Detail Penjualan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating penjualan detail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan detail penjualan.')->withInput();
        }
    }


    public function edit($id){
        $penjualanDetail = PenjualanDetail::findOrFail($id);
        $penjualans = Penjualan::all();
        $barangs = Barang::all();
        $breadcrumb = (object) [
            'title' => 'Edit Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Edit']
        ];


        return view('PenjualanDetail.edit', compact('penjualanDetail', 'penjualans', 'barangs', 'breadcrumb'));
    }


    public function update(Request $request, $id){
        $validated = $request->validate([
            'penjualan_id' => 'required|exists:t_penjualan,penjualan_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
        ]);


        try {
            $penjualanDetail = PenjualanDetail::findOrFail($id);
            $penjualanDetail->update($validated);
            return redirect()->route('PenjualanDetail.index')->with('success', 'Detail Penjualan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating penjualan detail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui detail penjualan.')->withInput();
        }
    }


    public function destroy($id){
        try {
            $penjualanDetail = PenjualanDetail::findOrFail($id);
            $penjualanDetail->delete();
            return redirect()->route('PenjualanDetail.index')->with('success', 'Detail Penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting penjualan detail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus detail penjualan.');
        }
    }


    public function getHargaBarang($id){
        try {
            $barang = Barang::findOrFail($id);
            return response()->json(['harga' => $barang->harga_jual]);
        } catch (\Exception $e) {
            Log::error('Error getting harga barang: ' . $e->getMessage());
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }
    }


    private function getPenjualanDetailData(){
        $penjualanDetail = PenjualanDetail::with(['penjualan', 'barang']);
        return DataTables::of($penjualanDetail)
            ->addColumn('penjualan_kode', function ($penjualanDetail) {
                return $penjualanDetail->penjualan->penjualan_kode;
            })
            ->addColumn('barang_nama', function ($penjualanDetail) {
                return $penjualanDetail->barang->barang_nama;
            })
            ->addColumn('aksi', function ($penjualanDetail) {
                return view('PenjualanDetail.aksi', compact('penjualanDetail'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}



