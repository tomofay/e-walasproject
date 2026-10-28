<?php

namespace Tests\Feature;

use App\Models\CatatanKasusSiswa;
use App\Models\DetailPresensi;
use App\Models\PembinaSiswa;
use App\Models\Presensi;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Walas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PembinaSiswaTest extends TestCase
{
    use RefreshDatabase;

    protected $pembina;
    protected $walas;
    protected $rombel;
    protected $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pembina = PembinaSiswa::create([
            'nama' => 'Pembina Siswa Penguji',
            'nip' => '199912312020011009',
            'no_wa' => '081234567890',
            'password' => Hash::make('password123'),
        ]);

        $this->walas = Walas::create([
            'nama' => 'Wali Kelas X SIJA 1',
            'nip' => '198001012005011002',
            'email' => 'walas@test.com',
            'password' => Hash::make('password'),
            'no_wa' => '081298765432',
            'gender' => 'Laki-laki',
        ]);

        $this->rombel = Rombel::create([
            'nama_kelas' => 'X SIJA 1',
            'tingkat' => 'X',
            'kompetensi' => 'SIJA',
            'walas_id' => $this->walas->id,
        ]);

        $this->siswa = Siswa::create([
            'nama' => 'Budi Santoso',
            'rombels_id' => $this->rombel->id,
            'jenis_kelamin' => 'Laki-laki',
            'no_wa' => '081234567891',
            'tahun_masuk' => '2025',
            'status' => 'aktif',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_landing_page_displays_pembina_siswa_login_card(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Pembina Siswa');
        $response->assertSee('/loginpembinasiswa');
    }

    public function test_login_pembina_page_renders(): void
    {
        $response = $this->get(route('loginpembinasiswa.index'));
        $response->assertStatus(200);
        $response->assertSee('Pembina Siswa');
        $response->assertSee('Nama / NIP');
    }

    public function test_pembina_can_login_with_valid_credentials(): void
    {
        $response = $this->post(route('loginpembinasiswa.store'), [
            'nama' => '199912312020011009',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('pembina.dashboard'));
        $this->assertAuthenticatedAs($this->pembina, 'pembinas');
        $this->assertEquals($this->pembina->id, session('pembina_id'));
    }

    public function test_pembina_cannot_login_with_wrong_password(): void
    {
        $response = $this->post(route('loginpembinasiswa.store'), [
            'nama' => '199912312020011009',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest('pembinas');
    }

    public function test_unauthenticated_user_cannot_access_pembina_dashboard(): void
    {
        $response = $this->get(route('pembina.dashboard'));
        $response->assertRedirect('/loginpembinasiswa');
    }

    public function test_pembina_dashboard_renders_with_statistics(): void
    {
        $response = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->get(route('pembina.dashboard'));

        $response->assertStatus(200);
        $response->assertSee($this->pembina->nama);
        $response->assertSee('Catatan Kasus Siswa');
        $response->assertSee('Daftar Hadir');
    }

    public function test_pembina_can_view_catatankasus_list(): void
    {
        CatatanKasusSiswa::create([
            'walas_id' => $this->walas->id,
            'siswas_id' => $this->siswa->id,
            'tanggal' => now()->toDateString(),
            'waktu' => '08:30',
            'kasus' => 'Terlambat masuk gerbang sekolah',
            'tindak_lanjut' => 'Diberi teguran lisan',
            'keterangan' => 'Pertama kali',
        ]);

        $response = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->get(route('pembina.catatankasus.index'));

        $response->assertStatus(200);
        $response->assertSee('Terlambat masuk gerbang sekolah');
        $response->assertSee('Budi Santoso');
    }

    public function test_pembina_can_create_catatankasus_for_any_student(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->post(route('pembina.catatankasus.store'), [
                'siswas_id' => $this->siswa->id,
                'tanggal' => '2026-10-28',
                'waktu' => '09:00',
                'kasus' => 'Tidak mengenakan seragam sesuai jadwal',
                'tindak_lanjut' => 'Pembinaan dan peringatan tertulis',
                'keterangan' => 'Orang tua diberitahu via WA',
                'file_kasus' => [
                    UploadedFile::fake()->create('surat_pernyataan.pdf', 200, 'application/pdf'),
                ],
            ]);

        $response->assertRedirect(route('pembina.catatankasus.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('catatan_kasus_siswas', [
            'siswas_id' => $this->siswa->id,
            'walas_id' => $this->walas->id,
            'kasus' => 'Tidak mengenakan seragam sesuai jadwal',
            'tindak_lanjut' => 'Pembinaan dan peringatan tertulis',
        ]);
    }

    public function test_pembina_can_edit_catatankasus(): void
    {
        $kasus = CatatanKasusSiswa::create([
            'walas_id' => $this->walas->id,
            'siswas_id' => $this->siswa->id,
            'tanggal' => '2026-10-28',
            'waktu' => '10:00',
            'kasus' => 'Kasus Awal',
            'tindak_lanjut' => 'Tindak Awal',
            'keterangan' => 'Ket Awal',
        ]);

        $response = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->put(route('pembina.catatankasus.update', $kasus->id), [
                'siswas_id' => $this->siswa->id,
                'tanggal' => '2026-10-28',
                'waktu' => '10:30',
                'kasus' => 'Kasus Diperbarui',
                'tindak_lanjut' => 'Tindak Lanjut Diperbarui',
                'keterangan' => 'Ket Diperbarui',
            ]);

        $response->assertRedirect(route('pembina.catatankasus.index'));
        $this->assertDatabaseHas('catatan_kasus_siswas', [
            'id' => $kasus->id,
            'kasus' => 'Kasus Diperbarui',
            'tindak_lanjut' => 'Tindak Lanjut Diperbarui',
        ]);
    }

    public function test_pembina_can_delete_catatankasus(): void
    {
        $kasus = CatatanKasusSiswa::create([
            'walas_id' => $this->walas->id,
            'siswas_id' => $this->siswa->id,
            'tanggal' => '2026-10-28',
            'waktu' => '11:00',
            'kasus' => 'Kasus Dihapus',
            'tindak_lanjut' => 'Sanksi',
            'keterangan' => 'Test',
        ]);

        $response = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->delete(route('pembina.catatankasus.destroy', $kasus->id));

        $response->assertRedirect(route('pembina.catatankasus.index'));
        $this->assertDatabaseMissing('catatan_kasus_siswas', [
            'id' => $kasus->id,
        ]);
    }

    public function test_pembina_can_view_presensi_and_detail(): void
    {
        $presensi = Presensi::create([
            'walas_id' => $this->walas->id,
            'kelas' => $this->rombel->nama_kelas,
            'tanggal' => now()->toDateString(),
        ]);

        DetailPresensi::create([
            'presensis_id' => $presensi->id,
            'siswas_id' => $this->siswa->id,
            'status' => 'hadir',
        ]);

        $response = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->get(route('pembina.presensi.index'));

        $response->assertStatus(200);
        $response->assertSee($this->rombel->nama_kelas);

        $detailResponse = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->get(route('pembina.presensi.detail', $presensi->id));

        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Budi Santoso');
        $detailResponse->assertSee('hadir', false);
    }

    public function test_pembina_can_view_and_update_profile(): void
    {
        $response = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->get(route('pembina.profile'));

        $response->assertStatus(200);
        $response->assertSee($this->pembina->nama);

        $editResponse = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->get(route('pembina.profile.edit'));

        $editResponse->assertStatus(200);
        $editResponse->assertSee($this->pembina->nama);

        $updateResponse = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->put(route('pembina.profile.update'), [
                'nama' => 'Pembina Siswa Baru',
                'nip' => '198501012010011001',
                'no_wa' => '089988776655',
            ]);

        $updateResponse->assertRedirect(route('pembina.profile'));
        $this->assertDatabaseHas('pembina_siswas', [
            'id' => $this->pembina->id,
            'nama' => 'Pembina Siswa Baru',
            'no_wa' => '089988776655',
        ]);
    }

    public function test_pembina_can_logout(): void
    {
        $response = $this->actingAs($this->pembina, 'pembinas')
            ->withSession(['pembina_id' => $this->pembina->id])
            ->post(route('pembina.logout'));

        $response->assertRedirect('/');
        $this->assertGuest('pembinas');
    }
}
