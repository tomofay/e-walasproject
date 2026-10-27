<?php

namespace Tests\Feature\Auth;

use App\Models\Walas;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiswaAuthTest extends TestCase
{
    public function test_siswa_can_view_login_page(): void
    {
        $this->get('/loginsiswa')->assertStatus(200);
    }

    public function test_siswa_can_login(): void
    {
        $response = $this->post('/loginsiswa', [
            'nama'     => 'Andi Pratama',
            'password' => $this->password(),
        ]);

        $response->assertRedirect('/siswapage');
        $this->assertAuthenticated('siswas');
    }

    public function test_siswa_dashboard_accessible(): void
    {
        $this->loginSiswa();
        $this->get('/siswapage')->assertStatus(200);
    }

    public function test_siswa_can_view_biodata(): void
    {
        $this->loginSiswa();
        $this->get('/datadiri')->assertStatus(200);
    }

    public function test_siswa_can_select_grade_thirteen_in_biodata_form(): void
    {
        $this->loginSiswa();

        $this->get('/inputdatadiri')
            ->assertStatus(200)
            ->assertSee('<option value="XIII">XIII</option>', false)
            ->assertSee('id="client-validation-errors"', false)
            ->assertSee('id="biodata-form"', false);
    }

    public function test_biodata_submission_reports_missing_fields_without_saving(): void
    {
        $this->loginSiswa();
        $this->get('/inputdatadiri');

        $response = $this->post('/biodatasiswa/store', []);

        $response->assertRedirect('/inputdatadiri')
            ->assertSessionHasErrors([
                'walas_id',
                'nama_lengkap',
                'nis',
                'nisn',
                'pekerjaan_ayah',
                'pekerjaan_ibu',
                'pendapatan_ortu',
            ]);

        $response = $this->get('/inputdatadiri');
        $response->assertStatus(200)
            ->assertSee('Data belum dapat dikirim. Perbaiki bagian berikut:')
            ->assertSee('nomor WhatsApp siswa');
    }

    public function test_valid_biodata_submission_saves_data_and_optional_defaults(): void
    {
        Storage::fake('public');
        $this->loginSiswa();

        $response = $this->post('/biodatasiswa/store', [
            'walas_id' => Walas::query()->value('id'),
            'nama_lengkap' => 'Siswa Uji Biodata',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2008-05-10',
            'alamat' => 'Jl. Uji No. 1',
            'alamat_maps' => 'https://maps.google.com/?q=Bogor',
            'fotorumah_url' => UploadedFile::fake()->image('rumah.jpg'),
            'kepemilikan_rumah' => 'Lunas',
            'jalur_masuk' => 'Rapor',
            'jarak_rumah' => '3 km',
            'transportasi_sekolah' => 'Motor',
            'transportasi_rumah' => 'Motor',
            'agama' => 'Islam',
            'kewarganegaraan' => 'Indonesia',
            'anak_ke' => 1,
            'jumlah_saudara' => 2,
            'no_wa' => '081234567890',
            'email' => 'siswa@example.test',
            'nis' => 'NIS-IMPORT-TEST',
            'nisn' => 'NISN-IMPORT-TEST',
            'kelas' => 'XIII',
            'kompetensi' => 'SIJA',
            'tahun_masuk' => '2024',
            'nama_ayah' => 'Ayah Uji',
            'pekerjaan_ayah' => 'Lainnya',
            'pekerjaan_ayah_lainnya' => 'Pedagang',
            'tempat_lahir_ayah' => 'Bogor',
            'tanggal_lahir_ayah' => '1980-01-01',
            'alamat_ayah' => 'Jl. Uji No. 1',
            'no_wa_ayah' => '081234567890',
            'nama_ibu' => 'Ibu Uji',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
            'tempat_lahir_ibu' => 'Bogor',
            'tanggal_lahir_ibu' => '1982-01-01',
            'alamat_ibu' => 'Jl. Uji No. 1',
            'no_wa_ibu' => '081234567890',
            'pendapatan_ortu' => 'Rp1.000.000,00 - Rp3.000.000,00',
            'namasekolah_asal' => 'SMP Uji',
            'alamat_sekolah' => 'Jl. Sekolah No. 1',
            'tahun_lulus' => '2024',
        ]);

        $response->assertRedirect('/datadiripage');
        $this->assertDatabaseHas('biodata_siswas', [
            'nis' => 'NIS-IMPORT-TEST',
            'nisn' => 'NISN-IMPORT-TEST',
            'kelas' => 'XIII',
            'pekerjaan_ayah' => 'Pedagang',
            'riwayat_penyakit' => 'Tidak ada',
            'alergi' => 'Tidak ada',
            'prestasi_akademik' => 'Tidak ada',
        ]);
    }

    public function test_siswa_can_view_catatan_kasus(): void
    {
        $this->loginSiswa();
        $this->get('/catatankasussiswa')->assertStatus(200);
    }

    public function test_siswa_can_view_profil(): void
    {
        $this->loginSiswa();
        $this->get('/profilesiswa')->assertStatus(200);
    }

    public function test_siswa_logout(): void
    {
        $this->loginSiswa();
        $this->assertAuthenticated('siswas');

        $this->post('/homepagesiswa/logout')->assertRedirect('/');
        $this->assertGuest('siswas');
    }

    private function loginSiswa(): void
    {
        $this->post('/loginsiswa', [
            'nama'     => 'Andi Pratama',
            'password' => $this->password(),
        ]);
    }
}
