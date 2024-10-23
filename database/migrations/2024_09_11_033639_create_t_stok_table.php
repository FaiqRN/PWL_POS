<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokTable extends Migration{
    public function up(){
        Schema::create('t_stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->foreignId('supplier_id')->constrained('m_supplier', 'supplier_id');
            $table->foreignId('barang_id')->constrained('m_barang', 'barang_id');
            $table->foreignId('user_id')->constrained('m_user', 'user_id');
            $table->dateTime('stok_tanggal');
            $table->integer('stok_jumlah');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('t_stok');
    }
}
