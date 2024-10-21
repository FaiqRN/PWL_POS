<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserModel extends Model
{
    use HasFactory;


    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['username', 'nama', 'password', 'level_id'];
    public function getRouteKeyName(){
        return 'user_id';
    }


    public function level(): BelongsTo{
        return $this->belongsTo(Level::class,'level_id','level_id');
    }
}

