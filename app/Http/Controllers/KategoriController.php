<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller{

    
    public function index(Request $request){
        $breadcrumb = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem',
            'list' => ['Home', 'Kategori']
        ];

        if ($request->ajax()) {
            return $this->getKategoriData();
        }

        return view('Kategori.index', compact('breadcrumb'));
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        return view('Kategori.create', compact('breadcrumb'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'kategori_kode' => 'required|unique:m_kategori,kategori_kode|max:255',
            'kategori_nama' => 'required|max:255',
        ]);

        try {
            Kategori::create($validated);
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating kategori: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan kategori.')->withInput();
        }
    }

    public function edit($id){
        $kategori = Kategori::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        return view('Kategori.edit', compact('kategori', 'breadcrumb'));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'kategori_kode' => 'required|max:255',
            'kategori_nama' => 'required|max:255',
        ]);

        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->update($validated);
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating kategori: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kategori.')->withInput();
        }
    }

    public function destroy($id){
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting kategori: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }

    private function getKategoriData(){
        $kategori = Kategori::query();
        return DataTables::of($kategori)
            ->addColumn('aksi', function ($kategori) {
                return view('Kategori.aksi', compact('kategori'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
