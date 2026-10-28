<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            // Drop foreign key constraints on nis and nisn if they exist
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.TABLE_CONSTRAINTS 
                WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = 'daftar_peserta_didiks' 
                  AND CONSTRAINT_TYPE = 'FOREIGN KEY'
            ");
            $fkNames = array_map(fn($item) => $item->CONSTRAINT_NAME, $foreignKeys);

            Schema::table('daftar_peserta_didiks', function (Blueprint $table) use ($fkNames) {
                if (in_array('daftar_peserta_didiks_nis_foreign', $fkNames)) {
                    $table->dropForeign('daftar_peserta_didiks_nis_foreign');
                }
                if (in_array('daftar_peserta_didiks_nisn_foreign', $fkNames)) {
                    $table->dropForeign('daftar_peserta_didiks_nisn_foreign');
                }
                $table->string('nis', 20)->nullable()->change();
                $table->string('nisn', 20)->nullable()->change();
            });
        } else {
            Schema::table('daftar_peserta_didiks', function (Blueprint $table) {
                $table->string('nis', 20)->nullable()->change();
                $table->string('nisn', 20)->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_peserta_didiks', function (Blueprint $table) {
            //
        });
    }
};
