<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signa extends Model
{
    protected $table        = 'signa_m';
    protected $primaryKey   = 'signa_id';
    public $timestamps      = false;

    protected $fillable     = [
        'signa_kode',
        'signa_nama',
        'additional_data',
        'created_date',
        'created_by',
        'modified_count',
        'last_modified_date',
        'last_modified_by',
        'is_deleted',
        'is_active',
        'deleted_date',
        'deleted_by',
    ];

    public function racikan() {
        return $this->hasMany(Racikan::class, 'signa_id');
    }

    public function details() {
        return $this->hasMany(ResepDetail::class, 'signa_id');
    }
}
