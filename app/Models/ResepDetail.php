<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepDetail extends Model
{
    protected $table        = 'resep_detail';
    protected $primaryKey   = 'resep_detail_id';
    public $timestamps      = false;
    protected $fillable     = [
        'resep_id',
        'obatalkes_id',
        'signa_id',
        'qty',
        'is_racikan',
        'racikan_id'
    ];

    public function resep() {
        return $this->belongsTo(Resep::class, 'resep_id');
    }

    public function obatalkes() {
        return $this->belongsTo(Obatalkes::class, 'obatalkes_id');
    }

    public function signa() {
        return $this->belongsTo(Signa::class, 'signa_id');
    }

    public function racikan() {
        return $this->belongsTo(Racikan::class, 'racikan_id');
    }
}
