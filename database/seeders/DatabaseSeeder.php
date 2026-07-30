<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kakom;
use App\Models\Kepsek;
use App\Models\Kurikulum;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Walas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = '12345678';

        // ── Admin ──
        $admin = Admin::create([
            'nama'      => 'admin',
            'no_wa'     => '081234567890',
            'password'  => $password,
        ]);

        // ── Walas ──
        $walas1 = Walas::create([
            'nama'          => 'Budi Santoso, S.Pd.',
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081111111111',
            'password'      => $password,
            'nip'           => '198501012010011001',
        ]);

        $walas2 = Walas::create([
            'nama'          => 'Siti Aminah, S.Pd.',
            'jenis_kelamin' => 'Perempuan',
            'no_wa'         => '081111111112',
            'password'      => $password,
            'nip'           => '198602022010012002',
        ]);

        // ── Kakom ──
        $kakomSIJA = Kakom::create([
            'nama'       => 'Drs. Rahmat Hidayat',
            'no_wa'      => '082222222221',
            'password'   => $password,
            'kompetensi' => 'SIJA',
        ]);

        $kakomRPL = Kakom::create([
            'nama'       => 'Dewi Lestari, S.Kom.',
            'no_wa'      => '082222222222',
            'password'   => $password,
            'kompetensi' => 'RPL',
        ]);

        // ── Kepsek ──
        $kepsek = Kepsek::create([
            'nama'     => 'Drs. H. Ahmad Fauzi, M.Pd.',
            'no_wa'    => '083333333333',
            'password' => $password,
        ]);

        // ── Kurikulum ──
        $kurikulum = Kurikulum::create([
            'nama'     => 'Sri Wahyuni, M.Pd.',
            'no_wa'    => '084444444444',
            'password' => $password,
            'nip'      => '197803032005012003',
        ]);

        // ── Guru ──
        Guru::create(['nama' => 'Agus Prayitno, S.Pd.']);
        Guru::create(['nama' => 'Rina Marlina, S.Pd.']);
        Guru::create(['nama' => 'Dedi Kurniawan, M.Kom.']);
        Guru::create(['nama' => 'Fitriani, S.T.']);
        Guru::create(['nama' => 'Hendra Gunawan, S.Pd.']);

        // ── Mapel ──
        Mapel::create(['nama_mapel' => 'Pendidikan Agama Islam']);
        Mapel::create(['nama_mapel' => 'Pendidikan Pancasila']);
        Mapel::create(['nama_mapel' => 'Bahasa Indonesia']);
        Mapel::create(['nama_mapel' => 'Matematika']);
        Mapel::create(['nama_mapel' => 'Bahasa Inggris']);
        Mapel::create(['nama_mapel' => 'PJOK']);
        Mapel::create(['nama_mapel' => 'Kokurikuler']);
        Mapel::create(['nama_mapel' => 'Bahasa Jepang']);
        Mapel::create(['nama_mapel' => 'PKK']);
        Mapel::create(['nama_mapel' => 'Seni Tari']);
        Mapel::create(['nama_mapel' => 'Sejarah']);
        Mapel::create(['nama_mapel' => 'Dev Ops']);
        Mapel::create(['nama_mapel' => 'FTTX']);
        Mapel::create(['nama_mapel' => 'Networking']);
        Mapel::create(['nama_mapel' => 'CCNA']);
        Mapel::create(['nama_mapel' => 'Informatika']);
        Mapel::create(['nama_mapel' => 'IPAS']);
        Mapel::create(['nama_mapel' => 'Web Dev']);
        Mapel::create(['nama_mapel' => 'Mobile Dev']);

    
        // ── Rombel ──
        $rombelSIJA = Rombel::create([
            'tingkat'     => 'X',
            'kompetensi'  => 'SIJA',
            'nama_kelas'  => 'X SIJA 1',
            'walas_id'    => $walas1->id,
        ]);

        $rombelRPL = Rombel::create([
            'tingkat'     => 'X',
            'kompetensi'  => 'RPL',
            'nama_kelas'  => 'X RPL 1',
            'walas_id'    => $walas2->id,
        ]);

        $rombelSIJA2 = Rombel::create([
            'tingkat'     => 'XI',
            'kompetensi'  => 'SIJA',
            'nama_kelas'  => 'XI SIJA 1',
            'walas_id'    => $walas1->id,
        ]);

        // ── Siswa (X SIJA 1) ──
        $siswaNamesSIJA = ['Andi Pratama', 'Bunga Citra', 'Candra Wijaya', 'Dian Permata', 'Eko Saputra'];
        foreach ($siswaNamesSIJA as $nama) {
            Siswa::create([
                'nama'          => $nama,
                'rombels_id'    => $rombelSIJA->id,
                'jenis_kelamin' => in_array($nama, ['Bunga Citra', 'Dian Permata']) ? 'Perempuan' : 'Laki-laki',
                'no_wa'         => '08500000000' . rand(1, 9),
                'password'      => $password,
                'status'        => 'aktif',
            ]);
        }

        // ── Siswa (X RPL 1) ──
        $siswaNamesRPL = ['Fahri Ramadhan', 'Gita Savitri', 'Hadi Prasetyo', 'Intan Nuraini', 'Joko Widodo'];
        foreach ($siswaNamesRPL as $nama) {
            Siswa::create([
                'nama'          => $nama,
                'rombels_id'    => $rombelRPL->id,
                'jenis_kelamin' => in_array($nama, ['Gita Savitri', 'Intan Nuraini']) ? 'Perempuan' : 'Laki-laki',
                'no_wa'         => '08500000001' . rand(1, 9),
                'password'      => $password,
                'status'        => 'aktif',
            ]);
        }

        // ── Siswa (XI SIJA 1) ──
        $siswaNamesSIJA2 = ['Kartika Sari', 'Lukman Hakim', 'Mega Putri', 'Nanda Pratama', 'Oki Setiawan'];
        foreach ($siswaNamesSIJA2 as $nama) {
            Siswa::create([
                'nama'          => $nama,
                'rombels_id'    => $rombelSIJA2->id,
                'jenis_kelamin' => in_array($nama, ['Kartika Sari', 'Mega Putri']) ? 'Perempuan' : 'Laki-laki',
                'no_wa'         => '08500000002' . rand(1, 9),
                'password'      => $password,
                'status'        => 'aktif',
            ]);
        }
    }
}
