<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        return view('supplier.index', compact('breadcrumb'));
    }

    public function list()
    {
        $supplier = Supplier::query();
        return DataTables::of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return view('supplier.action-buttons', compact('supplier'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $supplierCode = Supplier::generateUniqueCode();
        return view('supplier.create', compact('supplierCode'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_kode' => 'required|unique:m_supplier,supplier_kode|max:10',
            'supplier_nama' => 'required|max:100',
            'supplier_alamat' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $supplier = Supplier::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Supplier berhasil ditambahkan.',
            'data' => $supplier
        ]);
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'supplier_kode' => 'required|max:10|unique:m_supplier,supplier_kode,'.$id.',supplier_id',
            'supplier_nama' => 'required|max:100',
            'supplier_alamat' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $supplier = Supplier::findOrFail($id);
        $supplier->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Supplier berhasil diperbarui.',
            'data' => $supplier
        ]);
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.show', compact('supplier'));
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json([
            'status' => true,
            'message' => 'Supplier berhasil dihapus.'
        ]);
    }
}