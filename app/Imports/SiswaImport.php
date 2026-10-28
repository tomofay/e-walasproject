<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Rombel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
        // The template has three instruction rows before the header row.
        return 5;
    }
    
    public function collection(Collection $rows)
    {
        $requiredHeadings = ['nama', 'rombel', 'jenis_kelamin', 'no_wa', 'password', 'status'];
        $firstRow = $rows->first();
        $headings = $firstRow instanceof Collection
            ? $firstRow->keys()->all()
            : (is_array($firstRow) ? array_keys($firstRow) : []);
        $missingHeadings = array_diff($requiredHeadings, $headings);

        if ($missingHeadings !== []) {
            throw ValidationException::withMessages([
                'file' => [
                    'Kolom template siswa tidak lengkap. Kolom yang tidak terbaca: '
                    . implode(', ', $missingHeadings)
                    . '. Pastikan header berada di baris 5.',
                ],
            ]);
        }

        $classes = Rombel::query()->get(['id', 'nama_kelas'])
            ->mapWithKeys(fn (Rombel $rombel) => [strtolower(trim($rombel->nama_kelas)) => $rombel->id]);
        $validRows = [];
        $errors = [];

        foreach ($rows->values() as $index => $row) {
            $rowNumber = $index + $this->headingRow() + 1;
            $nama = trim((string) ($row['nama'] ?? ''));
            $namaRombel = trim((string) ($row['rombel'] ?? ''));
            $jenisKelamin = trim((string) ($row['jenis_kelamin'] ?? ''));
            $noWa = trim((string) ($row['no_wa'] ?? ''));
            $password = (string) ($row['password'] ?? '');
            $status = trim((string) ($row['status'] ?? ''));

            if (implode('', [$nama, $namaRombel, $jenisKelamin, $noWa, $password, $status]) === '') {
                continue;
            }

            $rowErrors = [];
            if ($nama === '' || strlen($nama) > 255) {
                $rowErrors[] = 'nama wajib diisi dan maksimal 255 karakter';
            }
            if ($namaRombel === '') {
                $rowErrors[] = 'rombel wajib diisi';
            } elseif (! $classes->has(strtolower($namaRombel))) {
                $rowErrors[] = "rombel '{$namaRombel}' tidak ditemukan";
            }
            if (! in_array($jenisKelamin, ['Perempuan', 'Laki-laki'], true)) {
                $rowErrors[] = 'jenis_kelamin harus Perempuan atau Laki-laki';
            }
            if ($noWa === '' || strlen($noWa) > 15) {
                $rowErrors[] = 'no_wa wajib diisi dan maksimal 15 karakter';
            }
            if (trim($password) === '' || strlen($password) < 8) {
                $rowErrors[] = 'password wajib diisi minimal 8 karakter';
            }
            if (! in_array($status, ['aktif', 'nonaktif'], true)) {
                $rowErrors[] = 'status harus aktif atau nonaktif';
            }

            if ($rowErrors !== []) {
                $errors[] = "Baris {$rowNumber}: " . implode(', ', $rowErrors) . '.';
                continue;
            }

            $validRows[] = [
                'nama' => $nama,
                'rombels_id' => $classes->get(strtolower($namaRombel)),
                'jenis_kelamin' => $jenisKelamin,
                'no_wa' => $noWa,
                'password' => Hash::make($password),
                'status' => $status,
            ];
        }

        if ($errors !== []) {
            throw ValidationException::withMessages(['file' => $errors]);
        }

        if ($validRows === []) {
            throw ValidationException::withMessages([
                'file' => ['Tidak ada data siswa yang dapat diimpor. Periksa isi file mulai baris 6.'],
            ]);
        }

        DB::transaction(function () use ($validRows): void {
            foreach ($validRows as $row) {
                Siswa::create($row);
            }
        });

        \App\Services\DaftarPesertaDidikService::syncAllRombels();
    }
}