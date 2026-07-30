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
        Schema::create('detail_jadwal_pikets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwalpikets_id');
            $table->unsignedBigInteger('siswas_id');
            $table->timestamps();
            $table->foreign('jadwalpikets_id')->references('id')->on('jadwal_pikets')->onDelete('cascade');
    
            // Foreign Key untuk menghubungkan ke tabel siswas
            $table->foreign('siswas_id')->references('id')->on('siswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jadwal_pikets');
    }
};
