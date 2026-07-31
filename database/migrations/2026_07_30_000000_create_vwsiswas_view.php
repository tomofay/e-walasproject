<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW vwsiswas AS
            SELECT
                r.id,
                s.id AS siswa_id,
                r.nama_kelas,
                s.nama AS siswa_nama,
                s.jenis_kelamin,
                s.no_wa,
                s.image_url,
                s.status,
                s.keterangan,
                s.rombels_id,
                r.tingkat,
                r.kompetensi,
                r.walas_id
            FROM siswas s
            JOIN rombels r ON s.rombels_id = r.id
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vwsiswas");
    }
};
