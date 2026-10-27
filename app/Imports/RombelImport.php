<?php

namespace App\Imports;

use App\Models\Walas;
use App\Models\Rombel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RombelImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow(): int
    {
        return 1;
    }
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $tingkat = trim((string) ($row['tingkat'] ?? ''));
            $kompetensi = trim((string) ($row['kompetensi'] ?? ''));
            $namaKelas = trim((string) ($row['nama_kelas'] ?? ''));
            $walasValue = trim((string) ($row['walas'] ?? $row['walas_id'] ?? ''));

            if ($tingkat === '' || $kompetensi === '' || $namaKelas === '' || $walasValue === '') {
                continue;
            }

            $walas = is_numeric($walasValue)
                ? Walas::find((int) $walasValue)
                : Walas::where('nama', $walasValue)->first();

            if ($walas !== null) {
                Rombel::create([
                    'tingkat' => $tingkat,
                    'kompetensi' => $kompetensi,
                    'nama_kelas' => $namaKelas,
                    'walas_id' => $walas->id,
                ]);
            } else {
                \Log::warning("Walas not found for: " . $walasValue);
            }
        }
    }
}