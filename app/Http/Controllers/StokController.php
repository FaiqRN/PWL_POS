<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem',
            'list' => ['Home', 'Stok']
        ];

        return view('stok.index', compact('breadcrumb'));
    }

    public function list()
    {
        $stok = Stok::with(['supplier', 'barang', 'user']);
        return DataTables::of($stok)
            ->addIndexColumn()
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
                return view('stok.action-buttons', compact('stok'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $users = UserModel::all();
        return view('stok.create', compact('suppliers', 'barangs', 'users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:m_supplier,supplier_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'user_id' => 'required|exists:m_user,user_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        try {
            $stok = Stok::create($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil ditambahkan.',
                'data' => $stok
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating stok: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menambahkan stok.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $stok = Stok::findOrFail($id);
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $users = UserModel::all();
        return view('stok.edit', compact('stok', 'suppliers', 'barangs', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        try {
            $stok = Stok::findOrFail($id);
            $stok->update($validator->validated());
            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil diperbarui.',
                'data' => $stok
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating stok: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memperbarui stok.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $stok = Stok::findOrFail($id);
            $stok->delete();
            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting stok: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus stok.'
            ], 500);
        }
    }
}