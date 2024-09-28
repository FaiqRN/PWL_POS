<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
    protected $fillable = ['level_kode', 'level_nama'];
    public $timestamps = true;  
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function users()
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }
}