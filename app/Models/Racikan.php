<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Racikan extends Model
{
    protected $table        = 'racikan';
    protected $primaryKey   = 'racikan_id';
    public $timestamps      = false;
    protected $fillable     = [
        'resep_id',
        'nama_racikan',
        'signa_id'
    ];

    public function resep() {
        return $this->belongsTo(Resep::class, 'resep_id');
    }

    public function signa() {
        return $this->belongsTo(Signa::class, 'signa_id');
    }

    public function details() {
        return $this->hasMany(ResepDetail::class, 'racikan_id');
    }
}
