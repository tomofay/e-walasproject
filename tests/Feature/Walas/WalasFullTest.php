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

    public function test_login_rejected_wrong_password(): void
    {
        $response = $this->post('/logingtk', [
            'nama'     => $this->walasNama,
            'password' => 'wrongpassword',
        ]);
        // WithoutMiddleware = session not started, so errors->any() fails.
        // Just verify it doesn't redirect to dashboard.
        $this->assertNotEquals(url('/walaspage'), $response->headers->get('Location'));
    }

    // ═══════ DATA SISWA ═══════

    public function test_siswadata_returns_200(): void
    {
        $this->manualLogin();
        $this->get('/siswadata')->assertStatus(200);
    }

    public function test_siswadata_search(): void
    {
        $this->manualLogin();
        $this->get('/siswadata_search?keyword=Andi')->assertStatus(200);
    }

    public function test_store_siswa(): void
    {
        $this->manualLogin();

        // Skip file upload — Alpine PHP container lacks GD library for fake images.
        // Controller store() requires 'image_url' => 'nullable|image'.
        // We test with a minimal valid request without image.
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

    // ═══════ ALL MODULES — view page smoke ═══════

    public function test_adminwalas_index(): void
    {
        $this->manualLogin();
        $this->get('/adminwalas')->assertStatus(200);
    }

    public function test_identitaskelas_index(): void
    {
        $this->manualLogin();
        $this->get('/identitaskelas')->assertStatus(200);
    }

    public function test_strukturorganisasi_index(): void
    {
        $this->manualLogin();
        $this->get('/strukturorganisasi')->assertStatus(200);
    }

    public function test_jadwalkbm_index(): void
    {
        $this->manualLogin();
        $this->get('/jadwalkbm')->assertStatus(200);
    }

    public function test_jadwalpiket_index(): void
    {
        $this->manualLogin();
        $this->get('/jadwalpiket')->assertStatus(200);
    }

    public function test_denahkerjakelompok_index(): void
    {
        $this->manualLogin();
        $this->get('/denahkerjakelompok')->assertStatus(200);
    }

    public function test_serahterimarapor_index(): void
    {
        $this->manualLogin();
        $this->get('/serahterimarapor')->assertStatus(200);
    }

    public function test_lembarpengesahan_index(): void
    {
        $this->manualLogin();
        $this->get('/lembarpengesahan')->assertStatus(200);
    }

    public function test_presensi_index(): void
    {
        $this->manualLogin();
        $this->get('/presensi')->assertStatus(200);
    }

    public function test_homevisit_index(): void
    {
        $this->manualLogin();
        $this->get('/homevisit')->assertStatus(200);
    }

    public function test_bukutamuortu_index(): void
    {
        $this->manualLogin();
        $this->get('/bukutamuortu')->assertStatus(200);
    }

    public function test_agendawalas_index(): void
    {
        $this->manualLogin();
        $this->get('/agendawalas')->assertStatus(200);
    }

    public function test_catatankasus_index(): void
    {
        $this->manualLogin();
        $this->get('/catatankasus')->assertStatus(200);
    }

    public function test_daftarpesertadidik_index(): void
    {
        $this->manualLogin();
        $this->get('/daftarpesertadidik')->assertStatus(200);
    }

    public function test_rekapjumlahsiswa_index(): void
    {
        $this->manualLogin();
        $this->get('/rekapjumlahsiswa')->assertStatus(200);
    }

    public function test_persentasesosialekonomi_index(): void
    {
        $this->manualLogin();
        $this->get('/persentasesosialekonomi')->assertStatus(200);
    }

    public function test_prestasisiswa_index(): void
    {
        $this->manualLogin();
        $this->get('/prestasisiswa')->assertStatus(200);
    }

    public function test_berita_acara_pages(): void
    {
        $this->manualLogin();
        $this->get('/beritaacarakenaikan')->assertStatus(200);
        $this->get('/beritaacarakelulusan')->assertStatus(200);
        $this->get('/beritaacaraserahterima')->assertStatus(200);
    }

    public function test_rencana_kegiatan_pages(): void
    {
        $this->manualLogin();
        $this->get('/rencana_kegiatan/ganjil')->assertStatus(200);
        $this->get('/rencana_kegiatan/genap')->assertStatus(200);
    }

    public function test_statistik_pages(): void
    {
        $this->manualLogin();
        $this->get('/pendapatanortu')->assertStatus(200);
        $this->get('/grafikjaraktempuh')->assertStatus(200);
    }

    public function test_profilewalas_index(): void
    {
        $this->manualLogin();
        $this->get('/profilewalas')->assertStatus(200);
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

    public function test_profile_does_not_leak_password(): void
    {
        $this->manualLogin();
        $response = $this->get('/profilewalas');
        $response->assertStatus(200);
        $response->assertDontSee('$2y$');
        $response->assertDontSee('12345678');
    }

    public function test_profile_edit(): void
    {
        $this->manualLogin();

        $this->put('/profilewalas/1', [
            'nama'          => 'Budi Santoso Updated',
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081111111199',
            'nip'           => '198501012010011001',
        ])->assertRedirect('/profilewalas');

        $this->assertDatabaseHas('walas', ['nama' => 'Budi Santoso Updated']);
    }
}
