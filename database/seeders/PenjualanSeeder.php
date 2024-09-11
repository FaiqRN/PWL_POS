<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 
            'user_id' => 3, 
            'pembeli' => 'faiq', 
            'penjual_kode' => 'pnc001', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'],

            ['penjualan_id' => 2, 
            'user_id' => 3, 
            'pembeli' => 'ramzy', 
            'penjual_kode' => 'pnc002', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'],

            ['penjualan_id' => 3, 
            'user_id' => 3, 
            'pembeli' => 'nabighah', 
            'penjual_kode' => 'pnc003', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'],

            ['penjualan_id' => 4, 
            'user_id' => 3, 
            'pembeli' => 'aiq', 
            'penjual_kode' => 'pnc004', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'],

            ['penjualan_id' => 5, 
            'user_id' => 3, 
            'pembeli' => 'ica', 
            'penjual_kode' => 'pnc005', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'], 

            ['penjualan_id' => 6, 
            'user_id' => 3, 
            'pembeli' => 'annisa', 
            'penjual_kode' => 'pnc006', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'],

            ['penjualan_id' => 7, 
            'user_id' => 3, 
            'pembeli' => 'prissilya', 
            'penjual_kode' => 'pnc007', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'],

            ['penjualan_id' => 8,
             'user_id' => 3, 
             'pembeli' => 'nisa', 
             'penjual_kode' => 'pnc008',
              'tanggal_penjualan' => '2025-01-05 00:00:00'],

            ['penjualan_id' => 9, 
            'user_id' => 3, 
            'pembeli' => 'ika', 
            'penjual_kode' => 'pnc009', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'],

            ['penjualan_id' => 10, 
            'user_id' => 3, 
            'pembeli' => 'damayanti', 
            'penjual_kode' => 'pnc010', 
            'tanggal_penjualan' => '2025-01-05 00:00:00'], 
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
