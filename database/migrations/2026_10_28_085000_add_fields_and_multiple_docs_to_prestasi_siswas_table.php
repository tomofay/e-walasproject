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
        Schema::table('prestasi_siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('prestasi_siswas', 'nama_pembimbing')) {
                $table->string('nama_pembimbing')->nullable()->after('nama_prestasi');
            }
            if (!Schema::hasColumn('prestasi_siswas', 'mata_lomba')) {
                $table->string('mata_lomba')->nullable()->after('nama_pembimbing');
            }
            if (!Schema::hasColumn('prestasi_siswas', 'tingkat')) {
                $table->string('tingkat')->nullable()->after('mata_lomba');
            }
            if (!Schema::hasColumn('prestasi_siswas', 'lokasi')) {
                $table->string('lokasi')->nullable()->after('tingkat');
            }
            $table->unsignedBigInteger('walas_id')->nullable()->change();
            $table->text('dokumentasi_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi_siswas', function (Blueprint $table) {
            if (Schema::hasColumn('prestasi_siswas', 'lokasi')) {
                $table->dropColumn('lokasi');
            }
            if (Schema::hasColumn('prestasi_siswas', 'tingkat')) {
                $table->dropColumn('tingkat');
            }
            if (Schema::hasColumn('prestasi_siswas', 'mata_lomba')) {
                $table->dropColumn('mata_lomba');
            }
            if (Schema::hasColumn('prestasi_siswas', 'nama_pembimbing')) {
                $table->dropColumn('nama_pembimbing');
            }
            $table->string('dokumentasi_url', 255)->nullable()->change();
        });
    }
};
