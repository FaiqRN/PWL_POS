<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'id';
    protected $fillable = ['penjualan_id','barang_id','harga','jumlah'];

    public function penjualan(){
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}