<?php

namespace Tests\Feature\Business;

use Tests\TestCase;

class WalasBusinessTest extends TestCase
{
    /** Walas login → lihat dashboard → lihat data siswa */
    public function test_walas_full_data_siswa_flow(): void
    {
        $this->loginWalas();

        // Dashboard
        $this->get('/walaspage')->assertStatus(200);

        // Data siswa
        $this->get('/siswadata')->assertStatus(200)->assertSee('Andi Pratama');

        // Search siswa
        $this->get('/siswadata_search?keyword=Andi')->assertStatus(200);

        // Download template siswa
        $this->get('/siswa-download-template')->assertRedirect();
    }

    /** Walas login → administrasi walas */
    public function test_walas_full_administrasi_flow(): void
    {
        $this->loginWalas();

        $endpoints = [
            '/agendawalas',
            '/catatankasus',
            '/daftarpesertadidik',
            '/rekapjumlahsiswa',
            '/persentasesosialekonomi',
            '/prestasisiswa',
        ];

        foreach ($endpoints as $url) {
            $this->get($url)->assertStatus(200);
        }
    }

    /** Walas login → presensi flow */
    public function test_walas_presensi_flow(): void
    {
        $this->loginWalas();
        $this->get('/presensi')->assertStatus(200);
    }

    /** Walas login → home visit flow */
    public function test_walas_home_visit_flow(): void
    {
        $this->loginWalas();
        $this->get('/homevisit')->assertStatus(200);
        $this->get('/homevisitcreate')->assertStatus(200);
    }

    /** Walas login → buku tamu flow */
    public function test_walas_buku_tamu_flow(): void
    {
        $this->loginWalas();
        $this->get('/bukutamuortu')->assertStatus(200);
        $this->get('/bukutamuortucreate')->assertStatus(200);
    }

    /** Walas login → berita acara flow */
    public function test_walas_berita_acara_flow(): void
    {
        $this->loginWalas();

        $this->get('/beritaacarakenaikan')->assertStatus(200);
        $this->get('/beritaacarakelulusan')->assertStatus(200);
        $this->get('/beritaacaraserahterima')->assertStatus(200);
    }

    /** Walas login → rencana kegiatan ganjil genap */
    public function test_walas_rencana_kegiatan_flow(): void
    {
        $this->loginWalas();

        $this->get('/rencana_kegiatan/ganjil')->assertStatus(200);
        $this->get('/rencana_kegiatan/genap')->assertStatus(200);
    }

    /** Walas login → struktur organisasi, jadwal, dll */
    public function test_walas_kelas_administration_flow(): void
    {
        $this->loginWalas();

        $this->get('/identitaskelas')->assertStatus(200);
        $this->get('/strukturorganisasi')->assertStatus(200);
        $this->get('/jadwalkbm')->assertStatus(200);
        $this->get('/jadwalpiket')->assertStatus(200);
        $this->get('/serahterimarapor')->assertStatus(200);
        $this->get('/lembarpengesahan')->assertStatus(200);
    }

    /** Walas login → denah kerja kelompok */
    public function test_walas_denah_kerja_kelompok_flow(): void
    {
        $this->loginWalas();
        $this->get('/denahkerjakelompok')->assertStatus(200);
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
