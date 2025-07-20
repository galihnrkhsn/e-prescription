<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_stock_obat', function (Blueprint $table) {
            $table->increments('log_id');
            $table->unsignedInteger('obatalkes_id');
            $table->unsignedInteger('resep_id');
            $table->decimal('qty_keluar', 10, 2);
            $table->decimal('sisa_stok', 10, 2);
            $table->dateTime('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('obatalkes_id')->references('obatalkes_id')->on('obatalkes_m')->onDelete('restrict');
            $table->foreign('resep_id')->references('resep_id')->on('resep')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_stock_obat');
    }
};
