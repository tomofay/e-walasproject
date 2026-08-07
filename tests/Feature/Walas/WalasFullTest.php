<?php

namespace Tests\Feature\Walas;

use Tests\TestCase;
use App\Models\Siswa;
use App\Models\AgendaKegiatanWalas;

class WalasFullTest extends TestCase
{
    private string $walasNama = 'Budi Santoso, S.Pd.';

    protected function manualLogin(): void
    {
        session()->put('walas_id', 1);
    }

    // ═══════ LOGIN ═══════

    public function test_login_page_loads(): void
    {
        $this->get('/logingtk')->assertStatus(200);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->post('/logingtk', [
            'nama'     => $this->walasNama,
            'password' => 'wrongpassword',
        ])->assertSessionHasErrors();
    }

    // ═══════ DATA SISWA ═══════

    public function test_siswadata_returns_200(): void
    {
        $this->manualLogin();
        $this->get('/siswadata')->assertStatus(200);
    }

    public function test_store_siswa(): void
    {
        $this->manualLogin();

        $this->post('/siswadata/tambah/store', [
            'nama'          => 'Test Siswa Baru',
            'rombels_id'    => 1,
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081234567890',
            'password'      => '12345678',
            'status'        => 'aktif',
        ])->assertRedirect();

        $this->assertDatabaseHas('siswas', ['nama' => 'Test Siswa Baru']);
    }

    public function test_update_siswa(): void
    {
        $this->manualLogin();

        $siswa = Siswa::where('nama', 'Andi Pratama')->first();

        $this->put("/siswa/{$siswa->id}", [
            'nama'          => 'Andi Updated',
            'rombels_id'    => $siswa->rombels_id,
            'jenis_kelamin' => $siswa->jenis_kelamin,
            'no_wa'         => $siswa->no_wa,
            'status'        => 'aktif',
        ])->assertRedirect('/siswadata');

        $this->assertDatabaseHas('siswas', ['nama' => 'Andi Updated']);
    }

    public function test_hapussiswa(): void
    {
        $this->manualLogin();

        $siswa = Siswa::create([
            'nama'          => 'Delete Me',
            'rombels_id'    => 1,
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081999999999',
            'password'      => bcrypt('123'),
            'status'        => 'aktif',
        ]);

        $this->get("/hapussiswa/{$siswa->id}")->assertRedirect('/siswadata');
        $this->assertDatabaseMissing('siswas', ['id' => $siswa->id]);
    }

    // ═══════ ALL MODULES SMOKE ═══════

    public function test_all_walas_modules(): void
    {
        $this->manualLogin();

        $modules = [
            '/adminwalas',
            '/identitaskelas',
            '/strukturorganisasi',
            '/jadwalkbm',
            '/jadwalpiket',
            '/denahkerjakelompok',
            '/serahterimarapor',
            '/lembarpengesahan',
            '/presensi',
            '/homevisit',
            '/homevisitcreate',
            '/bukutamuortu',
            '/bukutamuortucreate',
            '/agendawalas',
            '/catatankasus',
            '/daftarpesertadidik',
            '/daftarpesertadidikcreate',
            '/rekapjumlahsiswa',
            '/rekapjumlahsiswacreate',
            '/persentasesosialekonomi',
            '/persentasesosialekonomicreate',
            '/prestasisiswa',
            '/beritaacarakenaikan',
            '/beritaacarakelulusan',
            '/beritaacaraserahterima',
            '/rencana_kegiatan/ganjil',
            '/rencana_kegiatan/genap',
            '/pendapatanortu',
            '/grafikjaraktempuh',
            '/profilewalas',
        ];

        $failed = [];
        foreach ($modules as $url) {
            $status = $this->get($url)->getStatusCode();
            if (! in_array($status, [200, 302])) {
                $failed[] = "{$url} → {$status}";
            }
        }

        $this->assertEmpty($failed, implode("\n", $failed));
    }

    // ═══════ AGENDA CRUD ═══════

    public function test_agenda_create(): void
    {
        $this->manualLogin();

        $this->post('/agendawalas/store', [
            'hari'           => 'Senin',
            'tanggal'        => now()->format('Y-m-d'),
            'nama_kegiatan'  => 'Test Kegiatan',
            'hasil'          => 'Test Hasil',
            'waktu'          => '08:00',
            'keterangan'     => 'Test',
            'tanggalttd'     => now()->format('Y-m-d'),
        ])->assertRedirect('/agendawalas');

        $this->assertDatabaseHas('agenda_kegiatan_walas', ['nama_kegiatan' => 'Test Kegiatan']);
    }

    public function test_agenda_update_and_delete(): void
    {
        $this->manualLogin();

        $agenda = AgendaKegiatanWalas::create([
            'walas_id'       => 1,
            'hari'           => 'Senin',
            'tanggal'        => now()->format('Y-m-d'),
            'nama_kegiatan'  => 'Old',
            'hasil'          => 'Old',
            'waktu'          => '08:00',
            'keterangan'     => 'Old',
            'tanggalttd'     => now()->format('Y-m-d'),
        ]);

        $this->put("/agendawalas/{$agenda->id}", [
            'hari'           => 'Selasa',
            'tanggal'        => now()->format('Y-m-d'),
            'nama_kegiatan'  => 'Updated',
            'hasil'          => 'Updated',
            'waktu'          => '09:00',
            'keterangan'     => 'Updated',
            'tanggalttd'     => now()->format('Y-m-d'),
        ])->assertRedirect('/agendawalas');

        $this->assertDatabaseHas('agenda_kegiatan_walas', ['nama_kegiatan' => 'Updated']);

        $this->get("/hapusagendawalas/{$agenda->id}")->assertRedirect('/agendawalas');
        $this->assertDatabaseMissing('agenda_kegiatan_walas', ['id' => $agenda->id]);
    }

    // ═══════ PROFILE ═══════

    public function test_profile_hides_password(): void
    {
        $this->manualLogin();
        $response = $this->get('/profilewalas');
        $response->assertStatus(200);
        $response->assertDontSee('$2y$');
    }

    public function test_profile_edit(): void
    {
        $this->manualLogin();

        $this->put('/profilewalas/1', [
            'nama'          => 'Budi Updated X',
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081199999999',
            'nip'           => '198501012010011001',
        ])->assertRedirect('/profilewalas');

        $this->assertDatabaseHas('walas', ['nama' => 'Budi Updated X']);
    }
}
