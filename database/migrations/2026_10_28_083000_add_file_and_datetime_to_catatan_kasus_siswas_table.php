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
        Schema::table('catatan_kasus_siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('catatan_kasus_siswas', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('siswas_id');
            }
            if (!Schema::hasColumn('catatan_kasus_siswas', 'waktu')) {
                $table->time('waktu')->nullable()->after('tanggal');
            }
            if (!Schema::hasColumn('catatan_kasus_siswas', 'file_kasus')) {
                $table->string('file_kasus')->nullable()->after('keterangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_kasus_siswas', function (Blueprint $table) {
            if (Schema::hasColumn('catatan_kasus_siswas', 'file_kasus')) {
                $table->dropColumn('file_kasus');
            }
            if (Schema::hasColumn('catatan_kasus_siswas', 'waktu')) {
                $table->dropColumn('waktu');
            }
            if (Schema::hasColumn('catatan_kasus_siswas', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
        });
    }
};
