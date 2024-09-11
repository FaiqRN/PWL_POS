<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(){
        /*$data=[
            'kategori_kode'=>'Snk',
            'kategori_nama'=>'Snack/makanan ringan',
            'created_at'=>now()
        ];
        DB::table('m_kategori')->insert($data);
        return 'Insert data baru berhasil!!';*/

        //$row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama'=>'camilan']);
        //return 'update data berhasil, jumlah data yang di update: '. $row. 'baris';

        //$row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        //return 'delete data berhasil. jumlah data yang di hapus: ' . $row. 'baris';

        $data = DB::table('m_kategori')->get();
        return view('kategori', ['data'=>$data]);
    }
}
