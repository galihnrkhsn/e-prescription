<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resep_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('resep_detail_id');
            $table->unsignedInteger('resep_id');
            $table->unsignedInteger('obatalkes_id');
            $table->unsignedInteger('signa_id');
            $table->decimal('qty', 10, 2);
            $table->boolean('is_racikan')->default(0);
            $table->unsignedInteger('racikan_id')->nullable();

            $table->foreign('resep_id')->references('resep_id')->on('resep')->onDelete('cascade');
            $table->foreign('obatalkes_id')->references('obatalkes_id')->on('obatalkes_m')->onDelete('restrict');
            $table->foreign('signa_id')->references('signa_id')->on('signa_m')->onDelete('restrict');
            $table->foreign('racikan_id')->references('racikan_id')->on('racikan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_detail');
    }
};
