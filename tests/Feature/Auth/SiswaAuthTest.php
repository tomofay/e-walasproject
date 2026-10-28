<?php

namespace Tests\Feature\Auth;

use App\Models\PrestasiSiswa;
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
            'nama' => 'Andi Pratama',
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
        $this->get('/datadiripage')->assertStatus(200);
    }

    public function test_siswa_without_biodata_sees_prompt_to_input_data(): void
    {
        $siswa = \App\Models\Siswa::create([
            'nama' => 'Siswa Baru Belum Isi',
            'no_wa' => '081234567899',
            'password' => bcrypt($this->password()),
            'rombels_id' => 1,
            'jenis_kelamin' => 'Laki-laki',
        ]);

        $this->post('/loginsiswa', [
            'nama' => 'Siswa Baru Belum Isi',
            'password' => $this->password(),
        ]);

        $this->get('/datadiripage')
            ->assertStatus(200)
            ->assertSee('Mohon input data diri terlebih dahulu')
            ->assertSee('klik disini untuk isi data');
    }

    public function test_biodata_form_has_automated_and_customized_fields(): void
    {
        $this->loginSiswa();

        $response = $this->get('/inputdatadiri');
        $response->assertStatus(200)
            ->assertDontSee('Otomatis dari Rombel')
            ->assertDontSee('Diisi Walas/Kurikulum')
            ->assertDontSee('Diisi Siswa')
            ->assertSee('Wali Kelas')
            ->assertSee('Contoh: SMP 1 Cibinong')
            ->assertSee('id="jalur_masuk"', false)
            ->assertSee('id="jalur_masuk_list"', false)
            ->assertDontSee('id="kepemilikan_rumah"', false);
    }

    public function test_biodata_submission_reports_missing_fields_without_saving(): void
    {
        $this->loginSiswa();
        $this->get('/inputdatadiri');

        $response = $this->post('/biodatasiswa/store', []);

        $response->assertRedirect('/inputdatadiri')
            ->assertSessionHasErrors([
                'nama_lengkap',
                'nisn',
                'jalur_masuk',
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
        \App\Models\BiodataSiswa::where('siswas_id', session('siswa_id'))->delete();

        $response = $this->post('/biodatasiswa/store', [
            'nama_lengkap' => 'Siswa Uji Biodata',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2008-05-10',
            'alamat' => 'Jl. Uji No. 1',
            'alamat_maps' => 'https://maps.google.com/?q=Bogor',
            'fotorumah_url' => UploadedFile::fake()->create('rumah.jpg', 100, 'image/jpeg'),
            'jalur_masuk' => 'SPMB Bersama Mandiri 2026',
            'jarak_rumah' => '3 km',
            'transportasi_sekolah' => 'Motor',
            'transportasi_rumah' => 'Motor',
            'agama' => 'Islam',
            'kewarganegaraan' => 'Indonesia',
            'anak_ke' => 1,
            'jumlah_saudara' => 2,
            'no_wa' => '081234567890',
            'email' => 'siswa@example.test',
            'nisn' => 'NISN-MANUAL-001',
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
            'namasekolah_asal' => 'SMP 1 Cibinong',
            'alamat_sekolah' => 'Jl. Sekolah No. 1',
            'tahun_lulus' => '2024',
        ]);

        $response->assertRedirect('/datadiripage');
        $this->assertDatabaseHas('biodata_siswas', [
            'nisn' => 'NISN-MANUAL-001',
            'jalur_masuk' => 'SPMB Bersama Mandiri 2026',
            'namasekolah_asal' => 'SMP 1 Cibinong',
            'pekerjaan_ayah' => 'Pedagang',
            'riwayat_penyakit' => 'Tidak ada',
            'alergi' => 'Tidak ada',
            'prestasi_akademik' => 'Tidak ada',
            'kepemilikan_rumah' => null,
        ]);
    }

    public function test_siswa_cannot_edit_nis_in_update(): void
    {
        $this->loginSiswa();
        $biodata = \App\Models\BiodataSiswa::where('siswas_id', session('siswa_id'))->first();

        if (! $biodata) {
            $biodata = \App\Models\BiodataSiswa::create([
                'siswas_id' => session('siswa_id'),
                'nama_lengkap' => 'Andi Pratama',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2008-01-01',
                'alamat' => 'Bogor',
                'alamat_maps' => 'Bogor',
                'jalur_masuk' => 'Rapor',
                'jarak_rumah' => '1 km',
                'transportasi_sekolah' => 'Motor',
                'transportasi_rumah' => 'Motor',
                'agama' => 'Islam',
                'kewarganegaraan' => 'Indonesia',
                'anak_ke' => 1,
                'jumlah_saudara' => 1,
                'no_wa' => '081234567890',
                'email' => 'andi@example.com',
                'nis' => 'NIS-ORIGINAL-WALAS',
                'nisn' => '0012345678',
                'tahun_masuk' => '2024',
                'nama_ayah' => 'Ayah',
                'pekerjaan_ayah' => 'Karyawan',
                'tempat_lahir_ayah' => 'Bogor',
                'tanggal_lahir_ayah' => '1980-01-01',
                'alamat_ayah' => 'Bogor',
                'no_wa_ayah' => '081234567890',
                'nama_ibu' => 'Ibu',
                'pekerjaan_ibu' => 'Karyawan',
                'tempat_lahir_ibu' => 'Bogor',
                'tanggal_lahir_ibu' => '1980-01-01',
                'alamat_ibu' => 'Bogor',
                'no_wa_ibu' => '081234567890',
                'pendapatan_ortu' => 'Rp1.000.000,00 - Rp3.000.000,00',
                'namasekolah_asal' => 'SMP 1 Cibinong',
                'alamat_sekolah' => 'Bogor',
                'tahun_lulus' => '2024',
            ]);
        } else {
            $biodata->update(['nis' => 'NIS-ORIGINAL-WALAS']);
        }

        // Student tries to alter NIS to 'NIS-HACKED-BY-SISWA' and update NISN
        $response = $this->put(route('biodatasiswa.update', $biodata->id), [
            'nama_lengkap' => 'Andi Pratama Diperbarui',
            'nis' => 'NIS-HACKED-BY-SISWA',
            'nisn' => '0099887766',
            'jalur_masuk' => 'SPMB Prestasi',
            'namasekolah_asal' => 'SMP 1 Cibinong',
        ]);

        $response->assertRedirect('/datadiripage');

        $biodata->refresh();
        // NIS must remain unchanged!
        $this->assertEquals('NIS-ORIGINAL-WALAS', $biodata->nis);
        // NISN is edited by student themselves
        $this->assertEquals('0099887766', $biodata->nisn);
        // Jalur masuk updated
        $this->assertEquals('SPMB Prestasi', $biodata->jalur_masuk);
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

    public function test_siswa_can_view_input_prestasi_page(): void
    {
        $this->loginSiswa();
        $this->get('/prestasisiswainput')->assertStatus(200);
        $this->get('/prestasisiswainputcreate')->assertStatus(200);
    }

    public function test_siswa_can_store_and_update_prestasi_with_automated_fields(): void
    {
        Storage::fake('public');
        $this->loginSiswa();

        $sertif = UploadedFile::fake()->create('sertifikat.pdf', 500, 'application/pdf');
        $foto1 = UploadedFile::fake()->create('foto1.jpg', 300, 'image/jpeg');
        $foto2 = UploadedFile::fake()->create('foto2.jpg', 300, 'image/jpeg');
        $foto3 = UploadedFile::fake()->create('foto3.jpg', 300, 'image/jpeg');
        $foto4 = UploadedFile::fake()->create('foto4.jpg', 300, 'image/jpeg');

        // Store: no walas_id, siswas_id, rombels_id needed from form!
        $response = $this->post('/prestasisiswainput/store', [
            'jenis_prestasi' => 'Akademik',
            'nama_prestasi' => 'Juara 1 Lomba Coding',
            'mata_lomba' => 'Web Technologies',
            'nama_pembimbing' => 'Bpk. Ahmad, S.Pd.',
            'tingkat' => 'Tingkat Provinsi',
            'lokasi' => 'SMKN 1 Cibinong',
            'tanggal' => '2026-10-28',
            'sertifikat_url' => $sertif,
            'dokumentasi_url' => [$foto1, $foto2, $foto3, $foto4],
        ]);

        $response->assertRedirect('/prestasisiswainput');

        $this->assertDatabaseHas('prestasi_siswas', [
            'nama_prestasi' => 'Juara 1 Lomba Coding',
            'mata_lomba' => 'Web Technologies',
            'nama_pembimbing' => 'Bpk. Ahmad, S.Pd.',
            'tingkat' => 'Tingkat Provinsi',
            'lokasi' => 'SMKN 1 Cibinong',
        ]);

        $created = PrestasiSiswa::where('nama_prestasi', 'Juara 1 Lomba Coding')->first();
        $this->assertNotNull($created->walas_id);
        $this->assertNotNull($created->rombels_id);
        $this->assertNotNull($created->sertifikat_url);
        $this->assertIsArray($created->dokumentasi_url);
        $this->assertCount(4, $created->dokumentasi_url);
        Storage::disk('public')->assertExists($created->sertifikat_url);
        Storage::disk('public')->assertExists($created->dokumentasi_url[0]);
        Storage::disk('public')->assertExists($created->dokumentasi_url[1]);
        Storage::disk('public')->assertExists($created->dokumentasi_url[2]);
        Storage::disk('public')->assertExists($created->dokumentasi_url[3]);

        // Edit page
        $this->get("/prestasisiswainput/{$created->id}/edit")->assertStatus(200);

        // Update
        $foto3 = UploadedFile::fake()->create('foto3.jpg', 300, 'image/jpeg');
        $updateResp = $this->put("/prestasisiswainput/{$created->id}", [
            'jenis_prestasi' => 'Akademik',
            'nama_prestasi' => 'Juara 1 Lomba Coding (Revisi)',
            'mata_lomba' => 'Web Technologies Advanced',
            'nama_pembimbing' => 'Bpk. Ahmad, S.Pd. & Tim',
            'tingkat' => 'Tingkat Nasional',
            'lokasi' => 'Jakarta Convention Center',
            'tanggal' => '2026-10-29',
            'form_has_docs' => 1,
            'keep_docs' => [$created->dokumentasi_url[0]],
            'dokumentasi_url' => [$foto3],
        ]);
        $updateResp->assertRedirect('/prestasisiswainput');

        $updated = PrestasiSiswa::find($created->id);
        $this->assertEquals('Juara 1 Lomba Coding (Revisi)', $updated->nama_prestasi);
        $this->assertEquals('Tingkat Nasional', $updated->tingkat);
        $this->assertCount(2, $updated->dokumentasi_url); // kept foto1 + foto3
        Storage::disk('public')->assertExists($created->dokumentasi_url[0]);
        Storage::disk('public')->assertMissing($created->dokumentasi_url[1]); // removed foto2
        Storage::disk('public')->assertExists($updated->dokumentasi_url[1]);

        // Delete
        $delResp = $this->delete("/hapusprestasisiswainput/{$created->id}");
        $delResp->assertRedirect('/prestasisiswainput');
        $this->assertDatabaseMissing('prestasi_siswas', ['id' => $created->id]);
    }

    public function test_prestasi_documentation_upload_is_limited_to_ten_photos(): void
    {
        Storage::fake('public');
        $this->loginSiswa();

        $photos = array_map(
            fn (int $index) => UploadedFile::fake()->create("foto{$index}.jpg", 100, 'image/jpeg'),
            range(1, 11)
        );

        $response = $this->post('/prestasisiswainput/store', [
            'jenis_prestasi' => 'Akademik',
            'nama_prestasi' => 'Prestasi Uji Batas Foto',
            'tanggal' => '2026-10-28',
            'dokumentasi_url' => $photos,
        ]);

        $response->assertRedirect()
            ->assertSessionHasErrors('dokumentasi_url');

        $this->assertDatabaseMissing('prestasi_siswas', [
            'nama_prestasi' => 'Prestasi Uji Batas Foto',
        ]);
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
            'nama' => 'Andi Pratama',
            'password' => $this->password(),
        ]);
    }
}
