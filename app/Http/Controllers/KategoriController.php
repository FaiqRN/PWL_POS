<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori yang terdaftar dalam sistem',
            'list' => ['Home', 'Kategori']
        ];

        return view('kategori.index', compact('breadcrumb'));
    }

    public function list(){
        $kategori = Kategori::query();
        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                return view('kategori.action-buttons', compact('kategori'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create(){
        return view('kategori.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required|unique:m_kategori,kategori_kode|max:255',
            'kategori_nama' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        try {
            $kategori = Kategori::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil ditambahkan.',
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating kategori: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menambahkan kategori.'
            ], 500);
        }
    }

    public function edit($id){
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required|max:255|unique:m_kategori,kategori_kode,'.$id.',kategori_id',
            'kategori_nama' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->update($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil diperbarui.',
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating kategori: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kategori.'
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting kategori: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori.'
            ], 500);
        }
    }
}