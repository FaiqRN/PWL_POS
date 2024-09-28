<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller{

    public function index(Request $request){
        $breadcrumb = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem',
            'list' => ['Home', 'Supplier']
        ];

        if ($request->ajax()) {
            return $this->getSupplierData();
        }

        return view('Supplier.index', compact('breadcrumb'));
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];

        $supplierCode = Supplier::generateUniqueCode();

        return view('Supplier.create', compact('breadcrumb', 'supplierCode'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'supplier_kode' => 'required|unique:m_supplier,supplier_kode|max:10',
            'supplier_nama' => 'required|max:100',
            'supplier_alamat' => 'required|max:255',
        ]);
    
        DB::beginTransaction();
        try {
            $supplier = Supplier::create($validated);
            DB::commit();
            Log::info('Supplier created successfully:', $supplier->toArray());
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating supplier: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan supplier: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id){
        $supplier = Supplier::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];

        return view('Supplier.edit', compact('supplier', 'breadcrumb'));
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'supplier_kode' => 'required|max:10|unique:m_supplier,supplier_kode,'.$id.',supplier_id',
            'supplier_nama' => 'required|max:100',
            'supplier_alamat' => 'required|max:255',
        ]);

        DB::beginTransaction();
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($validated);
            DB::commit();
            Log::info('Supplier updated successfully:', $supplier->toArray());
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating supplier: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui supplier: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();
            DB::commit();
            Log::info('Supplier deleted successfully:', $supplier->toArray());
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting supplier: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus supplier: ' . $e->getMessage());
        }
    }

    public function show($id) {
        $supplier = Supplier::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        return view('Supplier.show', compact('supplier', 'breadcrumb'));
    }

    private function getSupplierData(){
        $supplier = Supplier::query();
        return DataTables::of($supplier)
            ->addColumn('aksi', function ($supplier) {
                return view('Supplier.aksi', compact('supplier'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}