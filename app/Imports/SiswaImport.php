<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Rombel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow(): int
    {
        return 6;
    }
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $rombel = Rombel::where('nama_kelas', $row['rombel'])->first();
            if($rombel != null){
                Siswa::create([
                    'nama' => $row['nama'],
                    'rombels_id' => $rombel['id'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'no_wa' => $row['no_wa'],
                    'password' => Hash::make($row['password']),
                    'status' => $row['status'],
                ]);
            }else {
                \Log::info("Rombel not found for: " . $row['rombel']);
        }
    }
}
}