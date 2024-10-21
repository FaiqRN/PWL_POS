<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class LevelController extends Controller{


    public function index(Request $request){
        $breadcrumb = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem',
            'list' => ['Home', 'Level']
        ];


        if ($request->ajax()) {
            return $this->getLevelData();
        }


        return view('level.index', compact('breadcrumb'));
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];
     
        return view('level.create', compact('breadcrumb'));
    }


    public function store(Request $request){
        $validated = $request->validate([
            'level_kode' => 'required|unique:m_level,level_kode|max:255',
            'level_nama' => 'required|max:255',
        ]);


        try {
            Level::create($validated);
            return redirect()->route('level.index')->with('success', 'Level berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating level: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan level.')->withInput();
        }
    }


    public function destroy($id){
        try {
            $level = Level::findOrFail($id);
            $level->delete();
            return redirect()->route('level.index')->with('success', 'Level berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting level: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus level.');
        }
    }


    private function getLevelData(){
        $levels = Level::query();
        return DataTables::of($levels)
            ->addColumn('aksi', function ($level) {
                return view('level.aksi', compact('level'));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}



