<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW vwstrukturorganisasi AS
            SELECT
                s.id,
                s.walas_id,
                w.nama AS wali_kelas,
                s.kepala_sekolah,
                s.walas AS walas_nama,
                sk.nama AS ketua_kelas_nama,
                swak.nama AS waketua_kelas_nama,
                sb.nama AS bendahara_nama,
                sse.nama AS sekretaris_nama,
                skeb.nama AS seksi_kebersihan_nama,
                sper.nama AS seksi_perlengkapan_nama,
                skam.nama AS seksi_keamanan_nama,
                sker.nama AS seksi_kerohanian_nama,
                s.tanggal,
                s.ttdwalas_url,
                s.ttdkurikulum_url,
                s.kurikulum_id
            FROM struktur_organisasi_kelas s
            JOIN walas w ON s.walas_id = w.id
            LEFT JOIN siswas sk ON s.ketuakelas = sk.id
            LEFT JOIN siswas swak ON s.waketuakelas = swak.id
            LEFT JOIN siswas sb ON s.bendahara = sb.id
            LEFT JOIN siswas sse ON s.sekretaris = sse.id
            LEFT JOIN siswas skeb ON s.seksi_kebersihan = skeb.id
            LEFT JOIN siswas sper ON s.seksi_perlengkapan = sper.id
            LEFT JOIN siswas skam ON s.seksi_keamanan = skam.id
            LEFT JOIN siswas sker ON s.seksi_kerohanian = sker.id
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vwstrukturorganisasi");
    }
};
