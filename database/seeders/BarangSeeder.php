<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            ['barang_id'=>'1',
            'kategori_id'=>1,
            'barang_kode'=>'BRG21414',
            'barang_nama'=>'merica bubuk',
            'harga_beli'=>1000,
            'harga_jual'=>1500],

            ['barang_id'=>'2',
            'kategori_id'=>1,
            'barang_kode'=>'BRG5436',
            'barang_nama'=>'gula',
            'harga_beli'=>5000,
            'harga_jual'=>6000],

            ['barang_id'=>'3',
            'kategori_id'=>1,
            'barang_kode'=>'BRG6575',
            'barang_nama'=>'garam',
            'harga_beli'=>2000,
            'harga_jual'=>2500],

            ['barang_id'=>'4',
            'kategori_id'=>1,
            'barang_kode'=>'BRG2145',
            'barang_nama'=>'MSG',
            'harga_beli'=>2000,
            'harga_jual'=>3000],

            ['barang_id'=>'5',
            'kategori_id'=>2,
            'barang_kode'=>'BRG3124',
            'barang_nama'=>'bayam',
            'harga_beli'=>2000,
            'harga_jual'=>3000],

            ['barang_id'=>'6',
            'kategori_id'=>2,
            'barang_kode'=>'BRG8779',
            'barang_nama'=>'kangkung',
            'harga_beli'=>2000,
            'harga_jual'=>3000],

            ['barang_id'=>'7',
            'kategori_id'=>2,
            'barang_kode'=>'BRG2131',
            'barang_nama'=>'kubis',
            'harga_beli'=>5000,
            'harga_jual'=>8000],

            ['barang_id'=>'8',
            'kategori_id'=>3,
            'barang_kode'=>'BRG5764',
            'barang_nama'=>'jeruk',
            'harga_beli'=>10000,
            'harga_jual'=>12000],

            ['barang_id'=>'9',
            'kategori_id'=>3,
            'barang_kode'=>'BRG9089',
            'barang_nama'=>'pisang',
            'harga_beli'=>8000,
            'harga_jual'=>10000],

            ['barang_id'=>'10',
            'kategori_id'=>3,
            'barang_kode'=>'BRG4538',
            'barang_nama'=>'apel',
            'harga_beli'=>12000,
            'harga_jual'=>15000],

            ['barang_id'=>'11',
            'kategori_id'=>3,
            'barang_kode'=>'BRG1297',
            'barang_nama'=>'anggur',
            'harga_beli'=>18000,
            'harga_jual'=>20000],

            ['barang_id'=>'12',
            'kategori_id'=>4,
            'barang_kode'=>'BRG7863',
            'barang_nama'=>'daging ayam',
            'harga_beli'=>24000,
            'harga_jual'=>30000],

            ['barang_id'=>'13',
            'kategori_id'=>4,
            'barang_kode'=>'BRG53404',
            'barang_nama'=>' daging sapi',
            'harga_beli'=>45000,
            'harga_jual'=>50000],

            ['barang_id'=>'14',
            'kategori_id'=>5,
            'barang_kode'=>'BRG3457',
            'barang_nama'=>'beras merah',
            'harga_beli'=>10000,
            'harga_jual'=>12000],

            ['barang_id'=>'15',
            'kategori_id'=>5,
            'barang_kode'=>'BRG1246',
            'barang_nama'=>'beras ketang',
            'harga_beli'=>8000,
            'harga_jual'=>11000],
        ];
        DB::table('m_barang')->insert($data);
    }
}
