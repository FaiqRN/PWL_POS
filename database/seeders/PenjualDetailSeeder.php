<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'penjualan_id' => 1, 'barang_id' => 1, 'harga' => 1500, 'jumlah' => 2],
            ['id' => 2, 'penjualan_id' => 1, 'barang_id' => 2, 'harga' => 6000, 'jumlah' => 1],
            ['id' => 3, 'penjualan_id' => 1, 'barang_id' => 3, 'harga' => 2500, 'jumlah' => 3],
            ['id' => 4, 'penjualan_id' => 2, 'barang_id' => 4, 'harga' => 3000, 'jumlah' => 2],
            ['id' => 5, 'penjualan_id' => 2, 'barang_id' => 5, 'harga' => 3000, 'jumlah' => 1],
            ['id' => 6, 'penjualan_id' => 2, 'barang_id' => 6, 'harga' => 3000, 'jumlah' => 3],
            ['id' => 7, 'penjualan_id' => 3, 'barang_id' => 7, 'harga' => 8000, 'jumlah' => 2],
            ['id' => 8, 'penjualan_id' => 3, 'barang_id' => 8, 'harga' => 12000, 'jumlah' => 1],
            ['id' => 9, 'penjualan_id' => 3, 'barang_id' => 9, 'harga' => 10000, 'jumlah' => 3],
            ['id' => 10, 'penjualan_id' => 4, 'barang_id' => 10, 'harga' => 15000, 'jumlah' => 2],
            ['id' => 11, 'penjualan_id' => 4, 'barang_id' => 11, 'harga' => 20000, 'jumlah' => 1],
            ['id' => 12, 'penjualan_id' => 4, 'barang_id' => 12, 'harga' => 30000, 'jumlah' => 3],
            ['id' => 13, 'penjualan_id' => 5, 'barang_id' => 13, 'harga' => 50000, 'jumlah' => 2],
            ['id' => 14, 'penjualan_id' => 5, 'barang_id' => 14, 'harga' => 12000, 'jumlah' => 1],
            ['id' => 15, 'penjualan_id' => 5, 'barang_id' => 15, 'harga' => 11000, 'jumlah' => 3],
            ['id' => 16, 'penjualan_id' => 6, 'barang_id' => 1, 'harga' => 1500, 'jumlah' => 2],
            ['id' => 17, 'penjualan_id' => 6, 'barang_id' => 2, 'harga' => 6000, 'jumlah' => 1],
            ['id' => 18, 'penjualan_id' => 6, 'barang_id' => 3, 'harga' => 2500, 'jumlah' => 3],
            ['id' => 19, 'penjualan_id' => 7, 'barang_id' => 4, 'harga' => 3000, 'jumlah' => 2],
            ['id' => 20, 'penjualan_id' => 7, 'barang_id' => 5, 'harga' => 3000, 'jumlah' => 1],
            ['id' => 21, 'penjualan_id' => 7, 'barang_id' => 6, 'harga' => 3000, 'jumlah' => 3],
            ['id' => 22, 'penjualan_id' => 8, 'barang_id' => 7, 'harga' => 8000, 'jumlah' => 2],
            ['id' => 23, 'penjualan_id' => 8, 'barang_id' => 8, 'harga' => 12000, 'jumlah' => 1],
            ['id' => 24, 'penjualan_id' => 8, 'barang_id' => 9, 'harga' => 10000, 'jumlah' => 3],
            ['id' => 25, 'penjualan_id' => 9, 'barang_id' => 10, 'harga' => 15000, 'jumlah' => 2],
            ['id' => 26, 'penjualan_id' => 9, 'barang_id' => 11, 'harga' => 20000, 'jumlah' => 1],
            ['id' => 27, 'penjualan_id' => 9, 'barang_id' => 12, 'harga' => 30000, 'jumlah' => 3],
            ['id' => 28, 'penjualan_id' => 10, 'barang_id' => 13, 'harga' => 50000, 'jumlah' => 2],
            ['id' => 29, 'penjualan_id' => 10, 'barang_id' => 14, 'harga' => 12000, 'jumlah' => 1],
            ['id' => 30, 'penjualan_id' => 10, 'barang_id' => 15, 'harga' => 11000, 'jumlah' => 3],
        ];
        DB::table('t_penjualan_detail')->insert($data);
    }
}
