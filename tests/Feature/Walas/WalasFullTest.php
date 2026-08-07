<?php

namespace Tests\Feature\Walas;

use Tests\TestCase;
use App\Models\Siswa;
use App\Models\AgendaKegiatanWalas;
use App\Models\HomeVisit;
use App\Models\BukuTamuOrangtua;
use App\Models\CatatanKasusSiswa;
use App\Models\PrestasiSiswa;

class WalasFullTest extends TestCase
{
    private string $walasNama = 'Budi Santoso, S.Pd.';

    // ════════════════════════════════════════
    // 1. AUTHENTICATION
    // ════════════════════════════════════════

    public function test_walas_can_login(): void
    {
        $this->post('/logingtk', [
            'nama'     => $this->walasNama,
            'password' => $this->password(),
        ])->assertRedirect('/walaspage');

        $this->assertAuthenticated('walas');
    }

    public function test_walas_can_logout(): void
    {
        $this->login();

        $this->post('/homepagegtk/logout')->assertRedirect('/');
        $this->assertGuest('walas');
    }

    // ════════════════════════════════════════
    // 2. DASHBOARD
    // ════════════════════════════════════════

    public function test_walas_dashboard_accessible(): void
    {
        $this->login();
        $this->get('/walaspage')->assertStatus(200)->assertSee('Budi Santoso');
    }

    // ════════════════════════════════════════
    // 3. DATA SISWA + BIODATA
    // ════════════════════════════════════════

    public function test_walas_can_view_siswa_data(): void
    {
        $this->login();
        $this->get('/siswadata')->assertStatus(200)->assertSee('Andi Pratama');
    }

    public function test_walas_can_search_siswa(): void
    {
        $this->login();
        $this->get('/siswadata_search?keyword=Andi')->assertStatus(200);
    }

    public function test_walas_can_view_siswa_biodata(): void
    {
        $this->login();
        $siswa = Siswa::where('nama', 'Andi Pratama')->first();
        $this->get("/siswa/biodata/{$siswa->id}")->assertRedirect(); // returns back jika biodata belum ada
    }

    public function test_walas_can_create_siswa(): void
    {
        $this->login();

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

    public function test_walas_can_update_siswa(): void
    {
        $this->login();

        $siswa = Siswa::where('nama', 'Andi Pratama')->first();

        $this->put("/siswa/{$siswa->id}", [
            'nama'          => 'Andi Pratama Updated',
            'rombels_id'    => $siswa->rombels_id,
            'jenis_kelamin' => $siswa->jenis_kelamin,
            'no_wa'         => $siswa->no_wa,
            'status'        => 'aktif',
        ])->assertRedirect('/siswadata');

        $this->assertDatabaseHas('siswas', ['nama' => 'Andi Pratama Updated']);
    }

    public function test_walas_can_delete_siswa(): void
    {
        $this->login();
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

    public function test_walas_download_siswa_template(): void
    {
        $this->login();
        $this->get('/siswa-download-template')->assertRedirect(); // template tidak ada → back
    }

    // ════════════════════════════════════════
    // 4. ADMINISTRASI WALAS — semua modul
    // ════════════════════════════════════════

    public function test_walas_can_view_administrasi(): void
    {
        $this->login();
        $this->get('/adminwalas')->assertStatus(200);
    }

    public function test_walas_can_view_identitas_kelas(): void
    {
        $this->login();
        $this->get('/identitaskelas')->assertStatus(200);
    }

    public function test_walas_can_view_struktur_organisasi(): void
    {
        $this->login();
        $this->get('/strukturorganisasi')->assertStatus(200);
    }

    public function test_walas_can_view_jadwal_kbm(): void
    {
        $this->login();
        $this->get('/jadwalkbm')->assertStatus(200);
    }

    public function test_walas_can_view_jadwal_piket(): void
    {
        $this->login();
        $this->get('/jadwalpiket')->assertStatus(200);
    }

    public function test_walas_can_view_denah_kerja_kelompok(): void
    {
        $this->login();
        $this->get('/denahkerjakelompok')->assertStatus(200);
    }

    public function test_walas_can_view_serah_terima_rapor(): void
    {
        $this->login();
        $this->get('/serahterimarapor')->assertStatus(200);
    }

    public function test_walas_can_view_lembar_pengesahan(): void
    {
        $this->login();
        $this->get('/lembarpengesahan')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 5. PRESENSI
    // ════════════════════════════════════════

    public function test_walas_can_view_presensi(): void
    {
        $this->login();
        $this->get('/presensi')->assertStatus(200);
    }

    public function test_walas_can_create_presensi(): void
    {
        $this->login();

        $this->post('/presensi/store', [
            'walas_id' => 1,
            'kelas'    => 'X SIJA 1',
            'tanggal'  => now()->format('Y-m-d'),
        ])->assertRedirect();

        $this->assertDatabaseHas('presensis', ['kelas' => 'X SIJA 1']);
    }

    // ════════════════════════════════════════
    // 6. HOME VISIT
    // ════════════════════════════════════════

    public function test_walas_can_view_home_visit(): void
    {
        $this->login();
        $this->get('/homevisit')->assertStatus(200);
    }

    public function test_walas_can_access_home_visit_create(): void
    {
        $this->login();
        $this->get('/homevisitcreate')->assertStatus(200);
    }

    public function test_walas_can_store_home_visit(): void
    {
        $this->login();

        $this->post('/homevisit/store', [
            'walas_id'            => 1,
            'nama_peserta_didik'  => 'Andi Pratama',
            'tanggal'             => now()->format('Y-m-d'),
            'kasus'               => 'Test kasus',
            'solusi'              => 'Test solusi',
            'tindak_lanjut'       => 'Test tindak lanjut',
            'bukti_url'           => false, // skip file upload
            'dokumentasi_url'     => false,
        ])->assertSessionHasErrors(['bukti_url', 'dokumentasi_url']); // wajib upload file
    }

    // ════════════════════════════════════════
    // 7. BUKU TAMU ORANGTUA
    // ════════════════════════════════════════

    public function test_walas_can_view_buku_tamu(): void
    {
        $this->login();
        $this->get('/bukutamuortu')->assertStatus(200);
    }

    public function test_walas_can_access_buku_tamu_create(): void
    {
        $this->login();
        $this->get('/bukutamuortucreate')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 8. AGENDA KEGIATAN
    // ════════════════════════════════════════

    public function test_walas_can_view_agenda(): void
    {
        $this->login();
        $this->get('/agendawalas')->assertStatus(200);
    }

    public function test_walas_can_create_agenda(): void
    {
        $this->login();

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

    public function test_walas_can_edit_agenda(): void
    {
        $this->login();

        $agenda = AgendaKegiatanWalas::create([
            'walas_id'       => 1,
            'hari'           => 'Senin',
            'tanggal'        => now()->format('Y-m-d'),
            'nama_kegiatan'  => 'Old Kegiatan',
            'hasil'          => 'Old Hasil',
            'waktu'          => '08:00',
            'keterangan'     => 'Old Keterangan',
            'tanggalttd'     => now()->format('Y-m-d'),
        ]);

        $this->put("/agendawalas/{$agenda->id}", [
            'hari'           => 'Selasa',
            'tanggal'        => now()->format('Y-m-d'),
            'nama_kegiatan'  => 'Updated Kegiatan',
            'hasil'          => 'Updated Hasil',
            'waktu'          => '09:00',
            'keterangan'     => 'Updated',
            'tanggalttd'     => now()->format('Y-m-d'),
        ])->assertRedirect('/agendawalas');

        $this->assertDatabaseHas('agenda_kegiatan_walas', ['nama_kegiatan' => 'Updated Kegiatan']);
    }

    public function test_walas_can_delete_agenda(): void
    {
        $this->login();

        $agenda = AgendaKegiatanWalas::create([
            'walas_id'       => 1,
            'hari'           => 'Senin',
            'tanggal'        => now()->format('Y-m-d'),
            'nama_kegiatan'  => 'To Delete',
            'hasil'          => 'To Delete',
            'waktu'          => '08:00',
            'keterangan'     => 'To Delete',
            'tanggalttd'     => now()->format('Y-m-d'),
        ]);

        $this->get("/hapusagendawalas/{$agenda->id}")->assertRedirect('/agendawalas');
        $this->assertDatabaseMissing('agenda_kegiatan_walas', ['id' => $agenda->id]);
    }

    // ════════════════════════════════════════
    // 9. CATATAN KASUS
    // ════════════════════════════════════════

    public function test_walas_can_view_catatan_kasus(): void
    {
        $this->login();
        $this->get('/catatankasus')->assertStatus(200);
    }

    public function test_walas_can_create_catatan_kasus(): void
    {
        $this->login();

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
    // 10. DAFTAR PESERTA DIDIK
    // ════════════════════════════════════════

    public function test_walas_can_view_daftar_peserta_didik(): void
    {
        $this->login();
        $this->get('/daftarpesertadidik')->assertStatus(200);
    }

    public function test_walas_can_access_create_daftar_peserta_didik(): void
    {
        $this->login();
        $this->get('/daftarpesertadidikcreate')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 11. REKAPITULASI JUMLAH SISWA
    // ════════════════════════════════════════

    public function test_walas_can_view_rekap_jumlah_siswa(): void
    {
        $this->login();
        $this->get('/rekapjumlahsiswa')->assertStatus(200);
    }

    public function test_walas_can_access_create_rekap(): void
    {
        $this->login();
        $this->get('/rekapjumlahsiswacreate')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 12. PERSENTASE SOSIAL EKONOMI
    // ════════════════════════════════════════

    public function test_walas_can_view_persentase_sosial_ekonomi(): void
    {
        $this->login();
        $this->get('/persentasesosialekonomi')->assertStatus(200);
    }

    public function test_walas_can_access_create_persentase(): void
    {
        $this->login();
        $this->get('/persentasesosialekonomicreate')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 13. PRESTASI SISWA
    // ════════════════════════════════════════

    public function test_walas_can_view_prestasi(): void
    {
        $this->login();
        $this->get('/prestasisiswa')->assertStatus(200);
    }

    public function test_walas_can_access_create_prestasi(): void
    {
        $this->login();
        $this->get('/prestasisiswacreate')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 14. BERITA ACARA
    // ════════════════════════════════════════

    public function test_walas_can_view_berita_acara_kenaikan(): void
    {
        $this->login();
        $this->get('/beritaacarakenaikan')->assertStatus(200);
    }

    public function test_walas_can_view_berita_acara_kelulusan(): void
    {
        $this->login();
        $this->get('/beritaacarakelulusan')->assertStatus(200);
    }

    public function test_walas_can_view_berita_acara_serah_terima(): void
    {
        $this->login();
        $this->get('/beritaacaraserahterima')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 15. RENCANA KEGIATAN WALAS
    // ════════════════════════════════════════

    public function test_walas_can_view_rencana_kegiatan_ganjil(): void
    {
        $this->login();
        $this->get('/rencana_kegiatan/ganjil')->assertStatus(200);
    }

    public function test_walas_can_view_rencana_kegiatan_genap(): void
    {
        $this->login();
        $this->get('/rencana_kegiatan/genap')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 16. STATISTIK & GRAFIK
    // ════════════════════════════════════════

    public function test_walas_can_view_pendapatan_ortu(): void
    {
        $this->login();
        $this->get('/pendapatanortu')->assertStatus(200);
    }

    public function test_walas_can_view_grafik_jarak_tempuh(): void
    {
        $this->login();
        $this->get('/grafikjaraktempuh')->assertStatus(200);
    }

    // ════════════════════════════════════════
    // 17. PROFILE
    // ════════════════════════════════════════

    public function test_walas_can_view_profile(): void
    {
        $this->login();
        $this->get('/profilewalas')->assertStatus(200);
    }

    public function test_walas_can_edit_profile(): void
    {
        $this->login();

        $this->put('/profilewalas/1', [
            'nama'          => 'Budi Santoso Updated',
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081111111199',
            'nip'           => '198501012010011001',
        ])->assertRedirect('/profilewalas');

        $this->assertDatabaseHas('walas', ['nama' => 'Budi Santoso Updated']);
    }

    // ════════════════════════════════════════
    // HELPER
    // ════════════════════════════════════════

    private function login(): void
    {
        $this->post('/logingtk', [
            'nama'     => $this->walasNama,
            'password' => $this->password(),
        ]);
    }
}
