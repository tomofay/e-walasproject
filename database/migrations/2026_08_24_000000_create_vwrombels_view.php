<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS vwrombels");
        DB::statement("
            CREATE VIEW vwrombels AS
            SELECT
                r.id AS rombel_id,
                r.tingkat,
                r.kompetensi,
                r.nama_kelas,
                r.walas_id,
                w.nama AS walas_nama,
                w.no_wa
            FROM rombels r
            LEFT JOIN walas w ON r.walas_id = w.id
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vwrombels");
    }
};
