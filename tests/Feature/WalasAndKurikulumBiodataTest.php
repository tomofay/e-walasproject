<?php

namespace Tests\Feature;

use App\Models\BiodataSiswa;
use App\Models\DaftarPesertaDidik;
use App\Models\Kurikulum;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Walas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalasAndKurikulumBiodataTest extends TestCase
{
    use RefreshDatabase;

    protected $walas;

    protected $kurikulum;

    protected $rombel;

    protected $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->walas = Walas::create([
            'nama' => 'Walas Uji',
            'nip' => '1987654321',
            'email' => 'walas@test.com',
            'password' => bcrypt('password'),
            'no_wa' => '081234567890',
            'gender' => 'Laki-laki',
        ]);

        $this->kurikulum = Kurikulum::create([
            'nama' => 'Kurikulum Uji',
            'nip' => '1976543210',
            'email' => 'kurikulum@test.com',
            'password' => bcrypt('password'),
            'no_wa' => '081298765432',
            'gender' => 'Perempuan',
        ]);

        $this->rombel = Rombel::create([
            'nama_kelas' => 'XII SIJA 1',
            'tingkat' => 'XII',
            'kompetensi' => 'SIJA',
            'walas_id' => $this->walas->id,
        ]);

        $this->siswa = Siswa::create([
            'nama' => 'Slamet Test',
            'rombels_id' => $this->rombel->id,
            'jenis_kelamin' => 'Laki-laki',
            'no_wa' => '08999999999',
            'status' => 'aktif',
            'tahun_masuk' => '2025',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_walas_redirected_to_create_biodata_when_biodata_missing()
    {
        $response = $this->withSession([
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
        ])->get(route('homepagegtk.biodatasiswa', $this->siswa->id));

        $response->assertRedirect(route('homepagegtk.createbiodata', $this->siswa->id));
        $response->assertSessionHas('info');
    }

    public function test_walas_can_view_create_biodata_page()
    {
        $response = $this->withSession([
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
        ])->get(route('homepagegtk.createbiodata', $this->siswa->id));

        $response->assertStatus(200);
        $response->assertSee('Buat Biodata Diri Siswa');
        $response->assertSee('Slamet Test');
    }

    public function test_walas_can_store_biodata_and_sync_daftar_peserta_didik()
    {
        $response = $this->withSession([
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
        ])->post(route('homepagegtk.storebiodata', $this->siswa->id), [
            'nama_lengkap' => 'Slamet Test',
            'jenis_kelamin' => 'Laki-laki',
            'nis' => '20250016',
            'nisn' => '0012345678',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2007-01-01',
            'alamat' => 'Jl. Pemda Cibinong',
            'agama' => 'Islam',
            'kewarganegaraan' => 'WNI',
            'anak_ke' => '1',
            'jumlah_saudara' => '2',
            'no_wa' => '08999999999',
            'email' => 'slamet@test.com',
            'tahun_masuk' => '2025',
            'nama_ayah' => 'Ayah Slamet',
            'nama_ibu' => 'Ibu Slamet',
            'nama_wali' => '-',
            'alamat_ortu' => 'Jl. Pemda Cibinong',
            'alamat_wali' => '-',
            'jarak_rumah' => '2 km',
            'transportasi_sekolah' => 'Sepeda Motor',
            'transportasi_rumah' => 'Sepeda Motor',
            'jalur_masuk' => 'SPMB',
        ]);

        $response->assertRedirect(route('homepagegtk.biodatasiswa', $this->siswa->id));
        $this->assertDatabaseHas('biodata_siswas', [
            'siswas_id' => $this->siswa->id,
            'nis' => '20250016',
            'nisn' => '0012345678',
        ]);

        $this->assertDatabaseHas('daftar_peserta_didiks', [
            'nama_siswa' => $this->siswa->id,
            'nis' => '20250016',
            'nisn' => '0012345678',
            'jenis_kelamin' => 'Laki-laki',
        ]);
    }

    public function test_walas_nis_edits_are_preserved_when_student_has_no_biodata(): void
    {
        $daftar = DaftarPesertaDidik::create([
            'walas_id' => $this->walas->id,
            'nama_siswa' => $this->siswa->id,
            'nis' => '20250016',
            'nisn' => '0012345678',
            'jenis_kelamin' => 'Laki-laki',
            'keterangan' => 'aktif',
            'tanggal' => now()->toDateString(),
        ]);

        $session = [
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
        ];

        $this->withSession($session)
            ->put(route('daftarpesertadidik.update', $daftar->id), [
                'walas_id' => $this->walas->id,
                'kurikulum_id' => $this->kurikulum->id,
                'nama_siswa' => (string) $this->siswa->id,
                'nis' => '20259999',
                'nisn' => '0099999999',
                'jenis_kelamin' => 'Laki-laki',
                'keterangan' => 'aktif',
                'tanggal' => now()->toDateString(),
            ])
            ->assertRedirect('/daftarpesertadidik')
            ->assertSessionHas('success', 'Data berhasil diperbarui.');

        $this->withSession($session)
            ->get('/daftarpesertadidik')
            ->assertOk()
            ->assertSee('20259999')
            ->assertSee('0099999999');

        $this->assertDatabaseHas('daftar_peserta_didiks', [
            'id' => $daftar->id,
            'nis' => '20259999',
            'nisn' => '0099999999',
        ]);
        $this->assertDatabaseMissing('biodata_siswas', [
            'siswas_id' => $this->siswa->id,
        ]);
    }

    public function test_walas_can_edit_and_update_biodata()
    {
        $this->withSession([
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
        ])->post(route('homepagegtk.storebiodata', $this->siswa->id), [
            'nama_lengkap' => 'Slamet Test',
            'jenis_kelamin' => 'Laki-laki',
            'nis' => '20250016',
            'nisn' => '0012345678',
        ]);

        $biodata = BiodataSiswa::where('siswas_id', $this->siswa->id)->firstOrFail();

        $editPage = $this->withSession([
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
        ])->get(route('homepagegtk.editbiodata', $biodata->id));

        $editPage->assertStatus(200);
        $editPage->assertSee('Edit Biodata Diri Siswa');

        $updateResponse = $this->withSession([
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
        ])->put(route('homepagegtk.updatebiodata', $biodata->id), [
            'nama_lengkap' => 'Slamet Updated',
            'jenis_kelamin' => 'Laki-laki',
            'nis' => '20259999',
            'nisn' => '0099999999',
            'tempat_lahir' => 'Cibinong',
            'tanggal_lahir' => '2007-02-02',
            'alamat' => 'Jl. Baru Cibinong',
            'agama' => 'Islam',
            'kewarganegaraan' => 'WNI',
            'anak_ke' => '2',
            'jumlah_saudara' => '3',
            'no_wa' => '08988888888',
            'email' => 'slametupdated@test.com',
            'tahun_masuk' => '2025',
            'nama_ayah' => 'Ayah',
            'nama_ibu' => 'Ibu',
            'nama_wali' => '-',
            'alamat_ortu' => 'Jl. Baru Cibinong',
            'alamat_wali' => '-',
            'jarak_rumah' => '3 km',
            'transportasi_sekolah' => 'Mobil',
            'transportasi_rumah' => 'Mobil',
            'jalur_masuk' => 'Zonasi',
        ]);

        $updateResponse->assertRedirect(route('homepagegtk.biodatasiswa', $this->siswa->id));
        $this->assertDatabaseHas('biodata_siswas', [
            'id' => $biodata->id,
            'nama_lengkap' => 'Slamet Updated',
            'nis' => '20259999',
            'nisn' => '0099999999',
        ]);
        $this->assertDatabaseHas('daftar_peserta_didiks', [
            'nama_siswa' => $this->siswa->id,
            'nis' => '20259999',
            'nisn' => '0099999999',
        ]);
    }

    public function test_kurikulum_redirected_to_create_biodata_when_missing()
    {
        \Illuminate\Support\Facades\Auth::guard('kurikulums')->login($this->kurikulum);

        $response = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->get(route('kurikulum.biodatasiswa', $this->siswa->id));

        $response->assertRedirect(route('kurikulum.createbiodata', $this->siswa->id));
    }

    public function test_kurikulum_can_view_create_page_and_store_biodata()
    {
        \Illuminate\Support\Facades\Auth::guard('kurikulums')->login($this->kurikulum);
        $createPage = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->get(route('kurikulum.createbiodata', $this->siswa->id));

        $createPage->assertStatus(200);
        $createPage->assertSee('Buat Biodata Diri Siswa');

        $storeResponse = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->post(route('kurikulum.storebiodata', $this->siswa->id), [
            'nama_lengkap' => 'Slamet By Kurikulum',
            'jenis_kelamin' => 'Laki-laki',
            'nis' => '20257777',
            'nisn' => '0077777777',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2007-03-03',
            'alamat' => 'Jl. Kurikulum',
            'agama' => 'Islam',
            'kewarganegaraan' => 'WNI',
            'anak_ke' => '1',
            'jumlah_saudara' => '1',
            'no_wa' => '08777777777',
            'email' => 'kurikulum_slamet@test.com',
            'tahun_masuk' => '2025',
            'nama_ayah' => 'Ayah K',
            'nama_ibu' => 'Ibu K',
            'nama_wali' => '-',
            'alamat_ortu' => 'Jl. Kurikulum',
            'alamat_wali' => '-',
            'jarak_rumah' => '5 km',
            'transportasi_sekolah' => 'Kereta',
            'transportasi_rumah' => 'Kereta',
            'jalur_masuk' => 'Prestasi',
        ]);

        $storeResponse->assertRedirect(route('kurikulum.biodatasiswa', $this->siswa->id));
        $this->assertDatabaseHas('biodata_siswas', [
            'siswas_id' => $this->siswa->id,
            'nama_lengkap' => 'Slamet By Kurikulum',
            'nis' => '20257777',
        ]);
        $this->assertDatabaseHas('daftar_peserta_didiks', [
            'nama_siswa' => $this->siswa->id,
            'nis' => '20257777',
            'nisn' => '0077777777',
        ]);
    }

    public function test_kurikulum_can_edit_and_update_biodata()
    {
        \Illuminate\Support\Facades\Auth::guard('kurikulums')->login($this->kurikulum);

        $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->post(route('kurikulum.storebiodata', $this->siswa->id), [
            'nama_lengkap' => 'Slamet Old',
            'jenis_kelamin' => 'Laki-laki',
            'nis' => '20251111',
            'nisn' => '0011111111',
        ]);

        $biodata = BiodataSiswa::where('siswas_id', $this->siswa->id)->firstOrFail();

        $editPage = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->get(route('kurikulum.editbiodata', $biodata->id));

        $editPage->assertStatus(200);
        $editPage->assertSee('Edit Biodata Diri Siswa');

        $updateResponse = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->put(route('kurikulum.updatebiodata', $biodata->id), [
            'nama_lengkap' => 'Slamet Final Edit',
            'jenis_kelamin' => 'Laki-laki',
            'nis' => '20258888',
            'nisn' => '0088888888',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2007-04-04',
            'alamat' => 'Jl. Bandung',
            'agama' => 'Islam',
            'kewarganegaraan' => 'WNI',
            'anak_ke' => '1',
            'jumlah_saudara' => '2',
            'no_wa' => '08888888888',
            'email' => 'bandung@test.com',
            'tahun_masuk' => '2025',
            'nama_ayah' => 'Ayah B',
            'nama_ibu' => 'Ibu B',
            'nama_wali' => '-',
            'alamat_ortu' => 'Jl. Bandung',
            'alamat_wali' => '-',
            'jarak_rumah' => '4 km',
            'transportasi_sekolah' => 'Bus',
            'transportasi_rumah' => 'Bus',
            'jalur_masuk' => 'Afirmasi',
        ]);

        $updateResponse->assertRedirect(route('kurikulum.biodatasiswa', $this->siswa->id));
        $this->assertDatabaseHas('biodata_siswas', [
            'id' => $biodata->id,
            'nama_lengkap' => 'Slamet Final Edit',
            'nis' => '20258888',
            'nisn' => '0088888888',
        ]);
        $this->assertDatabaseHas('daftar_peserta_didiks', [
            'nama_siswa' => $this->siswa->id,
            'nis' => '20258888',
            'nisn' => '0088888888',
        ]);
    }

    public function test_kurikulum_can_update_nis_and_nisn_from_daftar_peserta_didik_page()
    {
        \Illuminate\Support\Facades\Auth::guard('kurikulums')->login($this->kurikulum);

        $daftar = DaftarPesertaDidik::create([
            'walas_id' => $this->walas->id,
            'nama_siswa' => $this->siswa->id,
            'nis' => '20250001',
            'nisn' => '00010000001',
            'jenis_kelamin' => 'Laki-laki',
            'keterangan' => 'aktif',
            'tanggal' => now()->toDateString(),
        ]);

        $response = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->put(route('kurikulum.daftarpesertadidik.updateNis', $daftar->id), [
            'nis' => '20258899',
            'nisn' => '0088990011',
            'jenis_kelamin' => 'Laki-laki',
            'keterangan' => 'aktif',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('daftar_peserta_didiks', [
            'id' => $daftar->id,
            'nis' => '20258899',
            'nisn' => '0088990011',
        ]);
        $this->assertDatabaseHas('biodata_siswas', [
            'siswas_id' => $this->siswa->id,
            'nis' => '20258899',
            'nisn' => '0088990011',
        ]);
    }

    public function test_student_input_page_displays_nis_from_daftar_peserta_didik_when_biodata_missing()
    {
        DaftarPesertaDidik::create([
            'walas_id' => $this->walas->id,
            'nama_siswa' => $this->siswa->id,
            'nis' => '20257788',
            'nisn' => '0077889900',
            'jenis_kelamin' => 'Laki-laki',
            'keterangan' => 'aktif',
            'tanggal' => now()->toDateString(),
        ]);

        \Illuminate\Support\Facades\Auth::guard('siswas')->login($this->siswa);

        $response = $this->withSession([
            'siswa_id' => $this->siswa->id,
        ])->get('/inputdatadiri');

        $response->assertStatus(200);
        $response->assertSee('value="20257788"', false);
    }

    public function test_walas_biodata_and_edit_does_not_leak_to_kurikulum_even_with_leftover_kurikulum_session()
    {
        $this->withSession([
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
        ])->post(route('homepagegtk.storebiodata', $this->siswa->id), [
            'nama_lengkap' => $this->siswa->nama,
            'nis' => '20251122',
            'nisn' => '0011223344',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        $biodata = BiodataSiswa::where('siswas_id', $this->siswa->id)->firstOrFail();

        // Simulasikan session memiliki kurikulum_id dan kurikulum_nama (sisa login kurikulum sebelumnya)
        $sessionData = [
            'walas_id' => $this->walas->id,
            'rombel_id' => $this->rombel->id,
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ];

        // 1. Cek halaman biodata Walas
        $showResponse = $this->withSession($sessionData)->get(route('homepagegtk.biodatasiswa', $this->siswa->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('/walaspage');
        $showResponse->assertDontSee('/kurikulumpage');
        $showResponse->assertDontSee('/profilekurikulum');
        $showResponse->assertSee(route('homepagegtk.editbiodata', $biodata->id));
        $showResponse->assertDontSee(route('kurikulum.editbiodata', $biodata->id));

        // 2. Cek halaman edit biodata Walas
        $editResponse = $this->withSession($sessionData)->get(route('homepagegtk.editbiodata', $biodata->id));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('/walaspage');
        $editResponse->assertDontSee('/kurikulumpage');
        $editResponse->assertDontSee('/profilekurikulum');
        $editResponse->assertSee(route('homepagegtk.updatebiodata', $biodata->id));
        $editResponse->assertDontSee(route('kurikulum.updatebiodata', $biodata->id));
        $editResponse->assertSee(route('homepagegtk.biodatasiswa', $biodata->siswas_id));

        // 3. Cek halaman create biodata Walas
        $biodata->delete();
        $createResponse = $this->withSession($sessionData)->get(route('homepagegtk.createbiodata', $this->siswa->id));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('/walaspage');
        $createResponse->assertDontSee('/kurikulumpage');
        $createResponse->assertDontSee('/profilekurikulum');
        $createResponse->assertSee(route('homepagegtk.storebiodata', $this->siswa->id));
        $createResponse->assertDontSee(route('kurikulum.storebiodata', $this->siswa->id));
        $createResponse->assertSee(route('siswadata.index'));
    }

    public function test_login_walas_clears_leftover_kurikulum_session()
    {
        $response = $this->withSession([
            'kurikulum_id' => 999,
            'kurikulum_nama' => 'Kurikulum Lama',
        ])->post('/logingtk', [
            'nama' => 'Walas Uji',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('homepagegtk.index'));
        $this->assertEquals($this->walas->id, session('walas_id'));
        $this->assertNull(session('kurikulum_id'));
        $this->assertNull(session('kurikulum_nama'));
    }

    protected function createTestBiodata(array $overrides = []): BiodataSiswa
    {
        return BiodataSiswa::create(array_merge([
            'siswas_id' => $this->siswa->id,
            'walas_id' => $this->walas->id,
            'nama_lengkap' => $this->siswa->nama,
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2007-01-01',
            'alamat' => 'Jl. Pemda Cibinong',
            'alamat_maps' => 'https://maps.google.com/?q=-6.48,106.85',
            'jarak_rumah' => '5 km',
            'transportasi_sekolah' => 'Motor',
            'transportasi_rumah' => 'Motor',
            'agama' => 'Islam',
            'kewarganegaraan' => 'Indonesia',
            'anak_ke' => '1',
            'jumlah_saudara' => '1',
            'no_wa' => '081234567890',
            'email' => 'slamet@student.sch.id',
            'nis' => sprintf('999%05d', rand(10000, 99999)),
            'nisn' => sprintf('0099%06d', rand(100000, 999999)),
            'kelas' => 'XII',
            'kompetensi' => 'SIJA',
            'tahun_masuk' => '2025',
            'nama_ayah' => 'Ayah Slamet',
            'pekerjaan_ayah' => 'TNI/POLRI',
            'tempat_lahir_ayah' => 'Bogor',
            'tanggal_lahir_ayah' => '1980-01-01',
            'alamat_ayah' => 'Jl. Pemda Cibinong',
            'no_wa_ayah' => '081234567891',
            'nama_ibu' => 'Ibu Slamet',
            'pekerjaan_ibu' => 'ASN/PNS',
            'tempat_lahir_ibu' => 'Bogor',
            'tanggal_lahir_ibu' => '1982-01-01',
            'alamat_ibu' => 'Jl. Pemda Cibinong',
            'no_wa_ibu' => '081234567892',
            'pendapatan_ortu' => 'Rp3.000.000,00 - Rp5.000.000,00',
            'namasekolah_asal' => 'SMPN 1 Cibinong',
            'alamat_sekolah' => 'Jl. Cibinong',
            'tahun_lulus' => '2024',
            'riwayat_penyakit' => 'Tidak ada',
            'alergi' => 'Tidak ada',
            'prestasi_akademik' => 'Juara 1',
            'prestasi_non_akademik' => 'Juara 2',
            'pengalaman_ekskul' => 'Pramuka',
            'kepribadian' => 'Disiplin',
        ], $overrides));
    }

    public function test_kurikulum_biodata_page_renders_cleanly_with_asset_helpers_and_no_relative_asset_paths()
    {
        \Illuminate\Support\Facades\Auth::guard('kurikulums')->login($this->kurikulum);

        $this->createTestBiodata();

        $response = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->get(route('kurikulum.biodatasiswa', $this->siswa->id));

        $response->assertStatus(200);
        $content = $response->getContent();
        // Asset helper renders http://.../assets/... or /assets/... without corrupt relative path
        $this->assertStringNotContainsString('../../assets/', $content);
        $this->assertStringNotContainsString('/../../assets/', $content);
        $this->assertStringNotContainsString('width: 300%', $content);
        $this->assertStringNotContainsString('width: 310%', $content);
        $this->assertStringContainsString('TNI/POLRI', $content);
        $this->assertStringContainsString('ASN/PNS', $content);
    }

    public function test_biodata_edit_does_not_force_reentry_of_existing_pekerjaan_and_preserves_on_update()
    {
        \Illuminate\Support\Facades\Auth::guard('kurikulums')->login($this->kurikulum);

        $biodata = $this->createTestBiodata([
            'pekerjaan_ayah' => 'TNI/POLRI',
            'pekerjaan_ibu' => 'ASN/PNS',
            'pendapatan_ortu' => 'Rp3.000.000,00 - Rp5.000.000,00',
        ]);

        // Cek halaman edit
        $editResponse = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->get(route('kurikulum.editbiodata', $biodata->id));

        $editResponse->assertStatus(200);
        $editContent = $editResponse->getContent();

        // Indikasi pekerjaan sudah terisi
        $this->assertStringContainsString('Sudah terisi:', $editContent);
        $this->assertStringContainsString('TNI/POLRI', $editContent);
        $this->assertStringContainsString('ASN/PNS', $editContent);

        // Update tanpa memasukkan pekerjaan ayah, ibu, pendapatan ortu
        $updateResponse = $this->withSession([
            'kurikulum_id' => $this->kurikulum->id,
            'kurikulum_nama' => $this->kurikulum->nama,
        ])->put(route('kurikulum.updatebiodata', $biodata->id), [
            'nama_lengkap' => 'Slamet Nama Berubah',
            'jenis_kelamin' => 'Laki-laki',
            'nisn' => $biodata->nisn,
            'pekerjaan_ayah' => '',
            'pekerjaan_ibu' => '',
            'pendapatan_ortu' => '',
        ]);

        $updateResponse->assertRedirect(route('kurikulum.biodatasiswa', $this->siswa->id));

        $biodata->refresh();
        $this->assertEquals('Slamet Nama Berubah', $biodata->nama_lengkap);
        // Pekerjaan dan pendapatan lama tetap dipertahankan
        $this->assertEquals('TNI/POLRI', $biodata->pekerjaan_ayah);
        $this->assertEquals('ASN/PNS', $biodata->pekerjaan_ibu);
        $this->assertEquals('Rp3.000.000,00 - Rp5.000.000,00', $biodata->pendapatan_ortu);
    }
}
