<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Support\AcademicYear;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->resetSeedData();

        $password = Hash::make('12345678');

        [$walasIds, $kakomIds, $kurikulumIds, $kepsekIds, $guruIds, $mapelIds] = $this->seedMasterData($password);
        [$rombelIds, $siswaIds] = $this->seedAcademicData($password, $walasIds, $kakomIds, $kurikulumIds, $kepsekIds, $guruIds, $mapelIds);

        $this->seedClassRoomData($rombelIds, $siswaIds, $kakomIds, $kurikulumIds, $kepsekIds, $walasIds, $guruIds, $mapelIds);
        $this->seedAdministrationData($rombelIds, $siswaIds, $kakomIds, $kurikulumIds, $kepsekIds, $walasIds, $guruIds, $mapelIds);

        $this->call(TemplateSeeder::class);
    }

    private function resetSeedData(): void
    {
        $tables = [
            'kelompok_siswa',
            'detail_jadwal_pikets',
            'jadwal_pikets',
            'presensis',
            'detail_presensis',
            'catatan_kasus_siswas',
            'home_visits',
            'buku_tamu_orangtuas',
            'agenda_kegiatan_walas',
            'rencana_kegiatan_walas_genaps',
            'rencana_kegiatan_walas',
            'rekapitulasi_jumlah_siswas',
            'daftar_peserta_didiks',
            'berita_acara_kelulusans',
            'berita_acara_kenaikans',
            'berita_acara_serah_terimas',
            'alumnis',
            'daftar_serah_terima_rapors',
            'lembar_pengesahans',
            'persentase_sosial_ekonomis',
            'prestasi_siswas',
            'keluar_rombels',
            'biodata_siswas',
            'siswas',
            'rombels',
            'jadwal_kbms',
            'denah_tempat_kerja_kelompoks',
            'struktur_organisasi_kelas',
            'identitas_kelas',
            'mapels',
            'walas',
            'kakoms',
            'kurikulums',
            'kepseks',
            'gurus',
            'admins',
        ];

        foreach ($tables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->delete();
            }
        }
    }

    private function seedMasterData(string $password): array
    {
        DB::table('admins')->insert([
            ['nama' => 'admin', 'no_wa' => '081234567890', 'password' => $password, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $walas = [
            ['nama' => 'Budi Santoso, S.Pd.', 'jenis_kelamin' => 'Laki-laki', 'no_wa' => '081111111111', 'password' => $password, 'nip' => '198501012010011001'],
            ['nama' => 'Siti Aminah, S.Pd.', 'jenis_kelamin' => 'Perempuan', 'no_wa' => '081111111112', 'password' => $password, 'nip' => '198602022010012002'],
            ['nama' => 'Rizki Pratama, S.Pd.', 'jenis_kelamin' => 'Laki-laki', 'no_wa' => '081111111113', 'password' => $password, 'nip' => '198705032010011003'],
        ];

        $walasIds = [];
        foreach ($walas as $item) {
            $walasIds[] = DB::table('walas')->insertGetId([...$item, 'created_at' => now(), 'updated_at' => now()]);
        }

        $kakom = [
            ['nama' => 'Drs. Rahmat Hidayat', 'no_wa' => '082222222221', 'password' => $password, 'kompetensi' => 'SIJA'],
            ['nama' => 'Dewi Lestari, S.Kom.', 'no_wa' => '082222222222', 'password' => $password, 'kompetensi' => 'RPL'],
            ['nama' => 'Rian Setiawan, M.Kom.', 'no_wa' => '082222222223', 'password' => $password, 'kompetensi' => 'TKJ'],
        ];

        $kakomIds = [];
        foreach ($kakom as $item) {
            $kakomIds[] = DB::table('kakoms')->insertGetId([...$item, 'created_at' => now(), 'updated_at' => now()]);
        }

        $kurikulums = [
            ['nama' => 'Sri Wahyuni, M.Pd.', 'no_wa' => '084444444444', 'password' => $password, 'nip' => '197803032005012003'],
            ['nama' => 'Maya Fitriani, M.Pd.', 'no_wa' => '084444444445', 'password' => $password, 'nip' => '198009052009012004'],
        ];

        $kurikulumIds = [];
        foreach ($kurikulums as $item) {
            $kurikulumIds[] = DB::table('kurikulums')->insertGetId([...$item, 'created_at' => now(), 'updated_at' => now()]);
        }

        $kepseks = [
            ['nama' => 'Drs. H. Ahmad Fauzi, M.Pd.', 'no_wa' => '083333333333', 'password' => $password],
            ['nama' => 'M. Yusuf, S.Pd., M.M.', 'no_wa' => '083333333334', 'password' => $password],
        ];

        $kepsekIds = [];
        foreach ($kepseks as $item) {
            $kepsekIds[] = DB::table('kepseks')->insertGetId([...$item, 'created_at' => now(), 'updated_at' => now()]);
        }

        $guruNames = ['Agus Prayitno, S.Pd.', 'Rina Marlina, S.Pd.', 'Dedi Kurniawan, M.Kom.', 'Fitriani, S.T.', 'Hendra Gunawan, S.Pd.'];
        $guruIds = [];
        foreach ($guruNames as $name) {
            $guruIds[] = DB::table('gurus')->insertGetId(['nama' => $name, 'created_at' => now(), 'updated_at' => now()]);
        }

        $mapelNames = ['Pendidikan Agama Islam', 'Pendidikan Pancasila', 'Bahasa Indonesia', 'Matematika', 'Bahasa Inggris', 'PJOK', 'Kokurikuler', 'Bahasa Jepang', 'PKK', 'Seni Tari', 'Sejarah', 'Dev Ops', 'FTTX', 'Networking', 'CCNA', 'Informatika', 'IPAS', 'Web Dev', 'Mobile Dev'];
        $mapelIds = [];
        foreach ($mapelNames as $name) {
            $mapelIds[] = DB::table('mapels')->insertGetId(['nama_mapel' => $name, 'created_at' => now(), 'updated_at' => now()]);
        }

        return [$walasIds, $kakomIds, $kurikulumIds, $kepsekIds, $guruIds, $mapelIds];
    }

    private function seedAcademicData(string $password, array $walasIds, array $kakomIds, array $kurikulumIds, array $kepsekIds, array $guruIds, array $mapelIds): array
    {
        $rombelData = [
            ['tingkat' => 'X', 'kompetensi' => 'SIJA', 'nama_kelas' => 'X SIJA 1', 'walas_id' => $walasIds[0]],
            ['tingkat' => 'X', 'kompetensi' => 'RPL', 'nama_kelas' => 'X RPL 1', 'walas_id' => $walasIds[1]],
            ['tingkat' => 'XI', 'kompetensi' => 'SIJA', 'nama_kelas' => 'XI SIJA 1', 'walas_id' => $walasIds[0]],
            ['tingkat' => 'XI', 'kompetensi' => 'RPL', 'nama_kelas' => 'XI RPL 1', 'walas_id' => $walasIds[1]],
            ['tingkat' => 'XII', 'kompetensi' => 'TKJ', 'nama_kelas' => 'XII TKJ 1', 'walas_id' => $walasIds[2]],
        ];

        $rombelIds = [];
        foreach ($rombelData as $item) {
            $rombelIds[] = DB::table('rombels')->insertGetId([...$item, 'created_at' => now(), 'updated_at' => now()]);
        }

        $siswaData = [
            ['nama' => 'Andi Pratama', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000001', 'status' => 'aktif'],
            ['nama' => 'Bunga Citra', 'jenis_kelamin' => 'Perempuan', 'rombel_index' => 0, 'no_wa' => '08500000002', 'status' => 'aktif'],
            ['nama' => 'Candra Wijaya', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000003', 'status' => 'aktif'],
            ['nama' => 'Dian Permata', 'jenis_kelamin' => 'Perempuan', 'rombel_index' => 0, 'no_wa' => '08500000004', 'status' => 'aktif'],
            ['nama' => 'Eko Saputra', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000005', 'status' => 'aktif'],
            ['nama' => 'Fahri Ramadhan', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000006', 'status' => 'aktif'],
            ['nama' => 'Gita Savitri', 'jenis_kelamin' => 'Perempuan', 'rombel_index' => 0, 'no_wa' => '08500000007', 'status' => 'aktif'],
            ['nama' => 'Hadi Prasetyo', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000008', 'status' => 'aktif'],
            ['nama' => 'Intan Nuraini', 'jenis_kelamin' => 'Perempuan', 'rombel_index' => 0, 'no_wa' => '08500000009', 'status' => 'aktif'],
            ['nama' => 'Joko Widodo', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000010', 'status' => 'aktif'],
            ['nama' => 'Kartika Sari', 'jenis_kelamin' => 'Perempuan', 'rombel_index' => 0, 'no_wa' => '08500000011', 'status' => 'aktif'],
            ['nama' => 'Lukman Hakim', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000012', 'status' => 'aktif'],
            ['nama' => 'Mega Putri', 'jenis_kelamin' => 'Perempuan', 'rombel_index' => 0, 'no_wa' => '08500000013', 'status' => 'aktif'],
            ['nama' => 'Nanda Pratama', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000014', 'status' => 'aktif'],
            ['nama' => 'Oki Setiawan', 'jenis_kelamin' => 'Laki-laki', 'rombel_index' => 0, 'no_wa' => '08500000015', 'status' => 'aktif'],
        ];

        $siswaIds = [];
        $biodata = [];
        foreach ($siswaData as $index => $student) {
            $siswaId = DB::table('siswas')->insertGetId([
                'nama' => $student['nama'],
                'rombels_id' => $rombelIds[$student['rombel_index']],
                'jenis_kelamin' => $student['jenis_kelamin'],
                'no_wa' => $student['no_wa'],
                'password' => $password,
                'image_url' => null,
                'status' => $student['status'],
                'keterangan' => 'naik_kelas',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $siswaIds[] = $siswaId;
            $biodata[] = [
                'walas_id' => $walasIds[$student['rombel_index'] % count($walasIds)],
                'siswas_id' => $siswaId,
                'nama_lengkap' => $student['nama'],
                'jenis_kelamin' => $student['jenis_kelamin'],
                'tempat_lahir' => ['Bandung', 'Semarang', 'Surabaya', 'Yogyakarta', 'Malang'][($index % 5)],
                'tanggal_lahir' => date('Y-m-d', strtotime('-16 years', strtotime('2025-01-10')) + ($index * 86400)),
                'alamat' => 'Jl. Raya ' . ($index + 1) . ' No. ' . ($index + 10) . ', Kota ' . ['Bandung', 'Semarang', 'Surabaya'][($index % 3)],
                'alamat_maps' => 'https://maps.google.com/?q=' . rawurlencode('Kota ' . ['Bandung', 'Semarang', 'Surabaya'][($index % 3)]),
                'kepemilikan_rumah' => ['Lunas', 'Sewa', 'KPR/Kredit', 'Kontrak'][($index % 4)],
                'jalur_masuk' => ['Rapor', 'Zonasi', 'Prestasi', 'Afirmasi'][($index % 4)],
                'jarak_rumah' => ((($index + 1) * 4) + 2) . ' km',
                'transportasi_sekolah' => ['Jalan kaki', 'Sepeda', 'Angkot', 'Motor Orang Tua'][($index % 4)],
                'transportasi_rumah' => ['Mobil', 'Motor', 'Jalan kaki', 'Angkot'][($index % 4)],
                'agama' => ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu'][($index % 4)],
                'kewarganegaraan' => 'Indonesia',
                'anak_ke' => (string) (($index % 3) + 1),
                'jumlah_saudara' => (string) (($index % 4) + 1),
                'no_wa' => $student['no_wa'],
                'email' => strtolower(str_replace(' ', '.', $student['nama'])) . '@student.sch.id',
                'nis' => sprintf('2025%04d', $index + 1),
                'nisn' => sprintf('000%08d', $index + 10000001),
                'kelas' => $rombelData[$student['rombel_index']]['nama_kelas'],
                'kompetensi' => $rombelData[$student['rombel_index']]['kompetensi'],
                'tahun_masuk' => '2025',
                'nama_ayah' => 'Ayah ' . $student['nama'],
                'pekerjaan_ayah' => ['Karyawan Swasta', 'Wiraswasta', 'PNS', 'TNI/POLRI'][($index % 4)],
                'tempat_lahir_ayah' => ['Bandung', 'Surabaya', 'Yogyakarta'][($index % 3)],
                'tanggal_lahir_ayah' => '1978-06-15',
                'alamat_ayah' => 'Jl. Ayah No. ' . ($index + 4) . ', Kota ' . ['Bandung', 'Semarang', 'Surabaya'][($index % 3)],
                'no_wa_ayah' => '08120000' . str_pad((string) ($index + 100), 3, '0', STR_PAD_LEFT),
                'nama_ibu' => 'Ibu ' . $student['nama'],
                'pekerjaan_ibu' => ['Ibu Rumah Tangga', 'Guru', 'PNS', 'Wiraswasta'][($index % 4)],
                'tempat_lahir_ibu' => ['Bogor', 'Medan', 'Malang'][($index % 3)],
                'tanggal_lahir_ibu' => '1982-02-20',
                'alamat_ibu' => 'Jl. Ibu No. ' . ($index + 5) . ', Kota ' . ['Bandung', 'Semarang', 'Surabaya'][($index % 3)],
                'no_wa_ibu' => '08230000' . str_pad((string) ($index + 200), 3, '0', STR_PAD_LEFT),
                'pendapatan_ortu' => 'Rp 3.000.000 - Rp 5.000.000',
                'namasekolah_asal' => 'SMP ' . ['Harapan', 'Bangsa', 'Cendekia'][($index % 3)],
                'alamat_sekolah' => 'Jl. Sekolah ' . ($index + 2) . ', Kota ' . ['Bandung', 'Semarang', 'Surabaya'][($index % 3)],
                'tahun_lulus' => '2024',
                'riwayat_penyakit' => 'Tidak ada',
                'alergi' => 'Tidak ada',
                'prestasi_akademik' => 'Juara 2 Lomba Matematika',
                'prestasi_non_akademik' => 'Juara 1 Futsal',
                'pengalaman_ekskul' => 'Pramuka, Basket',
                'kepribadian' => 'Disiplin dan ramah',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('biodata_siswas')->insert($biodata);
        return [$rombelIds, $siswaIds];
    }

    private function seedClassRoomData(array $rombelIds, array $siswaIds, array $kakomIds, array $kurikulumIds, array $kepsekIds, array $walasIds, array $guruIds, array $mapelIds): void
    {

        $jadwalKbm = [
            ['rombels_id' => $rombelIds[0], 'walas_id' => $walasIds[0], 'kurikulum_id' => $kurikulumIds[0], 'tanggal' => '2025-02-03', 'ttdkurikulum_url' => 'https://example.com/ttd-kurikulum.jpg', 'ttdwalas_url' => 'https://example.com/ttd-walas.jpg', 'senin' => json_encode([['mapel_id' => $mapelIds[0], 'guru_id' => $guruIds[0], 'jam' => '07:30'], ['mapel_id' => $mapelIds[3], 'guru_id' => $guruIds[1], 'jam' => '08:15']]), 'selasa' => json_encode([['mapel_id' => $mapelIds[1], 'guru_id' => $guruIds[2], 'jam' => '07:30']]), 'rabu' => json_encode([['mapel_id' => $mapelIds[4], 'guru_id' => $guruIds[3], 'jam' => '07:30']]), 'kamis' => json_encode([['mapel_id' => $mapelIds[6], 'guru_id' => $guruIds[4], 'jam' => '07:30']]), 'jumat' => json_encode([['mapel_id' => $mapelIds[14], 'guru_id' => $guruIds[0], 'jam' => '07:30']])],
            ['rombels_id' => $rombelIds[1], 'walas_id' => $walasIds[1], 'kurikulum_id' => $kurikulumIds[1], 'tanggal' => '2025-02-04', 'ttdkurikulum_url' => 'https://example.com/ttd-kurikulum-2.jpg', 'ttdwalas_url' => 'https://example.com/ttd-walas-2.jpg', 'senin' => json_encode([['mapel_id' => $mapelIds[2], 'guru_id' => $guruIds[1], 'jam' => '07:30']]), 'selasa' => json_encode([['mapel_id' => $mapelIds[5], 'guru_id' => $guruIds[4], 'jam' => '07:30']]), 'rabu' => json_encode([['mapel_id' => $mapelIds[8], 'guru_id' => $guruIds[2], 'jam' => '07:30']]), 'kamis' => json_encode([['mapel_id' => $mapelIds[10], 'guru_id' => $guruIds[3], 'jam' => '07:30']]), 'jumat' => json_encode([['mapel_id' => $mapelIds[12], 'guru_id' => $guruIds[0], 'jam' => '07:30']])],
        ];

        foreach ($jadwalKbm as $item) {
            DB::table('jadwal_kbms')->insert([...$item, 'created_at' => now(), 'updated_at' => now()]);
        }

        $jadwalPiket = [
            ['walas_id' => $walasIds[0], 'siswas_id' => $siswaIds[0], 'nama_hari' => 'Senin', 'kurikulum_id' => $kurikulumIds[0], 'tanggal' => '2025-02-03', 'ttdkurikulum_url' => 'https://example.com/piket-kurikulum.jpg', 'ttdwalas_url' => 'https://example.com/piket-walas.jpg'],
            ['walas_id' => $walasIds[1], 'siswas_id' => $siswaIds[5], 'nama_hari' => 'Selasa', 'kurikulum_id' => $kurikulumIds[1], 'tanggal' => '2025-02-04', 'ttdkurikulum_url' => 'https://example.com/piket-kurikulum-2.jpg', 'ttdwalas_url' => 'https://example.com/piket-walas-2.jpg'],
        ];

        $jadwalPiketIds = [];
        foreach ($jadwalPiket as $item) {
            $jadwalPiketIds[] = DB::table('jadwal_pikets')->insertGetId([...$item, 'created_at' => now(), 'updated_at' => now()]);
        }

        foreach ($jadwalPiketIds as $index => $jadwalPiketId) {
            DB::table('detail_jadwal_pikets')->insert([
                ['jadwalpikets_id' => $jadwalPiketId, 'siswas_id' => $siswaIds[$index], 'created_at' => now(), 'updated_at' => now()],
                ['jadwalpikets_id' => $jadwalPiketId, 'siswas_id' => $siswaIds[$index + 1], 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        $denahGroups = [
            ['walas_id' => $walasIds[0], 'siswas_id' => $siswaIds[0], 'nama_kelompok' => 'Kelompok A'],
            ['walas_id' => $walasIds[1], 'siswas_id' => $siswaIds[5], 'nama_kelompok' => 'Kelompok B'],
        ];

        $denahIds = [];
        foreach ($denahGroups as $group) {
            $denahIds[] = DB::table('denah_tempat_kerja_kelompoks')->insertGetId([...$group, 'created_at' => now(), 'updated_at' => now()]);
        }

        foreach ($denahIds as $index => $groupId) {
            DB::table('kelompok_siswa')->insert([
                ['kelompok_id' => $groupId, 'siswa_id' => $siswaIds[$index], 'created_at' => now(), 'updated_at' => now()],
                ['kelompok_id' => $groupId, 'siswa_id' => $siswaIds[$index + 2], 'created_at' => now(), 'updated_at' => now()],
                ['kelompok_id' => $groupId, 'siswa_id' => $siswaIds[$index + 4], 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        DB::table('identitas_kelas')->insert([
            [
                'walas_id' => $walasIds[0],
                'program_keahlian' => 'SIJA',
                'kompetensi_keahlian' => 'SIJA',
                'walas_id_10' => $walasIds[0],
                'walas_id_11' => $walasIds[1],
                'walas_id_12' => $walasIds[1],
                'walas_id_13' => $walasIds[2],
                'siswas_id_10' => $siswaIds[0],
                'siswas_id_11' => $siswaIds[1],
                'siswas_id_12' => $siswaIds[2],
                'siswas_id_13' => $siswaIds[3],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('struktur_organisasi_kelas')->insert([
            [
                'walas_id' => $walasIds[0],
                'kepala_sekolah' => $kepsekIds[0],
                'walas' => $walasIds[0],
                'ketuakelas' => $siswaIds[0],
                'waketuakelas' => $siswaIds[1],
                'bendahara' => $siswaIds[2],
                'sekretaris' => $siswaIds[3],
                'seksi_kebersihan' => $siswaIds[4],
                'seksi_perlengkapan' => $siswaIds[5],
                'seksi_keamanan' => $siswaIds[6],
                'seksi_kerohanian' => $siswaIds[7],
                'kurikulum_id' => $kurikulumIds[0],
                'tanggal' => '2025-02-05',
                'ttdkurikulum_url' => 'https://example.com/organisasi-kurikulum.jpg',
                'ttdwalas_url' => 'https://example.com/organisasi-walas.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    private function seedAdministrationData(array $rombelIds, array $siswaIds, array $kakomIds, array $kurikulumIds, array $kepsekIds, array $walasIds, array $guruIds, array $mapelIds): void
    {

        $presensiIds = [];
        foreach ([['kelas' => 'X SIJA 1', 'tanggal' => '2025-02-03'], ['kelas' => 'X RPL 1', 'tanggal' => '2025-02-04']] as $entry) {
            $presensiIds[] = DB::table('presensis')->insertGetId([
                'walas_id' => $walasIds[0],
                'kelas' => $entry['kelas'],
                'tanggal' => $entry['tanggal'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($presensiIds as $index => $presensiId) {
            $statusList = ['hadir', 'izin', 'sakit', 'alfa'];
            foreach (array_slice($siswaIds, $index * 3, 3) as $siswaId) {
                DB::table('detail_presensis')->insert([
                    'presensis_id' => $presensiId,
                    'siswas_id' => $siswaId,
                    'status' => $statusList[$index % count($statusList)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        DB::table('catatan_kasus_siswas')->insert([
            ['walas_id' => $walasIds[0], 'siswas_id' => $siswaIds[0], 'kasus' => 'Terlambat masuk sekolah', 'tindak_lanjut' => 'Dipanggil dan diberikan nasihat', 'keterangan' => 'Diberikan pembinaan agar lebih disiplin', 'created_at' => now(), 'updated_at' => now()],
            ['walas_id' => $walasIds[1], 'siswas_id' => $siswaIds[5], 'kasus' => 'Absen tanpa keterangan', 'tindak_lanjut' => 'Koordinasi dengan orang tua', 'keterangan' => 'Orang tua menjelaskan karena sakit', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('home_visits')->insert([
            ['walas_id' => $walasIds[0], 'tanggal' => '2025-02-06', 'nama_peserta_didik' => 'Andi Pratama', 'tindak_lanjut' => 'Monitoring ke rumah', 'kasus' => 'Keterlambatan tugas', 'solusi' => 'Memberikan jadwal belajar terstruktur', 'bukti_url' => 'https://example.com/bukti-homevisit.jpg', 'dokumentasi_url' => 'https://example.com/dokumentasi-homevisit.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['walas_id' => $walasIds[1], 'tanggal' => '2025-02-07', 'nama_peserta_didik' => 'Gita Savitri', 'tindak_lanjut' => 'Pendampingan akademik', 'kasus' => 'Nilai menurun', 'solusi' => 'Program remedial bersama guru', 'bukti_url' => 'https://example.com/bukti-homevisit-2.jpg', 'dokumentasi_url' => 'https://example.com/dokumentasi-homevisit-2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('buku_tamu_orangtuas')->insert([
            ['walas_id' => $walasIds[0], 'tanggal' => '2025-02-08', 'nama_peserta_didik' => 'Bunga Citra', 'nama_orang_tua' => 'Siti Aisyah', 'tindak_lanjut' => 'Diskusi terkait prestasi', 'kasus' => 'Kehadiran meningkat', 'solusi' => 'Dapatkan motivasi tambahan', 'dokumentasi_url' => 'https://example.com/buku-tamu.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['walas_id' => $walasIds[1], 'tanggal' => '2025-02-09', 'nama_peserta_didik' => 'Joko Widodo', 'nama_orang_tua' => 'Rudi Purwanto', 'tindak_lanjut' => 'Home visit', 'kasus' => 'Kesulitan konsentrasi', 'solusi' => 'Pembinaan dan pengawasan', 'dokumentasi_url' => 'https://example.com/buku-tamu-2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('agenda_kegiatan_walas')->insert([
            ['walas_id' => $walasIds[0], 'hari' => 'Senin', 'tanggal' => '2025-02-03', 'nama_kegiatan' => 'Rapat koordinasi kelas', 'hasil' => 'Menyepakati pembagian piket', 'waktu' => '07:30:00', 'keterangan' => 'Selesai tepat waktu', 'tanggalttd' => '2025-02-03', 'ttdwalas_url' => 'https://example.com/agenda-1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['walas_id' => $walasIds[1], 'hari' => 'Jumat', 'tanggal' => '2025-02-07', 'nama_kegiatan' => 'Monitoring siswa', 'hasil' => 'Meninjau perkembangan belajar', 'waktu' => '09:00:00', 'keterangan' => 'Berjalan lancar', 'tanggalttd' => '2025-02-07', 'ttdwalas_url' => 'https://example.com/agenda-2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $rencanaKegiatan = [
            ['walas_id' => $walasIds[0], 'minggu_ke' => '1', 'kegiatan_bukti' => 'Mengisi data peserta - Ada data peserta', 'keterangan' => 'true', 'kurikulum_id' => $kurikulumIds[0], 'tanggalttd' => '2025-02-03', 'ttdkurikulum_url' => 'https://example.com/rencana-kurikulum.jpg', 'ttdwalas_url' => 'https://example.com/rencana-walas.jpg'],
            ['walas_id' => $walasIds[1], 'minggu_ke' => '2', 'kegiatan_bukti' => 'Home Visit - Rekaman kegiatan', 'keterangan' => 'true', 'kurikulum_id' => $kurikulumIds[1], 'tanggalttd' => '2025-02-10', 'ttdkurikulum_url' => 'https://example.com/rencana-kurikulum-2.jpg', 'ttdwalas_url' => 'https://example.com/rencana-walas-2.jpg'],
        ];

        foreach ($rencanaKegiatan as $item) {
            DB::table('rencana_kegiatan_walas')->insert([...$item, 'created_at' => now(), 'updated_at' => now()]);
            DB::table('rencana_kegiatan_walas_genaps')->insert([...$item, 'created_at' => now(), 'updated_at' => now()]);
        }

        DB::table('rekapitulasi_jumlah_siswas')->insert([
            ['walas_id' => $walasIds[0], 'bulan' => 'Januari', 'jumlah_awal_siswa' => 32, 'jumlah_akhir_siswa' => 31, 'keterangan' => 'Satu siswa pindah sekolah', 'kurikulum_id' => $kurikulumIds[0], 'tanggal' => '2025-01-31', 'ttdkurikulum_url' => 'https://example.com/rekap-kurikulum.jpg', 'ttdwalas_url' => 'https://example.com/rekap-walas.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['walas_id' => $walasIds[1], 'bulan' => 'Februari', 'jumlah_awal_siswa' => 30, 'jumlah_akhir_siswa' => 30, 'keterangan' => 'Stabil', 'kurikulum_id' => $kurikulumIds[1], 'tanggal' => '2025-02-28', 'ttdkurikulum_url' => 'https://example.com/rekap-kurikulum-2.jpg', 'ttdwalas_url' => 'https://example.com/rekap-walas-2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $biodataList = DB::table('biodata_siswas')->pluck('nis', 'siswas_id')->all();
        foreach ($siswaIds as $index => $siswaId) {
            DB::table('daftar_peserta_didiks')->insert([
                'walas_id' => $walasIds[$index % count($walasIds)],
                'nis' => $biodataList[$siswaId] ?? sprintf('2025%04d', $index + 1),
                'nisn' => sprintf('000%08d', $index + 10000001),
                'nama_siswa' => $siswaId,
                'keterangan' => 'Aktif',
                'kurikulum_id' => $kurikulumIds[$index % count($kurikulumIds)],
                'tanggal' => '2025-02-10',
                'jenis_kelamin' => DB::table('siswas')->where('id', $siswaId)->value('jenis_kelamin'),
                'ttdkurikulum_url' => 'https://example.com/daftar-peserta-kurikulum.jpg',
                'ttdwalas_url' => 'https://example.com/daftar-peserta-walas.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('berita_acara_kelulusans')->insert([
            ['walas_id' => $walasIds[0], 'waktu_tanggal' => '2025-05-10 09:00:00', 'tempat' => 'Ruang Aula', 'jumlah_peserta_rapat' => '25', 'rombels_id' => $rombelIds[0], 'laki_laki_lulus' => '12', 'perempuan_lulus' => '13', 'laki_laki_tidaklulus' => '1', 'perempuan_tidaklulus' => '0', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('berita_acara_kenaikans')->insert([
            ['walas_id' => $walasIds[0], 'waktu_tanggal' => '2025-06-20 10:00:00', 'hari' => 'Jumat', 'jam' => '10:00', 'tempat' => 'Ruang Kelas', 'jumlah_peserta_rapat' => '30', 'rombels_id' => $rombelIds[0], 'kelas_baru' => 'XI', 'laki_laki_naik' => '12', 'perempuan_naik' => '11', 'laki_laki_tinggal' => '1', 'perempuan_tinggal' => '0', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('berita_acara_serah_terimas')->insert([
            ['walas_id' => $walasIds[0], 'image_url' => 'https://example.com/serah-terima.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('alumnis')->insert([
            ['siswa_id' => $siswaIds[0], 'nama' => 'Andi Pratama', 'no_wa' => '08500000001', 'rombels_id' => $rombelIds[0], 'created_at' => now(), 'updated_at' => now()],
            ['siswa_id' => $siswaIds[5], 'nama' => 'Fahri Ramadhan', 'no_wa' => '08500000006', 'rombels_id' => $rombelIds[1], 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('daftar_serah_terima_rapors')->insert([
            ['walas_id' => $walasIds[0], 'image_url' => 'https://example.com/rapor.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['walas_id' => $walasIds[1], 'image_url' => 'https://example.com/rapor-2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('lembar_pengesahans')->insert([
            ['walas_id' => $walasIds[0], 'image_url' => 'https://example.com/pengesahan.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('persentase_sosial_ekonomis')->insert([
            ['walas_id' => $walasIds[0], 'jenis_sosial_ekonomi' => 'Penghasilan Ortu', 'jumlah' => '32', 'persentase' => '80%', 'keterangan' => 'Cukup', 'tanggal' => '2025-02-11', 'ttdwalas_url' => 'https://example.com/ttd-sosial.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['walas_id' => $walasIds[1], 'jenis_sosial_ekonomi' => 'Pekerjaan Ortu', 'jumlah' => '29', 'persentase' => '75%', 'keterangan' => 'Baik', 'tanggal' => '2025-02-12', 'ttdwalas_url' => 'https://example.com/ttd-sosial-2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('prestasi_siswas')->insert([
            ['walas_id' => $walasIds[0], 'siswas_id' => $siswaIds[1], 'rombels_id' => $rombelIds[0], 'jenis_prestasi' => 'Akademik', 'nama_prestasi' => 'Juara 1 Olimpiade Matematika', 'tanggal' => '2025-01-20', 'sertifikat_url' => 'https://example.com/sertifikat-1.jpg', 'dokumentasi_url' => 'https://example.com/prestasi-1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['walas_id' => $walasIds[1], 'siswas_id' => $siswaIds[6], 'rombels_id' => $rombelIds[1], 'jenis_prestasi' => 'Non-akademik', 'nama_prestasi' => 'Juara 1 Futsal', 'tanggal' => '2025-02-15', 'sertifikat_url' => 'https://example.com/sertifikat-2.jpg', 'dokumentasi_url' => 'https://example.com/prestasi-2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $period = AcademicYear::current();
        DB::table('keluar_rombels')->insert([
            [
                'siswa_id' => $siswaIds[4],
                'keterangan' => 'pindah_sekolah',
                'rombels_id' => $rombelIds[0],
                'academic_year' => $period['year'],
                'semester' => $period['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
