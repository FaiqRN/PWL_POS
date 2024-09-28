<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller{

    public function index(Request $request){
        $breadcrumb = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem',
            'list' => ['Home', 'Barang']
        ];

        if ($request->ajax()) {
            return $this->getBarangData();
        }

        return view('Barang.index', compact('breadcrumb'));
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];
    
        $kategoris = Kategori::all();
        $barangCode = Barang::generateUniqueCode();
        return view('Barang.create', compact('breadcrumb', 'kategoris', 'barangCode'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|unique:m_barang,barang_kode|max:10',
            'barang_nama' => 'required|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        try {
            Barang::create($validated);
            return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan barang.')->withInput();
        }
    }

    public function edit($id){
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        return view('Barang.edit', compact('barang', 'kategoris', 'breadcrumb'));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'barang_kode' => 'required|max:10|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama' => 'required|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        try {
            $barang = Barang::findOrFail($id);
            $barang->update($validated);
            return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui barang.')->withInput();
        }
    }

    public function destroy($id){
        try {
            $barang = Barang::findOrFail($id);
            $barang->delete();
            return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus barang.');
        }
    }

    public function show($id){
        $barang = Barang::with('kategori')->findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        return view('Barang.show', compact('barang', 'breadcrumb'));
    }

    private function getBarangData(){
        $barang = Barang::with('kategori');
        return DataTables::of($barang)
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori->kategori_nama;
            })
            ->addColumn('aksi', function ($barang) {
                return view('Barang.aksi', compact('barang'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}