<?php

namespace App\Imports;

use App\Models\Kurikulum;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class KurikulumImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kurikulum([
            'nama' => $row['nama'],
            'no_wa' => $row['no_wa'],
            'password' => Hash::make($row['password']),
            'nip' => $row['nip'],
        ]);
    }
}
