<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obatalkes extends Model
{
    protected $table        = 'obatalkes_m';
    protected $primaryKey   = 'obatalkes_id';
    public $timestamps      = false;
    protected $fillable     = [
        'obatalkes_id',
        'obatalkes_nama',
        'stok',
        'additional_data',
        'created_date',
        'created_by',
        'modified_count',
        'last_modified_date',
        'last_modified_by',
        'is_deleted',
        'is_active',
        'deleted_date',
        'deleted_by'
    ];

    public function details() {
        return $this->hasMany(ResepDetail::class, 'obatalkes_id');
    }
}
