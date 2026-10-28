<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('biodata_siswas', function (Blueprint $table) {
            $table->string('kepemilikan_rumah', 50)->nullable()->change();
            $table->string('jalur_masuk', 100)->nullable()->change();
            $table->string('nis', 20)->nullable()->change();
            $table->unsignedBigInteger('walas_id')->nullable()->change();
            $table->string('kelas', 255)->nullable()->change();
            $table->string('kompetensi', 100)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('biodata_siswas', function (Blueprint $table) {
            //
        });
    }
};
