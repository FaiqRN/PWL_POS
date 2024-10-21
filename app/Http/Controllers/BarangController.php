<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem',
            'list' => ['Home', 'Barang']
        ];

        return view('barang.index', compact('breadcrumb'));
    }

    public function list()
    {
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

    public function create()
    {
        $kategoris = Kategori::all();
        $barangCode = Barang::generateUniqueCode();
        return view('barang.create', compact('kategoris', 'barangCode'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|unique:m_barang,barang_kode|max:10',
            'barang_nama' => 'required|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
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

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|max:10|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama' => 'required|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
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

    public function show($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function destroy($id)
    {
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
}