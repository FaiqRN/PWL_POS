<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Barang extends Model
{
    use HasFactory;


    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = ['kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual'];


    public $timestamps = true;


    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }


    public static function generateUniqueCode(){
    $prefix = 'BRG';
    $code = $prefix . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        while (self::where('barang_kode', $code)->exists()) {
            $code = $prefix . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }
        return $code;
    }


    public function penjualanDetails(){
        return $this->hasMany(PenjualanDetail::class, 'barang_id', 'barang_id');
    }


}



