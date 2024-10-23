<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model{
    use HasFactory;

    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';
    
    protected $fillable = [
        'supplier_id',
        'barang_id',
        'user_id',
        'stok_tanggal',
        'stok_jumlah'
    ];

    protected $dates = ['stok_tanggal'];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }

    public function user(){
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}
