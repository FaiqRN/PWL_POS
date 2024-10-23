<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStokTable extends Migration{
    public function up(){
        Schema::table('t_stok', function (Blueprint $table) {
            
            $table->dropForeign(['supplier_id']);
            
            $table->unsignedBigInteger('supplier_id')->nullable()->change();
            
            $table->foreign('supplier_id')
                  ->references('supplier_id')
                  ->on('m_supplier')
                  ->onDelete('cascade')
                  ->nullable();
        });
    }

    public function down(){
        Schema::table('t_stok', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->unsignedBigInteger('supplier_id')->change();
            $table->foreign('supplier_id')
                  ->references('supplier_id')
                  ->on('m_supplier');
        });
    }
}
