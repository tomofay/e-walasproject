<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginGtkController;
use App\Http\Controllers\LoginKaprogController;
use App\Http\Controllers\LoginKepsekController;
use App\Http\Controllers\LoginKurikulumController;
use App\Http\Controllers\LoginSiswaController;
use App\Http\Controllers\PageAdminController;
use App\Http\Controllers\WargaSekolahController;
use App\Http\Controllers\SiswaDataPageAdminController;
use App\Http\Controllers\ShowDetailRombelController;
use App\Http\Controllers\WaliKelasPageController;
use App\Http\Controllers\KakomDataController;
use App\Http\Controllers\KurikulumPageController;
use App\Http\Controllers\KepsekPageController;
use App\Http\Controllers\GuruPageController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\RombelPageController;
use App\Http\Controllers\MapelPageController;
use App\Http\Controllers\DataSiswaWalasController;
use App\Http\Controllers\HomePageWalasController;
use App\Http\Controllers\AdministrasiWalasController;
use App\Http\Controllers\IdentitasKelasController;
use App\Http\Controllers\BeritaAcaraKenaikanController;
use App\Http\Controllers\BeritaAcaraKelulusanController;
use App\Http\Controllers\BeritaAcaraSerahTerimaController;
use App\Http\Controllers\LembarPengesahanController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\JadwalKbmController;
use App\Http\Controllers\PendapatanOrtuController;
use App\Http\Controllers\GrafikJarakTempuhController;
use App\Http\Controllers\RencanaKegiatanWalasController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DetailPresensiController;
use App\Http\Controllers\JadwalPiketController;
use App\Http\Controllers\DenahKerjaKelompokSiswaController;
use App\Http\Controllers\DaftarPenyerahanRapotController;
use App\Http\Controllers\HomeVisitController;
use App\Http\Controllers\BukuTamuOrtuController;
use App\Http\Controllers\AgendaKegiatanWalasController;
use App\Http\Controllers\CatatanKasusSiswaController;
use App\Http\Controllers\DaftarPesertaDidikController;
use App\Http\Controllers\RekapitulasiJumlahSiswaController;
use App\Http\Controllers\PersentasePekerjaanOrtuController;
use App\Http\Controllers\PrestasiSiswaController;
use App\Http\Controllers\PrestasiSiswaInputController;
use App\Http\Controllers\KeluarRombelController;
use App\Http\Controllers\KeluarRombelViewController;
use App\Http\Controllers\KeluarRombelViewKepsek;
use App\Http\Controllers\KeluarRombelViewKurikulumController;
use App\Http\Controllers\KeluarRombelViewKakomController;
use App\Http\Controllers\AlumniDataController;
use App\Http\Controllers\ProfileAdminController;
use App\Http\Controllers\ProfilePageWalasController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\ProfilePageKurikulumController;
use App\Http\Controllers\ProfileKakomController;
use App\Http\Controllers\ProfileKepsekPageController;
use App\Http\Controllers\SiswaPageController;
use App\Http\Controllers\DataDiriPageController;
use App\Http\Controllers\InputDataDiriSiswaController;
use App\Http\Controllers\DataDiriDataController;
use App\Http\Controllers\CatatanKasusController;
use App\Http\Controllers\KepsekIndexController;
use App\Http\Controllers\KepsekTAController;
use App\Http\Controllers\KepsekWalasController;
use App\Http\Controllers\KepsekRombelController;
use App\Http\Controllers\KaprogPageController;
use App\Http\Controllers\KakomTAController;
use App\Http\Controllers\KakomWalasController;
use App\Http\Controllers\KakomRombelController;
use App\Http\Controllers\KurikulumIndexController;
use App\Http\Controllers\TaDataController;
use App\Http\Controllers\RombelDataController;
use App\Http\Controllers\KurikulumWalasController;
use App\Http\Controllers\AdmWalasViewController;
use App\Http\Controllers\ViewAdmWalasKaprogController;
use App\Http\Controllers\AdmWalasViewKepsekController;
use App\Http\Controllers\ViewAdmWalasKepsekController;
use App\Http\Controllers\AdmWalasKurikulumViewController;
use App\Http\Controllers\ViewAdmWalasKurikulumController;
use App\Http\Controllers\KinerjaGuruController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (public, throttled)
|--------------------------------------------------------------------------
*/

Route::get('/loginadmin', [LoginController::class, 'index'])->name('loginadmin.index');
Route::post('/loginadmin', [LoginController::class, 'store'])->middleware('throttle:login')->name('loginadmin.store');

Route::get('/logingtk', [LoginGtkController::class, 'index'])->name('logingtk.index');
Route::post('/logingtk', [LoginGtkController::class, 'store'])->middleware('throttle:login')->name('logingtk.store');

Route::get('/loginkaprog', [LoginKaprogController::class, 'index'])->name('loginkaprog.index');
Route::post('/loginkaprog', [LoginKaprogController::class, 'store'])->middleware('throttle:login')->name('loginkaprog.store');

Route::get('/loginkepsek', [LoginKepsekController::class, 'index'])->name('loginkepsek.index');
Route::post('/loginkepsek', [LoginKepsekController::class, 'store'])->middleware('throttle:login')->name('loginkepsek.store');

Route::get('/loginkurikulum', [LoginKurikulumController::class, 'index'])->name('loginkurikulum.index');
Route::post('/loginkurikulum', [LoginKurikulumController::class, 'store'])->middleware('throttle:login')->name('loginkurikulum.store');

Route::get('/loginsiswa', [LoginSiswaController::class, 'index'])->name('loginsiswa.index');
Route::post('/loginsiswa', [LoginSiswaController::class, 'store'])->middleware('throttle:login')->name('loginsiswa.store');

/*
|--------------------------------------------------------------------------
| Logout Routes (POST)
|--------------------------------------------------------------------------
*/

Route::post('/homepageadmin/logout', function () {
    Auth::guard('admins')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutadmin');

Route::post('/homepagegtk/logout', function () {
    Auth::guard('walas')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutwalas');

Route::post('/homepagekaprog/logout', function () {
    Auth::guard('kakoms')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutkakom');

Route::post('/homepagekepsek/logout', function () {
    Auth::guard('kepseks')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutkepsek');

Route::post('/homepagekurikulum/logout', function () {
    Auth::guard('kurikulums')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutkurikulum');

Route::post('/homepagesiswa/logout', function () {
    Auth::guard('siswas')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutsiswa');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {
    Route::resource('adminpage', PageAdminController::class)->name('index', 'homepageadmin.index');
    Route::resource('wargasekolah', WargaSekolahController::class);
    Route::resource('detailkelas', SiswaDataPageAdminController::class);
    Route::post('/siswa/tambah-ke-rombel', [SiswaDataPageAdminController::class, 'tambahKeRombel'])
        ->name('siswa.tambah.ke.rombel');
    Route::get('/rombeldetail/{rombel_id}', [ShowDetailRombelController::class, 'showDetail'])->name('detail.kelas');

    // CRUD WALAS
    Route::resource('walas', WaliKelasPageController::class)->except(['edit', 'update', 'destroy']);
    Route::delete('/hapuswalas/{id}', [WaliKelasPageController::class, 'hapuswalas'])->name('walas.destroy');
    Route::get('/walas/{id}/edit', [WaliKelasPageController::class, 'edit'])->name('walas.edit');
    Route::put('/walas/{id}', [WaliKelasPageController::class, 'update'])->name('walas.update');
    Route::get('/walas_search', [WaliKelasPageController::class, 'walas_search']);

    // CRUD KAKOM
    Route::resource('kakom', KakomDataController::class)->except(['edit', 'update', 'destroy']);
    Route::delete('/hapuskakom/{id}', [KakomDataController::class, 'hapuskakom'])->name('kakom.destroy');
    Route::get('/kakom/{id}/edit', [KakomDataController::class, 'edit'])->name('kakom.edit');
    Route::put('/kakom/{id}', [KakomDataController::class, 'update'])->name('kakom.update');
    Route::get('/kakom_search', [KakomDataController::class, 'kakom_search']);

    // CRUD KURIKULUM
    Route::resource('kurikulum', KurikulumPageController::class)->except(['edit', 'update', 'destroy']);
    Route::delete('/hapuskurikulum/{id}', [KurikulumPageController::class, 'hapuskurikulum'])->name('kurikulum.destroy');
    Route::get('/kurikulum/{id}/edit', [KurikulumPageController::class, 'edit'])->name('kurikulum.edit');
    Route::put('/kurikulum/{id}', [KurikulumPageController::class, 'update'])->name('kurikulum.update');
    Route::get('/kurikulum_search', [KurikulumPageController::class, 'kurikulum_search']);

    // CRUD KEPSEK
    Route::resource('kepalasekolah', KepsekPageController::class)->except(['edit', 'update', 'destroy']);
    Route::delete('/hapuskepsek/{id}', [KepsekPageController::class, 'hapuskepsek'])->name('kepsek.destroy');
    Route::get('/kepsek/{id}/edit', [KepsekPageController::class, 'edit'])->name('kepsek.edit');
    Route::put('/kepsek/{id}', [KepsekPageController::class, 'update'])->name('kepsek.update');
    Route::post('/kepsek/rombel/store', [KepsekPageController::class, 'store'])->name('kepsek.store');
    Route::get('/kepsek_search', [KepsekPageController::class, 'kepsek_search']);

    // CRUD GURU
    Route::resource('guru', GuruPageController::class)->except(['edit', 'update', 'destroy']);
    Route::delete('/hapusguru/{id}', [GuruPageController::class, 'hapusguru'])->name('guru.destroy');
    Route::get('/guru/{id}/edit', [GuruPageController::class, 'edit'])->name('guru.edit');
    Route::put('/guru/{id}', [GuruPageController::class, 'update'])->name('guru.update');
    Route::get('/guru_search', [GuruPageController::class, 'guru_search']);
    Route::get('/guru-export', [GuruPageController::class, 'export']);

    Route::resource('tahunajaran', TahunAjaranController::class);

    // Import & template (admin)
    Route::post('/siswa-import-admin', [ShowDetailRombelController::class, 'importsiswaadmin']);
    Route::get('/siswa-download-template-admin', [ShowDetailRombelController::class, 'downloadTemplateAdmin'])->name('siswa.download-template-admin');
    Route::post('/walas-import', [WaliKelasPageController::class, 'import']);
    Route::get('/walas-download-template', [WaliKelasPageController::class, 'downloadTemplate'])->name('walas.download-template');
    Route::post('/guru-import', [GuruPageController::class, 'import']);
    Route::get('/guru-download-template', [GuruPageController::class, 'downloadTemplate'])->name('guru.download-template');
    Route::post('/kakom-import', [KakomDataController::class, 'import']);
    Route::get('/kakom-download-template', [KakomDataController::class, 'downloadTemplate'])->name('kakom.download-template');
    Route::post('/kurikulum-import', [KurikulumPageController::class, 'import']);
    Route::get('/kurikulum-download-template', [KurikulumPageController::class, 'downloadTemplate'])->name('kurikulum.download-template');
    Route::post('/kepsek-import', [KepsekPageController::class, 'import']);
    Route::get('/kepsek-download-template', [KepsekPageController::class, 'downloadTemplate'])->name('kepsek.download-template');
    Route::post('/mapel-import', [MapelPageController::class, 'import']);
    Route::get('/mapel-download-template', [MapelPageController::class, 'downloadTemplate'])->name('mapel.download-template');
    Route::post('/rombel-import', [RombelPageController::class, 'import']);
    Route::get('/rombel-download-template', [RombelPageController::class, 'downloadTemplate'])->name('rombel.download-template');
    Route::get('/mapel-export', [MapelPageController::class, 'export']);

    // CRUD ROMBEL
    Route::resource('rombel', RombelPageController::class)->except(['edit', 'update', 'store', 'destroy']);
    Route::post('/rombel/store', [RombelPageController::class, 'store'])->name('rombels.store');
    Route::put('/rombels/{id}', [RombelPageController::class, 'update'])->name('rombels.update');
    Route::get('/rombels/{id}/edit', [RombelPageController::class, 'edit'])->name('rombels.edit');
    Route::delete('/hapusrombel/{id}', [RombelPageController::class, 'hapusrombel'])->name('rombel.destroy');
    Route::get('/rombel_search', [RombelPageController::class, 'rombel_search']);

    // CRUD MAPEL
    Route::resource('datamapel', MapelPageController::class)->except(['edit', 'update', 'store', 'destroy']);
    Route::delete('/hapusmapel/{id}', [MapelPageController::class, 'hapusmapel'])->name('mapel.destroy');
    Route::get('/mapel/{id}/edit', [MapelPageController::class, 'edit'])->name('mapel.edit');
    Route::put('/mapel/{id}', [MapelPageController::class, 'update'])->name('mapel.update');
    Route::post('/mapel/tambah/store', [MapelPageController::class, 'store'])->name('mapel.store');
    Route::get('/mapel_search', [MapelPageController::class, 'mapel_search']);

    Route::resource('profileadmin', ProfileAdminController::class)->except(['edit', 'update']);
    Route::get('/profileadmin/{id}/edit', [ProfileAdminController::class, 'edit'])->name('profileadmin.edit');
    Route::put('/profileadmin/{id}', [ProfileAdminController::class, 'update'])->name('profileadmin.update');

    // Alumni & keluar rombel (admin view)
    Route::get('/alumni', [AlumniDataController::class, 'pengaturanalumni'])->name('alumni.index');
    Route::resource('keluarrombeldata', KeluarRombelViewController::class);
    Route::get('/keluarrombeldetail/{rombels_id}', [KeluarRombelViewController::class, 'showSiswaKeluarRombel'])
        ->name('detail.keluarormbel');
    Route::post('/siswadata/simpan-keterangan/{id}', [KeluarRombelController::class, 'store'])->name('siswadata.simpanKeterangan');
});

/*
|--------------------------------------------------------------------------
| Walas Routes
|--------------------------------------------------------------------------
*/

Route::middleware('walas')->group(function () {
    Route::get('/walaspage', [HomePageWalasController::class, 'index'])->name('homepagegtk.index');

    Route::resource('siswadata', DataSiswaWalasController::class)->except(['edit', 'update', 'store']);
    Route::get('/siswa/biodata/{id}', [DataSiswaWalasController::class, 'biodata'])->name('homepagegtk.biodatasiswa');
    Route::get('/siswabiodata/{id}/edit', [DataSiswaWalasController::class, 'editbiodata'])->name('homepagegtk.editbiodata');
    Route::put('/siswabiodata/{id}', [DataSiswaWalasController::class, 'updatebiodata'])->name('homepagegtk.updatebiodata');
    Route::post('/siswa-import', [DataSiswaWalasController::class, 'import']);
    Route::get('/siswa-download-template', [DataSiswaWalasController::class, 'downloadTemplate'])->name('siswa.download-template');
    Route::get('/siswadata_search', [DataSiswaWalasController::class, 'siswadata_search']);
    Route::post('/siswadata/tambah/store', [DataSiswaWalasController::class, 'store'])->name('siswa.store');
    Route::delete('/hapussiswa/{id}', [DataSiswaWalasController::class, 'hapussiswa'])->name('siswa.destroy');
    Route::get('/siswa/{id}/edit', [DataSiswaWalasController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [DataSiswaWalasController::class, 'update'])->name('siswa.update');
    Route::post('/keluar-rombel/save', [DataSiswaWalasController::class, 'saveKeterangan'])->name('keluar-rombel.save');

    Route::resource('adminwalas', AdministrasiWalasController::class);

    Route::resource('identitaskelas', IdentitasKelasController::class)->except(['edit']);
    Route::get('/identitaskelas/{id}/edit', [IdentitasKelasController::class, 'edit'])->name('identitaskelas.edit');
    Route::resource('beritaacarakenaikan', BeritaAcaraKenaikanController::class);
    Route::resource('beritaacarakelulusan', BeritaAcaraKelulusanController::class);
    Route::resource('beritaacaraserahterima', BeritaAcaraSerahTerimaController::class);
    Route::get('/beritaacaraserahterima-download-template', [BeritaAcaraSerahTerimaController::class, 'downloadTemplate'])->name('beritaacaraserahterima.download-template');
    Route::resource('lembarpengesahan', LembarPengesahanController::class);
    Route::get('/lembarpengesahan-download-template', [LembarPengesahanController::class, 'downloadTemplate'])->name('lembarpengesahan.download-template');
    Route::resource('strukturorganisasi', StrukturOrganisasiController::class);
    Route::resource('jadwalkbm', JadwalKbmController::class);
    Route::resource('pendapatanortu', PendapatanOrtuController::class);
    Route::post('/pendapatanortu/generatepdf', [PendapatanOrtuController::class, 'generatePDF'])->name('pendapatanortu.generatepdf');
    Route::resource('grafikjaraktempuh', GrafikJarakTempuhController::class);
    Route::post('/grafikjaraktempuh/generatepdf', [GrafikJarakTempuhController::class, 'generatePDF'])->name('grafikjaraktempuh.generatepdf');

    Route::resource('rencana_kegiatan_walas', RencanaKegiatanWalasController::class)->except(['index', 'create', 'store', 'edit', 'update']);
    Route::get('/rencana_kegiatan/{semester}', [RencanaKegiatanWalasController::class, 'index'])->name('rencana_kegiatan_walas.index');
    Route::get('/rencana_kegiatan/{semester}/create', [RencanaKegiatanWalasController::class, 'create'])->name('rencana_kegiatan_walas.create');
    Route::post('/rencana_kegiatan/{semester}', [RencanaKegiatanWalasController::class, 'store'])->name('rencana_kegiatan_walas.store');
    Route::put('/rencana_kegiatan_walas/{semester}/update/{id}', [RencanaKegiatanWalasController::class, 'update'])->name('rencana_kegiatan_walas.update');
    Route::get('/rencana_kegiatan_walas/{semester}/edit/{id}', [RencanaKegiatanWalasController::class, 'edit'])->name('rencana_kegiatan_walas.edit');

    Route::resource('presensi', PresensiController::class);
    Route::get('/presensi/export-pdf', [PresensiController::class, 'exportPdf'])->name('presensi.exportPdf');

    Route::prefix('{presensi}/detail')->group(function () {
        Route::get('/', [DetailPresensiController::class, 'index'])->name('detailpresensi.index');
        Route::get('/create', [DetailPresensiController::class, 'create'])->name('detailpresensi.create');
        Route::post('/', [DetailPresensiController::class, 'store'])->name('detailpresensi.store');
        Route::get('/{detail}/edit', [DetailPresensiController::class, 'edit'])->name('detailpresensi.edit');
        Route::put('/{detail}', [DetailPresensiController::class, 'update'])->name('detailpresensi.update');
        Route::delete('/{detail}', [DetailPresensiController::class, 'destroy'])->name('detailpresensi.destroy');
    });

    // Denah kerja kelompok
    Route::resource('denahkerjakelompok', DenahKerjaKelompokSiswaController::class)->except(['create', 'store', 'update']);
    Route::get('/createkelompok', [DenahKerjaKelompokSiswaController::class, 'create'])->name('denahkerjakelompok.create');
    Route::post('/kelompok/{id}/add-siswa', [DenahKerjaKelompokSiswaController::class, 'addSiswa'])->name('kelompok.addSiswa');
    Route::post('/createkelompok/store', [DenahKerjaKelompokSiswaController::class, 'store'])->name('kelompoksiswa.store');
    Route::post('/kelompok/simpan', [DenahKerjaKelompokSiswaController::class, 'simpan'])->name('kelompoksiswa.simpan');
    Route::delete('/hapussiswadata/{id}', [DenahKerjaKelompokSiswaController::class, 'hapussiswadata'])->name('hapussiswadata');
    Route::put('/kelompoksiswa/update/{id}', [DenahKerjaKelompokSiswaController::class, 'update'])->name('kelompoksiswa.update');

    // Jadwal piket
    Route::resource('jadwalpiket', JadwalPiketController::class)
        ->except(['edit', 'show'])
        ->names([
            'index' => 'jadwalpiket.index',
            'create' => 'jadwalpiket.create',
            'store' => 'jadwalpiket.store',
            'update' => 'jadwalpiket.update',
            'destroy' => 'jadwalpiket.destroy',
        ]);
    Route::post('/jadwalpiket/{id}/siswa', [JadwalPiketController::class, 'addSiswa'])->name('jadwalpiket.addSiswa');
    Route::post('/jadwalpiket/simpan', [JadwalPiketController::class, 'simpan'])->name('jadwalpiket.simpan');
    Route::delete('/hapussiswapiket/{id}', [JadwalPiketController::class, 'hapussiswapiket'])->name('hapussiswapiket');
    Route::put('/jadwalpiket/siswa/{id}', [JadwalPiketController::class, 'update'])->name('jadwalpiket.updateSiswa');

    // Serah terima rapot
    Route::resource('serahterimarapor', DaftarPenyerahanRapotController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/serahterimarapor-download-template', [DaftarPenyerahanRapotController::class, 'downloadTemplate'])->name('serahterimarapor.download-template');
    Route::get('/penyerahanrapotcreate', [DaftarPenyerahanRapotController::class, 'create'])->name('penyerahanrapot.create');
    Route::post('/penyerahanrapot/store', [DaftarPenyerahanRapotController::class, 'store'])->name('penyerahanrapot.store');
    Route::get('/penyerahanrapot/{id}/edit', [DaftarPenyerahanRapotController::class, 'edit'])->name('penyerahanrapot.edit');
    Route::delete('/hapuspenyerahanrapot/{id}', [DaftarPenyerahanRapotController::class, 'hapuspenyerahanrapot'])->name('penyerahanrapot.destroy');
    Route::put('/penyerahanrapot/{id}', [DaftarPenyerahanRapotController::class, 'update'])->name('penyerahanrapot.update');

    // Home visit
    Route::resource('homevisit', HomeVisitController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::post('/homevisit/generatepdf', [HomeVisitController::class, 'generatePDF'])->name('homevisit.generatepdf');
    Route::get('/homevisitcreate', [HomeVisitController::class, 'create'])->name('homevisit.create');
    Route::post('/homevisit/store', [HomeVisitController::class, 'store'])->name('homevisit.store');
    Route::get('/homevisit/{id}/edit', [HomeVisitController::class, 'edit'])->name('homevisit.edit');
    Route::delete('/hapushomevisit/{id}', [HomeVisitController::class, 'hapushomevisit'])->name('homevisit.destroy');
    Route::put('/homevisit/{id}', [HomeVisitController::class, 'update'])->name('homevisit.update');

    // Buku tamu ortu
    Route::resource('bukutamuortu', BukuTamuOrtuController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::post('/bukutamuortu/generatepdf', [BukuTamuOrtuController::class, 'generatePDF'])->name('bukutamuortu.generatepdf');
    Route::get('/bukutamuortucreate', [BukuTamuOrtuController::class, 'create'])->name('bukutamuortu.create');
    Route::post('/bukutamuortu/store', [BukuTamuOrtuController::class, 'store'])->name('bukutamuortu.store');
    Route::get('/bukutamuortu/{id}/edit', [BukuTamuOrtuController::class, 'edit'])->name('bukutamuortu.edit');
    Route::delete('/hapusbukutamuortu/{id}', [BukuTamuOrtuController::class, 'hapusbukutamuortu'])->name('bukutamuortu.destroy');
    Route::put('/bukutamuortu/{id}', [BukuTamuOrtuController::class, 'update'])->name('bukutamuortu.update');

    // Agenda walas
    Route::resource('agendawalas', AgendaKegiatanWalasController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/agendawalascreate', [AgendaKegiatanWalasController::class, 'create'])->name('agendawalas.create');
    Route::post('/agendawalas/store', [AgendaKegiatanWalasController::class, 'store'])->name('agendawalas.store');
    Route::get('/agendawalas/{id}/edit', [AgendaKegiatanWalasController::class, 'edit'])->name('agendawalas.edit');
    Route::delete('/hapusagendawalas/{id}', [AgendaKegiatanWalasController::class, 'hapusagendawalas'])->name('agendawalas.destroy');
    Route::put('/agendawalas/{id}', [AgendaKegiatanWalasController::class, 'update'])->name('agendawalas.update');

    // Catatan kasus
    Route::resource('catatankasus', CatatanKasusSiswaController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/catatankasuscreate', [CatatanKasusSiswaController::class, 'create'])->name('catatankasus.create');
    Route::post('/catatankasus/store', [CatatanKasusSiswaController::class, 'store'])->name('catatankasus.store');
    Route::get('/catatankasus/{id}/edit', [CatatanKasusSiswaController::class, 'edit'])->name('catatankasus.edit');
    Route::delete('/hapuscatatankasus/{id}', [CatatanKasusSiswaController::class, 'hapuscatatankasus'])->name('catatankasus.destroy');
    Route::put('/catatankasus/{id}', [CatatanKasusSiswaController::class, 'update'])->name('catatankasus.update');
    Route::get('/catatankasus/export/pdf', [CatatanKasusSiswaController::class, 'index'])->name('catatankasus.export');

    // Daftar peserta didik
    Route::resource('daftarpesertadidik', DaftarPesertaDidikController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/get-siswa/{id}', [DaftarPesertaDidikController::class, 'getSiswa'])->name('siswa.get');
    Route::get('/daftarpesertadidikcreate', [DaftarPesertaDidikController::class, 'create'])->name('daftarpesertadidik.create');
    Route::post('/daftarpesertadidik/store', [DaftarPesertaDidikController::class, 'store'])->name('daftarpesertadidik.store');
    Route::get('/daftarpesertadidik/{id}/edit', [DaftarPesertaDidikController::class, 'edit'])->name('daftarpesertadidik.edit');
    Route::delete('/hapusdaftarpesertadidik/{id}', [DaftarPesertaDidikController::class, 'hapusdaftarpesertadidik'])->name('daftarpesertadidik.destroy');
    Route::put('/daftarpesertadidik/{id}', [DaftarPesertaDidikController::class, 'update'])->name('daftarpesertadidik.update');

    // Rekap jumlah siswa
    Route::resource('rekapjumlahsiswa', RekapitulasiJumlahSiswaController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/rekapjumlahsiswacreate', [RekapitulasiJumlahSiswaController::class, 'create'])->name('rekapjumlahsiswa.create');
    Route::post('/rekapjumlahsiswa/store', [RekapitulasiJumlahSiswaController::class, 'store'])->name('rekapjumlahsiswa.store');
    Route::get('/rekapjumlahsiswa/{id}/edit', [RekapitulasiJumlahSiswaController::class, 'edit'])->name('rekapjumlahsiswa.edit');
    Route::delete('/hapusrekapjumlahsiswa/{id}', [RekapitulasiJumlahSiswaController::class, 'hapusrekapjumlahsiswa'])->name('rekapjumlahsiswa.destroy');
    Route::put('/rekapjumlahsiswa/{id}', [RekapitulasiJumlahSiswaController::class, 'update'])->name('rekapjumlahsiswa.update');

    // Persentase sosial ekonomi
    Route::resource('persentasesosialekonomi', PersentasePekerjaanOrtuController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/persentasesosialekonomicreate', [PersentasePekerjaanOrtuController::class, 'create'])->name('persentasesosialekonomi.create');
    Route::post('/persentasesosialekonomi/store', [PersentasePekerjaanOrtuController::class, 'store'])->name('persentasesosialekonomi.store');
    Route::get('/persentasesosialekonomi/{id}/edit', [PersentasePekerjaanOrtuController::class, 'edit'])->name('persentasesosialekonomi.edit');
    Route::delete('/hapuspersentasesosialekonomi/{id}', [PersentasePekerjaanOrtuController::class, 'hapuspersentasesosialekonomi'])->name('persentasesosialekonomi.destroy');
    Route::put('/persentasesosialekonomi/{id}', [PersentasePekerjaanOrtuController::class, 'update'])->name('persentasesosialekonomi.update');

    // Prestasi siswa (walas)
    Route::resource('prestasisiswa', PrestasiSiswaController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::post('/prestasisiswa/generatepdf', [PrestasiSiswaController::class, 'generatePDF'])->name('prestasisiswa.generatepdf');
    Route::get('/prestasisiswacreate', [PrestasiSiswaController::class, 'create'])->name('prestasisiswa.create');
    Route::post('/prestasisiswa/store', [PrestasiSiswaController::class, 'store'])->name('prestasisiswa.store');
    Route::get('/prestasisiswa/{id}/edit', [PrestasiSiswaController::class, 'edit'])->name('prestasisiswa.edit');
    Route::delete('/hapusprestasisiswa/{id}', [PrestasiSiswaController::class, 'hapusprestasisiswa'])->name('prestasisiswa.destroy');
    Route::put('/prestasisiswa/{id}', [PrestasiSiswaController::class, 'update'])->name('prestasisiswa.update');

    Route::resource('profilewalas', ProfilePageWalasController::class)->except(['edit', 'update']);
    Route::get('/profilewalas/{id}/edit', [ProfilePageWalasController::class, 'edit'])->name('profilewalas.edit');
    Route::put('/profilewalas/{id}', [ProfilePageWalasController::class, 'update'])->name('profilewalas.update');
});

/*
|--------------------------------------------------------------------------
| Kakom Routes
|--------------------------------------------------------------------------
*/

Route::middleware('kakom')->group(function () {
    Route::resource('homepagekaprog', KaprogPageController::class)->name('index', 'homepagekaprog.index');
    Route::resource('kakomta', KakomTAController::class);
    Route::resource('kakomwalas', KakomWalasController::class);
    Route::resource('kakomrombel', KakomRombelController::class);
    Route::resource('admwalasview', AdmWalasViewController::class);
    Route::get('/detailkelasview/{walas_id}', [KakomRombelController::class, 'showDetail'])->name('rombel.showDetail');

    Route::get('agendawalasview', [ViewAdmWalasKaprogController::class, 'agendawalas'])->name('admwalas.agendawalas');
    Route::get('identiaskelasview', [ViewAdmWalasKaprogController::class, 'identitaskelas'])->name('admwalas.identitaskelas');
    Route::get('lembarpengesahanview', [ViewAdmWalasKaprogController::class, 'lembarpengesahan'])->name('admwalas.lembarpengesahan');
    Route::get('beritaacarakenaikanview', [ViewAdmWalasKaprogController::class, 'beritaacarakenaikan'])->name('admwalas.beritaacarakenaikan');
    Route::get('beritaacarakelulusanview', [ViewAdmWalasKaprogController::class, 'beritaacarakelulusan'])->name('admwalas.beritaacarakelulusan');
    Route::get('beritaacaraserahterimaview', [ViewAdmWalasKaprogController::class, 'beritaacaraserahterima'])->name('admwalas.beritaacaraserahterima');
    Route::get('strukturorganisasikelasview', [ViewAdmWalasKaprogController::class, 'strukturorganisasikelas'])->name('admwalas.strukturorganisasikelas');
    Route::get('jadwalkbmview', [ViewAdmWalasKaprogController::class, 'jadwalkbm'])->name('admwalas.jadwalkbm');
    Route::get('presensisview', [ViewAdmWalasKaprogController::class, 'presensis'])->name('admwalas.presensis');
    Route::get('piketkelasview', [ViewAdmWalasKaprogController::class, 'piketkelas'])->name('admwalas.piketkelas');
    Route::get('serahterimaraporview', [ViewAdmWalasKaprogController::class, 'serahterimarapor'])->name('admwalas.serahterimarapor');
    Route::get('catatankasusview', [ViewAdmWalasKaprogController::class, 'catatankasus'])->name('admwalas.catatankasus');
    Route::get('daftarpesertadidikview', [ViewAdmWalasKaprogController::class, 'daftarpesertadidik'])->name('admwalas.daftarpesertadidik');
    Route::get('rekapitulasijumlahsiswaview', [ViewAdmWalasKaprogController::class, 'rekapitulasipdidik'])->name('admwalas.rekapitulasipdidik');
    Route::get('homevisitview', [ViewAdmWalasKaprogController::class, 'homevisit'])->name('admwalas.homevisit');
    Route::post('/homevisitview/generatepdf', [ViewAdmWalasKaprogController::class, 'generatePDFhomevisit'])->name('homevisit.generatepdfhomevisit');
    Route::get('bukutamuview', [ViewAdmWalasKaprogController::class, 'bukutamuortu'])->name('admwalas.bukutamuortu');
    Route::post('/bukutamuview/generatepdf', [ViewAdmWalasKaprogController::class, 'generatePDFbukutamuortu'])->name('bukutamuortu.generatepdfbukutamuortu');
    Route::get('persentasesosialekonomiview', [ViewAdmWalasKaprogController::class, 'persentasesosialekonomi'])->name('admwalas.persentasesosialekonomi');
    Route::get('rentangpendapatanortuview', [ViewAdmWalasKaprogController::class, 'rentangpendapatanortu'])->name('admwalas.rentangpendapatanortu');
    Route::post('/rentangpendapatanortuview/generatepdf', [ViewAdmWalasKaprogController::class, 'generatePDFpendapatanortu'])->name('pendapatanortu.generatepdfpendapatanortu');
    Route::get('prestasisiswaview', [ViewAdmWalasKaprogController::class, 'prestasisiswa'])->name('admwalas.prestasisiswa');
    Route::post('/prestasisiswaview/generatepdf', [ViewAdmWalasKaprogController::class, 'generatePDFprestasi'])->name('prestasisiswa.generatepdfprestasi');
    Route::get('grafikjaraktempuhview', [ViewAdmWalasKaprogController::class, 'grafikjaraktempuh'])->name('admwalas.grafikjaraktempuh');
    Route::post('/grafikjaraktempuhview/generatepdf', [ViewAdmWalasKaprogController::class, 'generatePDFgrafikjaraktempuh'])->name('grafikjaraktempuh.generatepdfgrafikjaraktempuh');

    Route::get('/alumnidatakakom', [AlumniDataController::class, 'pengaturanalumnikakom'])->name('alumnikakom.index');
    Route::resource('keluarrombeldatakakom', KeluarRombelViewKakomController::class);
    Route::get('/keluarrombeldetailkakom/{rombels_id}', [KeluarRombelViewKakomController::class, 'showSiswaKeluarRombelKakom'])
        ->name('detail.keluarormbelkakom');

    Route::resource('profilekakom', ProfileKakomController::class)->except(['edit', 'update']);
    Route::get('/profilekakom/{id}/edit', [ProfileKakomController::class, 'edit'])->name('profilekakom.edit');
    Route::put('/profilekakom/{id}', [ProfileKakomController::class, 'update'])->name('profilekakom.update');
});

/*
|--------------------------------------------------------------------------
| Kepsek Routes
|--------------------------------------------------------------------------
*/

Route::middleware('kepsek')->group(function () {
    Route::resource('kepsekpage', KepsekIndexController::class)->name('index', 'homepagekepsek.index');
    Route::resource('kepsekta', KepsekTAController::class);
    Route::resource('kepsekwalas', KepsekWalasController::class);
    Route::resource('kepsekrombel', KepsekRombelController::class);
    Route::resource('admwalasviewkepsek', AdmWalasViewKepsekController::class);
    Route::get('/detailkelasviewkepsek/{walas_id}', [KepsekRombelController::class, 'showDetailKepsek'])->name('rombel.showDetailKepsek');

    Route::get('beritaacarakenaikanviewkepsek', [ViewAdmWalasKepsekController::class, 'beritaacarakenaikankepsek'])->name('admwalas.beritaacarakenaikankepsek');
    Route::get('beritaacarakelulusanviewkepsek', [ViewAdmWalasKepsekController::class, 'beritaacarakelulusankepsek'])->name('admwalas.beritaacarakelulusankepsek');
    Route::get('beritaacaraserahterimaviewkepsek', [ViewAdmWalasKepsekController::class, 'beritaacaraserahterimakepsek'])->name('admwalas.beritaacaraserahterimakepsek');
    Route::get('agendawalasviewkepsek', [ViewAdmWalasKepsekController::class, 'agendawalaskepsek'])->name('admwalas.agendawalaskepsek');
    Route::get('identiaskelasviewkepsek', [ViewAdmWalasKepsekController::class, 'identitaskelaskepsek'])->name('admwalas.identitaskelaskepsek');
    Route::get('lembarpengesahanviewkepsek', [ViewAdmWalasKepsekController::class, 'lembarpengesahankepsek'])->name('admwalas.lembarpengesahankepsek');
    Route::get('strukturorganisasikelasviewkepsek', [ViewAdmWalasKepsekController::class, 'strukturorganisasikelaskepsek'])->name('admwalas.strukturorganisasikelaskepsek');
    Route::get('jadwalkbmviewkepsek', [ViewAdmWalasKepsekController::class, 'jadwalkbmkepsek'])->name('admwalas.jadwalkbmkepsek');
    Route::get('presensisviewkepsek', [ViewAdmWalasKepsekController::class, 'presensiskepsek'])->name('admwalas.presensiskepsek');
    Route::get('piketkelasviewkepsek', [ViewAdmWalasKepsekController::class, 'piketkelaskepsek'])->name('admwalas.piketkelaskepsek');
    Route::get('serahterimaraporviewkepsek', [ViewAdmWalasKepsekController::class, 'serahterimaraporkepsek'])->name('admwalas.serahterimaraporkepsek');
    Route::get('catatankasusviewkepsek', [ViewAdmWalasKepsekController::class, 'catatankasuskepsek'])->name('admwalas.catatankasuskepsek');
    Route::get('daftarpesertadidikviewkepsek', [ViewAdmWalasKepsekController::class, 'daftarpesertadidikkepsek'])->name('admwalas.daftarpesertadidikkepsek');
    Route::get('rekapitulasijumlahsiswaviewkepsek', [ViewAdmWalasKepsekController::class, 'rekapitulasipdidikkepsek'])->name('admwalas.rekapitulasipdidikkepsek');
    Route::get('homevisitviewkepsek', [ViewAdmWalasKepsekController::class, 'homevisitkepsek'])->name('admwalas.homevisitkepsek');
    Route::post('/homevisitviewkepsek/generatepdf', [ViewAdmWalasKepsekController::class, 'generatePDFkepsekhomevisit'])->name('homevisit.generatepdfkepsekhomevisit');
    Route::get('bukutamuviewkepsek', [ViewAdmWalasKepsekController::class, 'bukutamuortukepsek'])->name('admwalas.bukutamuortukepsek');
    Route::post('/bukutamuviewkepsek/generatepdf', [ViewAdmWalasKepsekController::class, 'generatePDFkepsekbukutamuortu'])->name('bukutamuortu.generatepdfkepsekbukutamuortu');
    Route::get('persentasesosialekonomiviewkepsek', [ViewAdmWalasKepsekController::class, 'persentasesosialekonomikepsek'])->name('admwalas.persentasesosialekonomikepsek');
    Route::get('rentangpendapatanortuviewkepsek', [ViewAdmWalasKepsekController::class, 'rentangpendapatanortukepsek'])->name('admwalas.rentangpendapatanortukepsek');
    Route::post('/rentangpendapatanortuviewkepsek/generatepdf', [ViewAdmWalasKepsekController::class, 'generatePDFkepsekpendapatanortu'])->name('pendapatanortu.generatepdfkepsekpendapatanortu');
    Route::get('prestasisiswaviewkepsek', [ViewAdmWalasKepsekController::class, 'prestasisiswakepsek'])->name('admwalas.prestasisiswakepsek');
    Route::post('/prestasisiswaviewkepsek/generatepdf', [ViewAdmWalasKepsekController::class, 'generatePDFkepsekprestasi'])->name('prestasisiswa.generatepdfkepsekprestasi');
    Route::get('grafikjaraktempuhviewkepsek', [ViewAdmWalasKepsekController::class, 'grafikjaraktempuhkepsek'])->name('admwalas.grafikjaraktempuhkepsek');
    Route::post('/grafikjaraktempuhviewkepsek/generatepdf', [ViewAdmWalasKepsekController::class, 'generatePDFkepsekgrafikjaraktempuh'])->name('grafikjaraktempuh.generatepdfkepsekgrafikjaraktempuh');

    Route::get('/alumnidatakepsek', [AlumniDataController::class, 'pengaturanalumnikepsek'])->name('alumnikepsek.index');
    Route::resource('keluarrombeldatakepsek', KeluarRombelViewKepsek::class);
    Route::get('/keluarrombeldetailkepsek/{rombels_id}', [KeluarRombelViewKepsek::class, 'showSiswaKeluarRombelkepsek'])
        ->name('detail.keluarormbelkepsek');

    Route::resource('profilekepsek', ProfileKepsekPageController::class)->except(['edit', 'update']);
    Route::get('/profilekepsek/{id}/edit', [ProfileKepsekPageController::class, 'edit'])->name('profilekepsek.edit');
    Route::put('/profilekepsek/{id}', [ProfileKepsekPageController::class, 'update'])->name('profilekepsek.update');
});

/*
|--------------------------------------------------------------------------
| Kurikulum Routes
|--------------------------------------------------------------------------
*/

Route::middleware('kurikulum')->group(function () {
    Route::resource('kurikulumpage', KurikulumIndexController::class)->name('index', 'homepagekurikulum.index');
    Route::resource('tahunajarandata', TaDataController::class);
    Route::resource('rombelpage', RombelDataController::class);
    Route::resource('kurikulumwalas', KurikulumWalasController::class);
    Route::resource('admwalasviewkurikulum', AdmWalasKurikulumViewController::class);
    Route::get('/detailkelasviewkurikulum/{walas_id}', [RombelDataController::class, 'showDetailKurikulum'])->name('rombel.showDetailKurikulum');

    Route::get('beritaacarakenaikanviewkurikulum', [ViewAdmWalasKurikulumController::class, 'beritaacarakenaikankurikulum'])->name('admwalas.beritaacarakenaikankurikulum');
    Route::get('beritaacarakelulusanviewkurikulum', [ViewAdmWalasKurikulumController::class, 'beritaacarakelulusankurikulum'])->name('admwalas.beritaacarakelulusankurikulum');
    Route::get('beritaacaraserahterimaviewkurikulum', [ViewAdmWalasKurikulumController::class, 'beritaacaraserahterimakurikulum'])->name('admwalas.beritaacaraserahterimakurikulum');
    Route::get('agendawalasviewkurikulum', [ViewAdmWalasKurikulumController::class, 'agendawalaskurikulum'])->name('admwalas.agendawalaskurikulum');
    Route::get('identiaskelasviewkurikulum', [ViewAdmWalasKurikulumController::class, 'identitaskelaskurikulum'])->name('admwalas.identitaskelaskurikulum');
    Route::get('lembarpengesahanviewkurikulum', [ViewAdmWalasKurikulumController::class, 'lembarpengesahankurikulum'])->name('admwalas.lembarpengesahankurikulum');
    Route::get('strukturorganisasikelasviewkurikulum', [ViewAdmWalasKurikulumController::class, 'strukturorganisasikelaskurikulum'])->name('admwalas.strukturorganisasikelaskurikulum');
    Route::get('jadwalkbmviewkurikulum', [ViewAdmWalasKurikulumController::class, 'jadwalkbmkurikulum'])->name('admwalas.jadwalkbmkurikulum');
    Route::get('presensisviewkurikulum', [ViewAdmWalasKurikulumController::class, 'presensiskurikulum'])->name('admwalas.presensiskurikulum');
    Route::get('piketkelasviewkurikulum', [ViewAdmWalasKurikulumController::class, 'piketkelaskurikulum'])->name('admwalas.piketkelaskurikulum');
    Route::get('serahterimaraporviewkurikulum', [ViewAdmWalasKurikulumController::class, 'serahterimaraporkurikulum'])->name('admwalas.serahterimaraporkurikulum');
    Route::get('catatankasusviewkurikulum', [ViewAdmWalasKurikulumController::class, 'catatankasuskurikulum'])->name('admwalas.catatankasuskurikulum');
    Route::get('daftarpesertadidikviewkurikulum', [ViewAdmWalasKurikulumController::class, 'daftarpesertadidikkurikulum'])->name('admwalas.daftarpesertadidikkurikulum');
    Route::get('rekapitulasijumlahsiswaviewkurikulum', [ViewAdmWalasKurikulumController::class, 'rekapitulasipdidikkurikulum'])->name('admwalas.rekapitulasipdidikkurikulum');
    Route::get('homevisitviewkurikulum', [ViewAdmWalasKurikulumController::class, 'homevisitkurikulum'])->name('admwalas.homevisitkurikulum');
    Route::post('/homevisitviewkurikulum/generatepdf', [ViewAdmWalasKurikulumController::class, 'generatePDFkurikulumhomevisit'])->name('homevisit.generatepdfkurikulumhomevisit');
    Route::get('bukutamuviewkurikulum', [ViewAdmWalasKurikulumController::class, 'bukutamuortukurikulum'])->name('admwalas.bukutamuortukurikulum');
    Route::post('/bukutamuviewkurikulum/generatepdf', [ViewAdmWalasKurikulumController::class, 'generatePDFkurikulumbukutamuortu'])->name('bukutamuortu.generatepdfkurikulumbukutamuortu');
    Route::get('persentasesosialekonomiviewkurikulum', [ViewAdmWalasKurikulumController::class, 'persentasesosialekonomikurikulum'])->name('admwalas.persentasesosialekonomikurikulum');
    Route::get('rentangpendapatanortuviewkurikulum', [ViewAdmWalasKurikulumController::class, 'rentangpendapatanortukurikulum'])->name('admwalas.rentangpendapatanortukurikulum');
    Route::post('/rentangpendapatanortuviewkurikulum/generatepdf', [ViewAdmWalasKurikulumController::class, 'generatePDFkurikulumpendapatanortu'])->name('pendapatanortu.generatepdfkurikulumpendapatanortu');
    Route::get('prestasisiswaviewkurikulum', [ViewAdmWalasKurikulumController::class, 'prestasisiswakurikulum'])->name('admwalas.prestasisiswakurikulum');
    Route::post('/prestasisiswaviewkurikulum/generatepdf', [ViewAdmWalasKurikulumController::class, 'generatePDFkurikulumprestasi'])->name('prestasisiswa.generatepdfkurikulumprestasi');
    Route::get('grafikjaraktempuhviewkurikulum', [ViewAdmWalasKurikulumController::class, 'grafikjaraktempuhkurikulum'])->name('admwalas.grafikjaraktempuhkurikulum');
    Route::post('/grafikjaraktempuhviewkurikulum/generatepdf', [ViewAdmWalasKurikulumController::class, 'generatePDFkurikulumgrafikjaraktempuh'])->name('grafikjaraktempuh.generatepdfkurikulumgrafikjaraktempuh');

    Route::get('/kinerjaguru', [KinerjaGuruController::class, 'index'])->name('kinerjaguru.index');

    Route::get('/alumnidatakurikulum', [AlumniDataController::class, 'pengaturanalumnikurikulum'])->name('alumnikurikulum.index');
    Route::resource('keluarrombeldatakurikulum', KeluarRombelViewKurikulumController::class);
    Route::get('/keluarrombeldetailkurikulum/{rombels_id}', [KeluarRombelViewKurikulumController::class, 'showSiswaKeluarRombelkurikulum'])
        ->name('detail.keluarormbelkurikulum');

    Route::resource('profilekurikulum', ProfilePageKurikulumController::class)->except(['edit', 'update']);
    Route::get('/profilekurikulum/{id}/edit', [ProfilePageKurikulumController::class, 'edit'])->name('profilekurikulum.edit');
    Route::put('/profilekurikulum/{id}', [ProfilePageKurikulumController::class, 'update'])->name('profilekurikulum.update');
});

/*
|--------------------------------------------------------------------------
| Siswa Routes
|--------------------------------------------------------------------------
*/

Route::middleware('siswa')->group(function () {
    Route::get('/siswapage', [SiswaPageController::class, 'index'])->name('homepagesiswa.index');
    Route::resource('datadiri', DataDiriPageController::class)->except(['edit']);
    Route::resource('inputdatadiri', InputDataDiriSiswaController::class)->except(['edit', 'update']);
    Route::post('/biodatasiswa/store', [InputDataDiriSiswaController::class, 'store'])->name('biodatasiswa.store');
    Route::resource('datadiripage', DataDiriDataController::class);
    Route::get('/biodatasiswa/{id}/edit', [InputDataDiriSiswaController::class, 'edit'])->name('datadiri.edit');
    Route::put('/biodatasiswaupdate/{id}', [InputDataDiriSiswaController::class, 'update'])->name('biodatasiswa.update');
    Route::resource('catatankasussiswa', CatatanKasusController::class);

    Route::resource('prestasisiswainput', PrestasiSiswaInputController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/prestasisiswainputcreate', [PrestasiSiswaInputController::class, 'create'])->name('prestasisiswainput.create');
    Route::post('/prestasisiswainput/store', [PrestasiSiswaInputController::class, 'store'])->name('prestasisiswainput.store');
    Route::get('/prestasisiswainput/{id}/edit', [PrestasiSiswaInputController::class, 'edit'])->name('prestasisiswainput.edit');
    Route::delete('/hapusprestasisiswainput/{id}', [PrestasiSiswaInputController::class, 'hapusprestasisiswainput'])->name('prestasisiswainput.destroy');
    Route::put('/prestasisiswainput/{id}', [PrestasiSiswaInputController::class, 'update'])->name('prestasisiswainput.update');

    Route::resource('profilesiswa', ProfilePageController::class)->except(['edit', 'update']);
    Route::get('/profilesiswa/{id}/edit', [ProfilePageController::class, 'edit'])->name('profilesiswa.edit');
    Route::put('/profilesiswa/{id}', [ProfilePageController::class, 'update'])->name('profilesiswa.update');
});
