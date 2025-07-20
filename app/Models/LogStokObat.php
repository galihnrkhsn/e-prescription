<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogStokObat extends Model
{
    protected $table        = 'log_stock_obat';
    protected $primaryKey   = 'log_id';
    public $timestamps      = false;
    protected $fillable     = [
        'obatalkes_id',
        'resep_id',
        'qty_keluar',
        'sisa_stok',
        'created_date'
    ];

    public function obat() {
        return $this->belongsTo(Obatalkes::class, 'obatalkes_id', 'obatalkes_id');
    }

    public function resep() {
        return $this->belongsTo(Resep::class, 'resep_id', 'resep_id');
    }
}
