<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTables extends Migration{
    public function up(){
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->foreignId('user_id')->constrained('m_user', 'user_id');
            $table->string('penjualan_kode', 20)->unique();
            $table->string('pembeli', 50);
            $table->dateTime('penjualan_tanggal');
            $table->timestamps();
        });

        Schema::create('t_penjualan_detail', function (Blueprint $table) {
            $table->id('penjualan_detail_id');
            $table->foreignId('penjualan_id')->constrained('t_penjualan', 'penjualan_id')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('m_barang', 'barang_id');
            $table->integer('jumlah');
            $table->decimal('harga', 15, 2);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('t_penjualan_detail');
        Schema::dropIfExists('t_penjualan');
    }
}