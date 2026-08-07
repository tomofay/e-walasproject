<?php

namespace Tests\Feature\Walas;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Siswa;
use App\Models\AgendaKegiatanWalas;
use App\Models\HomeVisit;
use App\Models\CatatanKasusSiswa;

class WalasFullTest extends TestCase
{
    use WithoutMiddleware;

    private string $walasNama = 'Budi Santoso, S.Pd.';

    // ── Helper: login as walas so session persists ──
    private function loginAndGetSession(): void
    {
        $this->post('/logingtk', [
            'nama'     => $this->walasNama,
            'password' => $this->password(),
        ]);

        // after redirect, Laravel stores walas_id in session
        session()->put('walas_id', 1);
    }

    // ════════════════════════════════════════
    // 1. AUTH
    // ════════════════════════════════════════

    public function test_walas_login_returns_redirect(): void
    {
        $this->post('/logingtk', [
            'nama'     => $this->walasNama,
            'password' => $this->password(),
        ])->assertRedirect('/walaspage');
    }

    public function test_walas_login_rejected_with_wrong_password(): void
    {
        $this->post('/logingtk', [
            'nama'     => $this->walasNama,
            'password' => 'wrongpassword',
        ])->assertRedirect('/logingtk');
    }

    // ════════════════════════════════════════
    // 2. DASHBOARD
    // ════════════════════════════════════════

    public function test_walas_dashboard_returns_200(): void
    {
        $this->loginAndGetSession();
        $this->get('/walaspage')->assertStatus(200)->assertSee('Budi Santoso');
    }

    // ════════════════════════════════════════
    // 3. DATA SISWA
    // ════════════════════════════════════════

    public function test_siswadata_returns_200(): void
    {
        $this->loginAndGetSession();
        $this->get('/siswadata')->assertStatus(200);
    }

    public function test_siswadata_search_returns_200(): void
    {
        $this->loginAndGetSession();
        $this->get('/siswadata_search?keyword=Andi')->assertStatus(200);
    }

    public function test_store_siswa_inserts_record(): void
    {
        $this->loginAndGetSession();

        $this->post('/siswadata/tambah/store', [
            'nama'          => 'Test Siswa',
            'rombels_id'    => 1,
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081234567890',
            'password'      => '12345678',
            'status'        => 'aktif',
        ])->assertRedirect();

        $this->assertDatabaseHas('siswas', ['nama' => 'Test Siswa']);
    }

    public function test_update_siswa_works(): void
    {
        $this->loginAndGetSession();

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

    public function test_delete_siswa_works(): void
    {
        $this->loginAndGetSession();

        $siswa = Siswa::create([
            'nama'          => 'To Delete',
            'rombels_id'    => 1,
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081000000000',
            'password'      => bcrypt('123'),
            'status'        => 'aktif',
        ]);

        $this->get("/hapussiswa/{$siswa->id}")->assertRedirect('/siswadata');
        $this->assertDatabaseMissing('siswas', ['id' => $siswa->id]);
    }

    public function test_download_template_returns_redirect(): void
    {
        $this->loginAndGetSession();
        $this->get('/siswa-download-template')->assertRedirect();
    }

    // ════════════════════════════════════════
    // 4. ALL WALAS MODULES — SMOKE TESTS
    // ════════════════════════════════════════

    public function walasModuleDataProvider(): array
    {
        return [
            'adminwalas'               => ['/adminwalas'],
            'identitaskelas'           => ['/identitaskelas'],
            'strukturorganisasi'       => ['/strukturorganisasi'],
            'jadwalkbm'                => ['/jadwalkbm'],
            'jadwalpiket'              => ['/jadwalpiket'],
            'denahkerjakelompok'       => ['/denahkerjakelompok'],
            'serahterimarapor'         => ['/serahterimarapor'],
            'lembarpengesahan'         => ['/lembarpengesahan'],
            'presensi'                 => ['/presensi'],
            'homevisit'                => ['/homevisit'],
            'homevisitcreate'          => ['/homevisitcreate'],
            'bukutamuortu'             => ['/bukutamuortu'],
            'bukutamuortucreate'       => ['/bukutamuortucreate'],
            'agendawalas'              => ['/agendawalas'],
            'catatankasus'             => ['/catatankasus'],
            'daftarpesertadidik'       => ['/daftarpesertadidik'],
            'daftarpesertadidikcreate' => ['/daftarpesertadidikcreate'],
            'rekapjumlahsiswa'         => ['/rekapjumlahsiswa'],
            'rekapjumlahsiswacreate'   => ['/rekapjumlahsiswacreate'],
            'persentasesosialekonomi'  => ['/persentasesosialekonomi'],
            'persentasesosialekonomicreate' => ['/persentasesosialekonomicreate'],
            'prestasisiswa'            => ['/prestasisiswa'],
            'beritaacarakenaikan'      => ['/beritaacarakenaikan'],
            'beritaacarakelulusan'     => ['/beritaacarakelulusan'],
            'beritaacaraserahterima'   => ['/beritaacaraserahterima'],
            'rencana_kegiatan_ganjil'  => ['/rencana_kegiatan/ganjil'],
            'rencana_kegiatan_genap'   => ['/rencana_kegiatan/genap'],
            'pendapatanortu'           => ['/pendapatanortu'],
            'grafikjaraktempuh'        => ['/grafikjaraktempuh'],
            'profilewalas'             => ['/profilewalas'],
        ];
    }

    /** @dataProvider walasModuleDataProvider */
    public function test_walas_module_returns_200(string $url): void
    {
        $this->loginAndGetSession();
        $this->get($url)->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 5. AGENDA CRUD
    // ════════════════════════════════════════

    public function test_agenda_create(): void
    {
        $this->loginAndGetSession();

        $this->post('/agendawalas/store', [
            'hari'           => 'Senin',
            'tanggal'        => now()->format('Y-m-d'),
            'nama_kegiatan'  => 'Test Kegiatan',
            'hasil'          => 'Test Hasil',
            'waktu'          => '08:00',
            'keterangan'     => 'Test Keterangan',
            'tanggalttd'     => now()->format('Y-m-d'),
        ])->assertRedirect('/agendawalas');

        $this->assertDatabaseHas('agenda_kegiatan_walas', ['nama_kegiatan' => 'Test Kegiatan']);
    }

    public function test_agenda_edit_and_delete(): void
    {
        $this->loginAndGetSession();

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

        // Edit
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

        // Delete
        $this->get("/hapusagendawalas/{$agenda->id}")->assertRedirect('/agendawalas');
        $this->assertDatabaseMissing('agenda_kegiatan_walas', ['id' => $agenda->id]);
    }

    // ════════════════════════════════════════
    // 6. CATATAN KASUS CREATE
    // ════════════════════════════════════════

    public function test_catatan_kasus_create(): void
    {
        $this->loginAndGetSession();

        $this->post('/catatankasus/store', [
            'walas_id'             => 1,
            'nama_peserta_didik'   => 'Andi Pratama',
            'tanggal'              => now()->format('Y-m-d'),
            'kasus'                => 'Test Kasus',
            'solusi'               => 'Test Solusi',
        ])->assertRedirect('/catatankasus');

        $this->assertDatabaseHas('catatan_kasus_siswas', ['kasus' => 'Test Kasus']);
    }

    // ════════════════════════════════════════
    // 7. PROFILE
    // ════════════════════════════════════════

    public function test_profile_page_does_not_leak_password(): void
    {
        $this->loginAndGetSession();
        $response = $this->get('/profilewalas');
        $response->assertStatus(200);
        $response->assertDontSee('$2y$'); // bcrypt hash not visible
    }

    public function test_profile_edit(): void
    {
        $this->loginAndGetSession();

        $this->put('/profilewalas/1', [
            'nama'          => 'Budi Updated',
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081199999999',
            'nip'           => '198501012010011001',
        ])->assertRedirect('/profilewalas');

        $this->assertDatabaseHas('walas', ['nama' => 'Budi Updated']);
    }
}
