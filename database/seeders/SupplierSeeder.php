<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            ['supplier_id'=>1,
            'supplier_kode'=>'SUP4532',
            'supplier_nama'=>'PT. ICIKIWIR',
            'supplier_alamat'=> 'jl.Patimura'],

            ['supplier_id'=>2,
            'supplier_kode'=>'SUP9078',
            'supplier_nama'=>'PT. ASOLOLE',
            'supplier_alamat'=> 'jl.Diponergoro'],

            ['supplier_id'=>3,
            'supplier_kode'=>'SUP3601',
            'supplier_nama'=>'PT. IHIR',
            'supplier_alamat'=> 'jl.Antasari'],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
