<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $this->siswaTemplate();
        $this->walasTemplate();
        $this->guruTemplate();
        $this->kakomTemplate();
        $this->kurikulumTemplate();
        $this->kepsekTemplate();
        $this->mapelTemplate();
        $this->rombelTemplate();
    }

    private function siswaTemplate(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header instruksi (baris 1-5, data mulai baris 6)
        $sheet->setCellValue('A1', 'TEMPLATE IMPORT SISWA');
        $sheet->setCellValue('A2', 'Petunjuk: Isi data mulai baris 6. Jangan ubah urutan kolom.');
        $sheet->setCellValue('A3', 'Kolom rombel harus sesuai nama_kelas di tabel rombels (contoh: X SIJA 1)');
        $sheet->setCellValue('A4', 'Password akan di-hash otomatis saat import.');

        // Header data (baris 5/6 — headingRow import = 6, jadi header di baris 5)
        $sheet->setCellValue('A5', 'nama');
        $sheet->setCellValue('B5', 'rombel');
        $sheet->setCellValue('C5', 'jenis_kelamin');
        $sheet->setCellValue('D5', 'no_wa');
        $sheet->setCellValue('E5', 'password');
        $sheet->setCellValue('F5', 'status');

        // Contoh data
        $sheet->setCellValue('A6', 'Andi Pratama');
        $sheet->setCellValue('B6', 'X SIJA 1');
        $sheet->setCellValue('C6', 'Laki-laki');
        $sheet->setCellValue('D6', '081234567890');
        $sheet->setCellValue('E6', '12345678');
        $sheet->setCellValue('F6', 'aktif');

        $this->save($spreadsheet, 'template_siswa.xlsx');
    }

    private function walasTemplate(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'TEMPLATE IMPORT WALI KELAS');
        $sheet->setCellValue('A2', 'Petunjuk: Isi data mulai baris 5. Jangan ubah urutan kolom.');

        $sheet->setCellValue('A4', 'nama');
        $sheet->setCellValue('B4', 'jenis_kelamin');
        $sheet->setCellValue('C4', 'no_wa');
        $sheet->setCellValue('D4', 'password');
        $sheet->setCellValue('E4', 'nip');

        $sheet->setCellValue('A5', 'Budi Santoso, S.Pd.');
        $sheet->setCellValue('B5', 'Laki-laki');
        $sheet->setCellValue('C5', '081111111111');
        $sheet->setCellValue('D5', '12345678');
        $sheet->setCellValue('E5', '198501012010011001');

        $this->save($spreadsheet, 'template_walas.xlsx');
    }

    private function guruTemplate(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'TEMPLATE IMPORT GURU');
        $sheet->setCellValue('A2', 'Petunjuk: Isi data mulai baris 2. Jangan ubah urutan kolom.');

        $sheet->setCellValue('A1', 'nama_lengkap_guru');
        $sheet->setCellValue('A2', 'Agus Prayitno, S.Pd.');

        $this->save($spreadsheet, 'template_guru.xlsx');
    }

    private function kakomTemplate(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'nama');
        $sheet->setCellValue('B1', 'no_wa');
        $sheet->setCellValue('C1', 'password');
        $sheet->setCellValue('D1', 'kompetensi');

        $sheet->setCellValue('A2', 'Drs. Rahmat Hidayat');
        $sheet->setCellValue('B2', '082222222221');
        $sheet->setCellValue('C2', '12345678');
        $sheet->setCellValue('D2', 'SIJA');

        $this->save($spreadsheet, 'template_kakom.xlsx');
    }

    private function kurikulumTemplate(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'nama');
        $sheet->setCellValue('B1', 'no_wa');
        $sheet->setCellValue('C1', 'password');
        $sheet->setCellValue('D1', 'nip');

        $sheet->setCellValue('A2', 'Sri Wahyuni, M.Pd.');
        $sheet->setCellValue('B2', '084444444444');
        $sheet->setCellValue('C2', '12345678');
        $sheet->setCellValue('D2', '197803032005012003');

        $this->save($spreadsheet, 'template_kurikulum.xlsx');
    }

    private function kepsekTemplate(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'nama');
        $sheet->setCellValue('B1', 'no_wa');
        $sheet->setCellValue('C1', 'password');

        $sheet->setCellValue('A2', 'Drs. H. Ahmad Fauzi, M.Pd.');
        $sheet->setCellValue('B2', '083333333333');
        $sheet->setCellValue('C2', '12345678');

        $this->save($spreadsheet, 'template_kepsek.xlsx');
    }

    private function mapelTemplate(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'nama_mapel');
        $sheet->setCellValue('A2', 'Pemrograman Web');

        $this->save($spreadsheet, 'template_mapel.xlsx');
    }

    private function rombelTemplate(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'tingkat');
        $sheet->setCellValue('B1', 'kompetensi');
        $sheet->setCellValue('C1', 'nama_kelas');
        $sheet->setCellValue('D1', 'walas_id');

        $sheet->setCellValue('A2', 'X');
        $sheet->setCellValue('B2', 'SIJA');
        $sheet->setCellValue('C2', 'X SIJA 1');
        $sheet->setCellValue('D2', '1');

        $this->save($spreadsheet, 'template_rombel.xlsx');
    }

    private function save(Spreadsheet $spreadsheet, string $filename): void
    {
        $writer = new Xlsx($spreadsheet);
        $path = storage_path('app/public/' . $filename);
        $writer->save($path);
    }
}
