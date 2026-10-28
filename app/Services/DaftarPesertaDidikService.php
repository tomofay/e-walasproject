<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\DaftarPesertaDidik;
use App\Models\Kurikulum;

class DaftarPesertaDidikService
{
    /**
     * Sinkronkan seluruh siswa di rombel tertentu dengan tabel daftar_peserta_didiks.
     */
    public static function syncRombel(Rombel $rombel): void
    {
        $walasId = $rombel->walas_id;
        if (! $walasId) {
            return;
        }

        $kurikulumId = optional(Kurikulum::first())->id ?? 1;
        $siswas = Siswa::where('rombels_id', $rombel->id)->with('biodata')->get();
        $siswaIds = $siswas->pluck('id')->all();

        // Pindahkan catatan daftar_peserta_didiks dari walas lama ke walas rombel saat ini
        if (! empty($siswaIds)) {
            DaftarPesertaDidik::whereIn('nama_siswa', $siswaIds)
                ->where('walas_id', '!=', $walasId)
                ->update(['walas_id' => $walasId]);
        }

        foreach ($siswas as $siswa) {
            $biodata = $siswa->biodata;
            $currentNis = $biodata?->nis ?? sprintf('2025%04d', $siswa->id);
            $currentNisn = $biodata?->nisn ?? sprintf('000%08d', 10000000 + $siswa->id);
            $jk = $siswa->jenis_kelamin ?? ($biodata?->jenis_kelamin ?? 'Laki-laki');
            $keterangan = $siswa->status ?? ($siswa->keterangan ?? 'Aktif');

            $existing = DaftarPesertaDidik::where('nama_siswa', $siswa->id)->first();

            if (! $existing) {
                DaftarPesertaDidik::create([
                    'walas_id' => $walasId,
                    'nama_siswa' => $siswa->id,
                    'nis' => $currentNis,
                    'nisn' => $currentNisn,
                    'jenis_kelamin' => $jk,
                    'keterangan' => $keterangan,
                    'tanggal' => now()->toDateString(),
                    'kurikulum_id' => $kurikulumId,
                ]);
            } else {
                $existing->update([
                    'walas_id' => $walasId,
                    'nis' => $currentNis ?: $existing->nis,
                    'nisn' => $currentNisn ?: $existing->nisn,
                    'jenis_kelamin' => $jk,
                    'keterangan' => $keterangan,
                ]);
            }
        }
    }

    /**
     * Sinkronkan seluruh rombel di sistem.
     */
    public static function syncAllRombels(): void
    {
        $rombels = Rombel::all();
        foreach ($rombels as $rombel) {
            self::syncRombel($rombel);
        }
    }
}
