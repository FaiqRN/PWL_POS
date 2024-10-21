<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Supplier extends Model{


    use HasFactory;


    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['supplier_kode','supplier_nama','supplier_alamat'];


    public $timestamps = false;


    public static function generateUniqueCode(){
        $code = 'SUP' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        while (self::where('supplier_kode', $code)->exists()) {
            $code = 'SUP' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }
        return $code;
    }
}





