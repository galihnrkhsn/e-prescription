<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table        = 'resep';
    protected $primaryKey   = 'resep_id';
    public $timestamps      = false;
    protected $fillable     = [
        'nama_resep',
        'is_racikan',
        'created_by'
    ];

    public function details(){
        return $this->hasMany(ResepDetail::class, 'resep_id');
    }

    public function racikans(){
        return $this->hasMany(Racikan::class, 'resep_id');
    }
}
