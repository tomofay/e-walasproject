<?php

namespace App\Imports;

use App\Models\Kepsek;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KepsekImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kepsek([
        'nama' => $row['nama'],
        'no_wa' => $row['no_wa'],
        'password' => Hash::make($row['password']),
        ]);
    }
}
