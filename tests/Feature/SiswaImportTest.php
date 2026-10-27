<?php

namespace Tests\Feature;

use App\Imports\SiswaImport;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SiswaImportTest extends TestCase
{
    public function test_import_creates_student_with_hashed_password(): void
    {
        $rombel = Rombel::query()->firstOrFail();

        (new SiswaImport())->collection(new Collection([new Collection([
            'nama' => 'Siswa Import Test',
            'rombel' => $rombel->nama_kelas,
            'jenis_kelamin' => 'Laki-laki',
            'no_wa' => '081234567890',
            'password' => ' 12345678 ',
            'status' => 'aktif',
        ])]));

        $siswa = Siswa::query()->where('nama', 'Siswa Import Test')->firstOrFail();
        $this->assertSame($rombel->id, $siswa->rombels_id);
        $this->assertTrue(Hash::check(' 12345678 ', $siswa->password));
    }

    public function test_import_rejects_invalid_rows_before_writing_students(): void
    {
        $before = Siswa::query()->count();

        try {
            (new SiswaImport())->collection(new Collection([[
                'nama' => 'Siswa Tidak Valid',
                'rombel' => 'Rombel Tidak Ada',
                'jenis_kelamin' => 'Tidak valid',
                'no_wa' => '',
                'password' => '123',
                'status' => 'Tidak valid',
            ]]));
            $this->fail('Invalid import data should be rejected.');
        } catch (ValidationException $exception) {
            $this->assertStringContainsString(
                'Baris 6',
                implode(' ', $exception->errors()['file'])
            );
        }

        $this->assertSame($before, Siswa::query()->count());
    }

    public function test_import_rejects_templates_with_missing_headings(): void
    {
        try {
            (new SiswaImport())->collection(new Collection([new Collection(['nama_siswa' => 'Siswa'])]));
            $this->fail('A template with missing headings should be rejected.');
        } catch (ValidationException $exception) {
            $this->assertStringContainsString(
                'nama, rombel, jenis_kelamin, no_wa, password, status',
                implode(' ', $exception->errors()['file'])
            );
        }
    }
}
