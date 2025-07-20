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
         Schema::create('racikan', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('racikan_id');
            $table->unsignedInteger('resep_id');
            $table->string('nama_racikan');
            $table->unsignedInteger('signa_id');

            $table->foreign('resep_id')->references('resep_id')->on('resep')->onDelete('cascade');
            $table->foreign('signa_id')->references('signa_id')->on('signa_m')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('racikan');
    }
};
