<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keluar_rombels', function (Blueprint $table) {
            $table->dropForeign(['nama_siswa']);
            $table->renameColumn('nama_siswa', 'siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('keluar_rombels', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->renameColumn('siswa_id', 'nama_siswa');
            $table->foreign('nama_siswa')->references('id')->on('siswas')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
