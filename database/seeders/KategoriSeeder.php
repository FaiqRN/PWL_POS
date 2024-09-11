<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            ['kategori_id' => 1, 
            'kategori_kode' => 'AA', 
            'kategori_nama' => 'Bumbu dapur'],

            ['kategori_id' => 2, 
            'kategori_kode' => 'BB', 
            'kategori_nama' => 'Sayur segar'],

            ['kategori_id' => 3, 
            'kategori_kode' => 'CC', 
            'kategori_nama' => 'Buah-buahan'],

            ['kategori_id' => 4, 
            'kategori_kode' => 'DD', 
            'kategori_nama' => 'Daging'],

            ['kategori_id' => 5, 
            'kategori_kode' => 'EE', 
            'kategori_nama' => 'Beras'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
