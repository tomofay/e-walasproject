<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class WalasAuthTest extends TestCase
{
    public function test_walas_can_view_login_page(): void
    {
        $this->get('/logingtk')->assertStatus(200);
    }

    public function test_walas_can_login(): void
    {
        $response = $this->post('/logingtk', [
            'nama'     => 'Budi Santoso, S.Pd.',
            'password' => $this->password(),
        ]);

        $response->assertRedirect('/walaspage');
        $this->assertAuthenticated('walas');
    }

    public function test_walas_cannot_login_with_wrong_password(): void
    {
        $response = $this->post('/logingtk', [
            'nama'     => 'Budi Santoso, S.Pd.',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/logingtk');
        $this->assertGuest('walas');
    }

    public function test_walas_dashboard_is_protected(): void
    {
        $this->get('/walaspage')->assertRedirect('/logingtk');
    }

    public function test_walas_dashboard_accessible_when_logged_in(): void
    {
        $this->loginWalas();
        $this->get('/walaspage')->assertStatus(200);
    }

    public function test_walas_can_view_siswa_data(): void
    {
        $this->loginWalas();
        $this->get('/siswadata')->assertStatus(200);
    }

    public function test_walas_can_view_administrasi(): void
    {
        $this->loginWalas();
        $this->get('/adminwalas')->assertStatus(200);
    }

    public function test_walas_can_view_agenda(): void
    {
        $this->loginWalas();
        $this->get('/agendawalas')->assertStatus(200);
    }

    public function test_walas_can_view_home_visit(): void
    {
        $this->loginWalas();
        $this->get('/homevisit')->assertStatus(200);
    }

    public function test_walas_can_view_buku_tamu(): void
    {
        $this->loginWalas();
        $this->get('/bukutamuortu')->assertStatus(200);
    }

    public function test_walas_can_view_catatan_kasus(): void
    {
        $this->loginWalas();
        $this->get('/catatankasus')->assertStatus(200);
    }

    public function test_walas_can_view_presensi(): void
    {
        $this->loginWalas();
        $this->get('/presensi')->assertStatus(200);
    }

    public function test_walas_can_view_rencana_kegiatan(): void
    {
        $this->loginWalas();
        $this->get('/rencana_kegiatan/ganjil')->assertStatus(200);
        $this->get('/rencana_kegiatan/genap')->assertStatus(200);
    }

    public function test_walas_can_view_prestasi(): void
    {
        $this->loginWalas();
        $this->get('/prestasisiswa')->assertStatus(200);
    }

    public function test_walas_can_view_daftar_peserta_didik(): void
    {
        $this->loginWalas();
        $this->get('/daftarpesertadidik')->assertStatus(200);
    }

    public function test_walas_can_view_rekap_jumlah_siswa(): void
    {
        $this->loginWalas();
        $this->get('/rekapjumlahsiswa')->assertStatus(200);
    }

    public function test_walas_can_view_persentase_sosial_ekonomi(): void
    {
        $this->loginWalas();
        $this->get('/persentasesosialekonomi')->assertStatus(200);
    }

    public function test_walas_can_view_identitas_kelas(): void
    {
        $this->loginWalas();
        $this->get('/identitaskelas')->assertStatus(200);
    }

    public function test_walas_can_view_struktur_organisasi(): void
    {
        $this->loginWalas();
        $this->get('/strukturorganisasi')->assertStatus(200);
    }

    public function test_walas_can_view_jadwal_kbm(): void
    {
        $this->loginWalas();
        $this->get('/jadwalkbm')->assertStatus(200);
    }

    public function test_walas_can_view_jadwal_piket(): void
    {
        $this->loginWalas();
        $this->get('/jadwalpiket')->assertStatus(200);
    }

    public function test_walas_can_view_serah_terima_rapor(): void
    {
        $this->loginWalas();
        $this->get('/serahterimarapor')->assertStatus(200);
    }

    public function test_walas_can_view_berita_acara(): void
    {
        $this->loginWalas();

        $this->get('/beritaacarakenaikan')->assertStatus(200);
        $this->get('/beritaacarakelulusan')->assertStatus(200);
        $this->get('/beritaacaraserahterima')->assertStatus(200);
    }

    public function test_walas_can_view_lembar_pengesahan(): void
    {
        $this->loginWalas();
        $this->get('/lembarpengesahan')->assertStatus(200);
    }

    public function test_walas_can_view_grafik_jarak_tempuh(): void
    {
        $this->loginWalas();
        $this->get('/grafikjaraktempuh')->assertStatus(200);
    }

    public function test_walas_can_view_profil(): void
    {
        $this->loginWalas();
        $this->get('/profilewalas')->assertStatus(200);
    }

    public function test_walas_logout(): void
    {
        $this->loginWalas();
        $this->assertAuthenticated('walas');

        $this->post('/homepagegtk/logout')->assertRedirect('/');
        $this->assertGuest('walas');
    }

    // ── Helper ──

    private function loginWalas(): void
    {
        $this->post('/logingtk', [
            'nama'     => 'Budi Santoso, S.Pd.',
            'password' => $this->password(),
        ]);
    }
}
