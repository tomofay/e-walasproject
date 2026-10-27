<?php

namespace App\Imports;

use App\Models\Kakom;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KakomImport implements ToModel, WithHeadingRow 
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
    
    public function model(array $row)
    {
        $nama = trim((string) ($row['nama'] ?? ''));
        if ($nama === '') {
            return null;
        }

        return new Kakom([
        'nama' => $nama,
        'no_wa' => $row['no_wa'] ?? null,
        'password' => Hash::make((string) ($row['password'] ?? '')),
        'kompetensi' => $row['kompetensi'] ?? null,
        ]);
    }
}
