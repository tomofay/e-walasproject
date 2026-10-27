<?php

namespace App\Imports;
use Illuminate\Support\Facades\Hash;
use App\Models\Walas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WalasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
      // Tentukan baris awal header data
    public function headingRow(): int
    {
        return 4;
    }
    
    public function model(array $row)
    {
        $nama = trim((string) ($row['nama'] ?? ''));
        if ($nama === '') {
            return null;
        }

        return new Walas([
        'nama' => $nama,
        'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
        'no_wa' => $row['no_wa'] ?? null,
        'password' => Hash::make((string) ($row['password'] ?? '')),
        'nip' => $row['nip'] ?? null,
        ]);
    }
}
