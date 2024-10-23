<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model{
    use HasFactory;

    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    
    protected $fillable = [
        'user_id',
        'penjualan_kode',
        'pembeli',
        'penjualan_tanggal'
    ];

    protected $dates = ['penjualan_tanggal'];

    public function user(){
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function details(){
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }

    public static function generateKodePenjualan(){
        $lastPenjualan = self::orderBy('penjualan_id', 'desc')->first();
        $newNumber = $lastPenjualan ? intval(substr($lastPenjualan->penjualan_kode, 3)) + 1 : 1;
        return 'PNJ' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}