<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Penjualan extends Model{
   
    use HasFactory;


    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    protected $fillable = ['user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal'];


    public function user(){
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }


    public static function generateKodePenjualan() {
    $lastPenjualan = self::orderBy('penjualan_id', 'desc')->first();
    if ($lastPenjualan) {
        $lastNumber = intval(substr($lastPenjualan->penjualan_kode, 3));
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }
    return 'pnc' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }


    public function details(){
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }
}



