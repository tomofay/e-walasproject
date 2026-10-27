<?php

namespace Tests\Feature;

use App\Models\KeluarRombel;
use App\Support\AcademicYear;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KeluarRombelAcademicPeriodTest extends TestCase
{
    public function test_outgoing_student_periods_come_from_recorded_data(): void
    {
        $this->post('/loginadmin', [
            'nama' => 'admin',
            'password' => $this->password(),
        ])->assertRedirect('/adminpage');

        $record = KeluarRombel::query()->firstOrFail();
        $this->assertSame(
            ['year' => $record->academic_year, 'status' => $record->semester],
            AcademicYear::forDate($record->created_at)
        );

        $this->get('/tahunajaran')
            ->assertOk()
            ->assertSee($record->academic_year)
            ->assertSee($record->semester)
            ->assertDontSee('2024/2025 - GANJIL');

        $this->get('/keluarrombeldata')
            ->assertOk()
            ->assertSee($record->academic_year)
            ->assertSee($record->semester);

        $this->get('/keluarrombeldata?academic_year='.$record->academic_year.'&semester='.$record->semester)
            ->assertOk()
            ->assertSee($record->siswa->rombel->nama_kelas);

        $this->get(route('detail.keluarormbel', [
            'rombels_id' => $record->rombels_id,
            'academic_year' => $record->academic_year,
            'semester' => $record->semester,
        ]))
            ->assertOk()
            ->assertSee($record->academic_year)
            ->assertSee($record->siswa->nama);
    }

    public function test_existing_records_have_academic_period_values(): void
    {
        $this->assertSame(
            0,
            DB::table('keluar_rombels')->whereNull('academic_year')->orWhereNull('semester')->count()
        );
    }

    public function test_details_are_filtered_to_the_selected_academic_period(): void
    {
        $currentRecord = KeluarRombel::query()->firstOrFail();
        $historicalStudent = DB::table('siswas')
            ->where('rombels_id', $currentRecord->rombels_id)
            ->where('id', '!=', $currentRecord->siswa_id)
            ->first();
        $this->assertNotNull($historicalStudent);

        KeluarRombel::create([
            'siswa_id' => $historicalStudent->id,
            'keterangan' => 'tidak_naik_kelas',
            'rombels_id' => $currentRecord->rombels_id,
            'academic_year' => '2024/2025',
            'semester' => 'GENAP',
        ]);

        $this->post('/loginadmin', [
            'nama' => 'admin',
            'password' => $this->password(),
        ]);

        $this->get('/keluarrombeldata')
            ->assertOk()
            ->assertSee('2024/2025')
            ->assertSee('GENAP');

        $this->get(route('detail.keluarormbel', [
            'rombels_id' => $currentRecord->rombels_id,
            'academic_year' => '2024/2025',
            'semester' => 'GENAP',
        ]))
            ->assertOk()
            ->assertSee($historicalStudent->nama)
            ->assertDontSee($currentRecord->siswa->nama);
    }
}
