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
        Schema::create('prestasi_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id')->nullable();
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('siswas_id')->nullable(); 
            $table->foreign('siswas_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('rombels_id')->nullable(); 
            $table->foreign('rombels_id')->references('id')->on('rombels')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('jenis_prestasi', ['Akademik', 'Non-akademik'])->default('Akademik');
            $table->string('nama_prestasi');
            $table->string('nama_pembimbing')->nullable();
            $table->string('mata_lomba')->nullable();
            $table->string('tingkat')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('sertifikat_url',255)->nullable();
            $table->text('dokumentasi_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_siswas');
    }
};
