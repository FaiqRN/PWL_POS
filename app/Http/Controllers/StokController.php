<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index(Request $request){
        $breadcrumb = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem',
            'list' => ['Home', 'Stok']
        ];

        if ($request->ajax()) {
            return $this->getStokData();
        }

        return view('Stok.index', compact('breadcrumb'));
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];
    
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $users = UserModel::all();
    
        return view('Stok.create', compact('breadcrumb', 'suppliers', 'barangs', 'users'));
    }
    
    public function store(Request $request){
        $validated = $request->validate([
            'supplier_id' => 'required|exists:m_supplier,supplier_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'user_id' => 'required|exists:m_user,user_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);
    
        try {
            Stok::create($validated);
            return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating stok: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan stok.')->withInput();
        }
    }

    public function edit($id){
        $stok = Stok::findOrFail($id);
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $users = UserModel::all();
        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        return view('Stok.edit', compact('stok', 'suppliers', 'barangs', 'users', 'breadcrumb'));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:0',
        ]);

        try {
            $stok = Stok::findOrFail($id);
            $stok->update($validated);
            return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating stok: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui stok.')->withInput();
        }
    }

    public function destroy($id){
        try {
            $stok = Stok::findOrFail($id);
            $stok->delete();
            return redirect()->route('stok.index')->with('success', 'Stok berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting stok: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus stok.');
        }
    }

    private function getStokData(){
        $stok = Stok::with(['supplier', 'barang', 'user']);
        return DataTables::of($stok)
            ->addColumn('supplier_nama', function ($stok) {
                return $stok->supplier->supplier_nama;
            })
            ->addColumn('barang_nama', function ($stok) {
                return $stok->barang->barang_nama;
            })
            ->addColumn('user_nama', function ($stok) {
                return $stok->user->nama;
            })
            ->addColumn('aksi', function ($stok) {
                return view('Stok.aksi', compact('stok'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}