<?php


namespace App\Http\Controllers;


use App\Models\Penjualan;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class PenjualanController extends Controller{


    public function index(Request $request){
        $breadcrumb = (object) [
            'title' => 'Daftar penjualan yang terdaftar dalam sistem',
            'list' => ['Home', 'Penjualan']
        ];


        if ($request->ajax()) {
            return $this->getPenjualanData();
        }


        return view('Penjualan.index', compact('breadcrumb'));
    }


    public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Penjualan',
        'list' => ['Home', 'Penjualan', 'Tambah']
    ];


    $users = UserModel::all();
    $penjualanKode = Penjualan::generateKodePenjualan();


    return view('Penjualan.create', compact('breadcrumb', 'users', 'penjualanKode'));
}


    public function store(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|exists:m_user,user_id',
            'pembeli' => 'required|string|max:50',
            'penjualan_tanggal' => 'required|date',
        ]);


        $validated['penjualan_kode'] = Penjualan::generateKodePenjualan();


        try {
            Penjualan::create($validated);
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating penjualan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan penjualan.')->withInput();
        }
    }




    public function edit($id){
        $penjualan = Penjualan::findOrFail($id);
        $users = UserModel::all();
        $breadcrumb = (object) [
            'title' => 'Edit Penjualan',
            'list' => ['Home', 'Penjualan', 'Edit']
        ];


        return view('Penjualan.edit', compact('penjualan', 'users', 'breadcrumb'));
    }


    public function update(Request $request, $id){
        $validated = $request->validate([
            'pembeli' => 'required|string|max:50',
            'penjualan_tanggal' => 'required|date',
        ]);
   
        try {
            $penjualan = Penjualan::findOrFail($id);
            $penjualan->update($validated);
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating penjualan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui penjualan.')->withInput();
        }
    }


    public function destroy($id){
        try {
            $penjualan = Penjualan::findOrFail($id);
            $penjualan->delete();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting penjualan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus penjualan.');
        }
    }


    private function getPenjualanData(){
        $penjualan = Penjualan::with('user');
        return DataTables::of($penjualan)
            ->addColumn('user_nama', function ($penjualan) {
                return $penjualan->user->nama;
            })
            ->addColumn('aksi', function ($penjualan) {
                return view('Penjualan.aksi', compact('penjualan'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}



