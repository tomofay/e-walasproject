<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (Schema::getForeignKeys('daftar_peserta_didiks') as $foreignKey) {
            if ($foreignKey['foreign_table'] !== 'biodata_siswas'
                || ! array_intersect($foreignKey['columns'], ['nis', 'nisn'])) {
                continue;
            }

            $foreignKeyName = $foreignKey['name'] ?? $foreignKey['columns'];

            Schema::table('daftar_peserta_didiks', function (Blueprint $table) use ($foreignKeyName) {
                $table->dropForeign($foreignKeyName);
            });
        }
    }

    public function down(): void
    {
        //
    }
};
