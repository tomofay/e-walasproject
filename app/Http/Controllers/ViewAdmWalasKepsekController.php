<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kakom;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Kepsek;
use App\Models\Rombel;
use App\Models\Presensi;
use App\Models\HomeVisit;
use App\Models\JadwalKbm;
use App\Models\JadwalPiket;
use App\Models\BiodataSiswa;
use Illuminate\Http\Request;
use App\Models\PrestasiSiswa;
use App\Models\IdentitasKelas;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BukuTamuOrangtua;
use App\Models\LembarPengesahan;
use App\Models\CatatanKasusSiswa;
use App\Models\DetailJadwalPiket;
use App\Models\DaftarPesertaDidik;
use Illuminate\Support\Facades\DB;
use App\Models\AgendaKegiatanWalas;
use App\Models\BeritaAcaraKenaikan;
use App\Models\BeritaAcaraKelulusan;
use Illuminate\Support\Facades\Auth;
use App\Models\BeritaAcaraSerahTerima;
use App\Models\DaftarSerahTerimaRapor;
use App\Models\PersentaseSosialEkonomi;
use App\Models\RekapitulasiJumlahSiswa;
use App\Models\StrukturOrganisasiKelas;

class ViewAdmWalasKepsekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function agendawalaskepsek(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();  
    
        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));
    
        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }
    
        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array
    
        // Ambil data wali kelas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();
    
        // Ambil data walas_id yang dipilih dari query parameter
        $walasIdSelected = $request->query('walas_id', null);  // Default ke null jika tidak ada
    
        // Query untuk mendapatkan agenda kegiatan berdasarkan walas_id yang dipilih
        $agendaList = AgendaKegiatanWalas::whereIn('walas_id', $walasIds);
    
        if ($walasIdSelected) {
            $agendaList = $agendaList->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }
    
        // Ambil data agenda sesuai filter walas_id
        $agendaList = $agendaList->get();
    
        // Jika request mengandung parameter 'export' dan nilainya 'pdf', buat PDF
        if ($request->has('export') && $request->get('export') === 'pdf') {
            if ($walasIdSelected) {
                $walasSelected = Walas::find($walasIdSelected); // Ambil data wali kelas yang dipilih
            } else {
                return redirect()->route('admwalas.agendawalaskepsek')->with('error', 'Walas ID tidak ditemukan.');
            }
    
            // Generate PDF
            $pdf = Pdf::loadView('pdfkepsek.agendawalas', compact('walasSelected', 'agendaList'));
            return $pdf->stream('Agenda_Walas.pdf');
        }
    
        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.agendawalas.index", compact('walasList', 'walasIds', 'kepsek', 'agendaList', 'walasIdSelected'));
    }
    

    public function identitaskelaskepsek(Request $request)
{
    // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
    $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

    // Periksa apakah session 'kepsek_id' ada
    if (!session()->has('kepsek_id')) {
        return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
    $kepsek = Kepsek::find(session('kepsek_id'));

    // Periksa apakah data kepsek ditemukan
    if (!$kepsek) {
        return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
    }

    // Ambil semua ID walas
    $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

    // Ambil data walas berdasarkan ID yang sesuai
    $walasList = Walas::whereIn('id', $walasIds)->get();

    // Ambil data walas_id yang dipilih dari query parameter
    $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter

    // Mulai query untuk mengambil data identitas kelas
    $identiasKelasList = IdentitasKelas::whereIn('walas_id', $walasIds);

    if ($walasIdSelected) {
        // Filter berdasarkan walas_id yang dipilih
        $identiasKelasList = $identiasKelasList->where('walas_id', $walasIdSelected);
    }

    // Ambil data agenda sesuai filter walas_id
    $identiasKelasList = $identiasKelasList->get();

    // Jika 'export=pdf', proses pembuatan PDF
    if ($request->get('export') == 'pdf') {
        $pdf = Pdf::loadView('pdfkepsek.identitaskelas', ['data' => $identiasKelasList]);
        return $pdf->stream('Identitas_Kelas.pdf');
    }

    // Return view dengan data yang difilter
    return view("homepagekepsek.admwalas.identitaskelas.index", compact('walasList', 'walasIds', 'kepsek', 'identiasKelasList', 'walasIdSelected'));
}

    

    public function lembarpengesahankepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
       $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

       // Ambil data walas berdasarkan ID yang sesuai
       $walasList = Walas::whereIn('id', $walasIds)->get();

       // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
       $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $lembarPengesahan = LembarPengesahan::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $lembarPengesahan = $lembarPengesahan->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $lembarPengesahan = $lembarPengesahan->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.lembarpengesahan.index", compact('walasList', 'walasIds', 'kepsek', 'lembarPengesahan'));
    } 

    public function strukturorganisasikelaskepsek(Request $request)
    {
         // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
         $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

         // Periksa apakah session 'kepsek_id' ada
         if (!session()->has('kepsek_id')) {
             return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
         }
 
         // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
         $kepsek = Kepsek::find(session('kepsek_id'));
 
         // Periksa apakah data kepsek ditemukan
         if (!$kepsek) {
             return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
         }
 
         // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $strukturOrganisasi = StrukturOrganisasiKelas::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $strukturOrganisasi = $strukturOrganisasi->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $strukturOrganisasi = $strukturOrganisasi->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.strukturorganisasi.index", compact('walasList', 'walasIds', 'kepsek', 'strukturOrganisasi'));
    } 

    public function jadwalkbmkepsek(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil walas_id dari URL query parameter
        $walasIdSelected = $request->query('walas_id'); 

        // **[PERBAIKAN]: Buat variabel query sebelum filter**
        $jadwalKbmsQuery = JadwalKBM::with(['rombel', 'walas']);

        if ($walasIdSelected) {
            $jadwalKbmsQuery->where('walas_id', $walasIdSelected);
        }

        // Eksekusi query untuk mendapatkan hasil
        $jadwalKbms = $jadwalKbmsQuery->get();
        $rombel = $jadwalKbms->first()?->rombel
            ?? Rombel::where('walas_id', $walasIdSelected)->first();

        // Ambil data mapel dan guru untuk ditampilkan
        $mapels = Mapel::all()->keyBy('id');
        $gurus = Guru::all()->keyBy('id');

        // Jika export ke PDF
        if ($request->input('export') === 'pdf') {
            $data = [
                'jadwalKbms' => $jadwalKbms,
                'mapels' => $mapels,
                'gurus' => $gurus
            ];
            $pdf = Pdf::loadView('pdf.jadwalkbm', $data)->setPaper('A4', 'portrait');
            return $pdf->stream('Jadwal_KBM.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.jadwalkbm.index", compact(
            'walasList',
            'walasIds',
            'kepsek',
            'jadwalKbms',
            'walasIdSelected',
            'rombel',
            'mapels',
            'gurus'
        ));
    }


    public function presensiskepsek(Request $request)
{
    // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
    $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

    // Periksa apakah session 'kepsek_id' ada
    if (!session()->has('kepsek_id')) {
        return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
    $kepsek = Kepsek::find(session('kepsek_id'));

    // Periksa apakah data kepsek ditemukan
    if (!$kepsek) {
        return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
    }

    // Ambil semua ID walas
    $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

    // Ambil data walas berdasarkan walas_id yang sesuai
    $walasList = Walas::whereIn('id', $walasIds)->get();

    // Ambil data walas_id yang dipilih dari query parameter (jika ada)
    $walasIdSelected = $request->query('walas_id');
    $semester = $request->query('semester'); // Parameter semester (ganjil/genap)

    // Query presensi berdasarkan filter walas_id dan semester
    $presensis = Presensi::whereIn('walas_id', $walasIds)
        ->when($walasIdSelected, function ($query) use ($walasIdSelected) {
            return $query->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        })
        ->when($semester === 'ganjil', function ($query) {
            return $query->whereMonth('tanggal', '>=', 7)->whereMonth('tanggal', '<=', 12); // Filter bulan semester ganjil
        })
        ->when($semester === 'genap', function ($query) {
            return $query->whereMonth('tanggal', '>=', 1)->whereMonth('tanggal', '<=', 6); // Filter bulan semester genap
        })
        ->get();

    // Jika ada parameter 'export=pdf', generate PDF
    if ($request->has('export') && $request->get('export') === 'pdf') {
        // Generate PDF menggunakan view dengan data yang difilter
        $pdf = Pdf::loadView('pdfkepsek.rekapkehadiran', compact('walasList', 'presensis', 'semester', 'walasIdSelected'))
            ->setPaper('A4', 'landscape');
        return $pdf->stream('rekap_kehadiran_' . $semester . '.pdf');
    }

    // Return view dengan data yang difilter
    return view("homepagekepsek.admwalas.presensi.index", compact('walasList', 'walasIds', 'kepsek', 'presensis', 'walasIdSelected'));
}


    public function piketkelaskepsek(Request $request)
{
    // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
    $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

    // Periksa apakah session 'kepsek_id' ada
    if (!session()->has('kepsek_id')) {
        return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
    $kepsek = Kepsek::find(session('kepsek_id'));

    // Periksa apakah data kepsek ditemukan
    if (!$kepsek) {
        return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
    }

    // Ambil walas_id yang dipilih dari query parameter
    $walasIdSelected = $request->query('walas_id');

    // Ambil daftar walas berdasarkan walas_id yang dipilih saja (jika ada)
    $walasList = Walas::when($walasIdSelected, function ($query) use ($walasIdSelected) {
        return $query->where('id', $walasIdSelected);
    })->get();

    // Ambil data jadwal piket berdasarkan walas_id yang dipilih
    $piket = JadwalPiket::when($walasIdSelected, function ($query) use ($walasIdSelected) {
        return $query->where('walas_id', $walasIdSelected);
    })->get();

    // Ambil detail jadwal piket hanya untuk jadwal yang sesuai dengan walas_id yang dipilih
    $detailpiket = DetailJadwalPiket::whereIn('jadwalpikets_id', $piket->pluck('id'))->get();

    // Ambil data rombel berdasarkan walas_id yang dipilih
    $rombel = $walasIdSelected ? Rombel::where('walas_id', $walasIdSelected)->first() : null;

    // Jika rombel tidak ditemukan, kembalikan dengan pesan error
    if ($walasIdSelected && !$rombel) {
        return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
    }

    // Ambil data siswa berdasarkan rombels_id yang sesuai
    $siswas = $rombel ? Siswa::where('rombels_id', $rombel->id)->get() : collect([]);

    $data = $piket->map(function ($item) use ($detailpiket) {
        // Ambil siswa yang terhubung berdasarkan jadwalpikets_id
        $siswas = $detailpiket->where('jadwalpikets_id', $item->id)->map(function ($detailpiket) {
            return \App\Models\Siswa::find($detailpiket->siswas_id); // Ambil data siswa berdasarkan siswas_id
        })->filter(); // Filter untuk menghapus nilai null
            
        return [
            'id' => $item->id,
            'nama_hari' => $item->nama_hari,
            'siswas' => $siswas, // Menyimpan objek siswa yang terhubung
        ];
    })->toArray();

            // Ambil data walas berdasarkan walas_id yang dipilih
        $walas = Walas::find($walasIdSelected);

    if ($request->get('export') == 'pdf') {
        $pdf = Pdf::loadView('pdfkepsek.jadwalpiket', compact('walasList', 'data', 'siswas', 'rombel', 'walas'));
        return $pdf->stream('Jadwal_Piket.pdf');
    }
    

    // Return view dengan data yang difilter
    return view("homepagekepsek.admwalas.jadwalpiket.index", compact('walasList', 'walasIdSelected', 'kepsek', 'piket', 'detailpiket', 'data', 'siswas', 'rombel'));
}


    public function serahterimaraporkepsek(Request $request)
    {
        
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $rapor = DaftarSerahTerimaRapor::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $rapor = $rapor->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $rapor = $rapor->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.daftarpenyerahanrapot.index", compact('walasList', 'walasIds', 'kepsek', 'rapor'));
    }

    public function catatankasuskepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login
    
        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));
    
        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }
    
        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array
    
        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();
    
        // Ambil walas_id yang dipilih dari query parameter
        $walasIdSelected = $request->query('walas_id');  // Ambil walas_id dari URL query parameter
    
        // Query untuk mendapatkan catatan kasus berdasarkan walas_id yang dipilih
        $catatankasus = CatatanKasusSiswa::whereIn('walas_id', $walasIds);
    
        if ($walasIdSelected) {
            $catatankasus = $catatankasus->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }
    
        // Ambil data catatan kasus sesuai filter walas_id
        $catatankasus = $catatankasus->get();
    
        // Jika request mengandung parameter 'export' dan nilainya 'pdf', buat PDF
        if ($request->has('export') && $request->get('export') === 'pdf') {
            if ($walasIdSelected) {
                $walas = Walas::find($walasIdSelected); // Ambil data wali kelas yang dipilih
            } else {
                return redirect()->route('admwalas.catatankasuskepsek')->with('error', 'Walas ID tidak ditemukan.');
            }
    
            // Generate PDF
            $pdf = Pdf::loadView('pdfkepsek.catatankasus', compact('walas', 'catatankasus'));
            return $pdf->stream('Catatan_Kasus.pdf');
        }
    
        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.catatankasus.index", compact('walasList', 'walasIds', 'kepsek', 'catatankasus', 'walasIdSelected'));
    }
    

    public function daftarpesertadidikkepsek(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }

        // Ambil semua ID walas dalam bentuk array
        $walasIds = Walas::pluck('id')->toArray();

        // Ambil data walas berdasarkan walas_id yang sesuai
    $walasList = Walas::whereIn('id', $walasIds)->get();

    // Ambil walas_id dari URL query parameter
    $walasIdSelected = $request->query('walas_id');

    \App\Services\DaftarPesertaDidikService::syncAllRombels();

    // Ambil data peserta didik berdasarkan walas_id
    $daftarPDidik = DaftarPesertaDidik::whereIn('walas_id', $walasIds)->with(['siswa.biodata']);

    // Filter jika walas_id dipilih
    if ($walasIdSelected && in_array($walasIdSelected, $walasIds)) {
        $daftarPDidik = $daftarPDidik->where('walas_id', $walasIdSelected);
    }

    // Ambil data daftar peserta didik setelah filter
    $daftarPDidik = $daftarPDidik->get();

    // Hitung jumlah jenis kelamin setelah data diambil
    $jenisKelaminCount = $daftarPDidik->groupBy('jenis_kelamin')->map(function ($items) {
        return count($items);
    });

    if (request()->has('export') && request()->get('export') === 'pdf') {
        // Mengirimkan data untuk PDF
        $pdf = Pdf::loadView('pdfkepsek.daftarpesertadidik', compact('walasList', 'walasIds', 'kepsek', 'daftarPDidik', 'jenisKelaminCount', 'walasIdSelected'));
        return $pdf->stream('Daftar_Peserta_Didik.pdf');
    }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.daftarpesertadidik.index", compact('walasIdSelected','walasList', 'walasIds', 'kepsek', 'daftarPDidik', 'jenisKelaminCount'));
    }


    public function rekapitulasipdidikkepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
       $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

       // Ambil data walas berdasarkan walas_id yang sesuai
       $walasList = Walas::whereIn('id', $walasIds)->get();

       // Ambil walas_id yang dipilih dari URL
       $walasIdSelected = $request->query('walas_id'); 

       // Ambil data rekapitulasi jumlah siswa berdasarkan walas_id
       $rekapitulasiPDidik = RekapitulasiJumlahSiswa::whereIn('walas_id', $walasIds);

       // Jika walas_id dipilih, filter berdasarkan walas_id tersebut
       if ($walasIdSelected) {
           $rekapitulasiPDidik = $rekapitulasiPDidik->where('walas_id', $walasIdSelected);
           // Ambil data walas yang dipilih
           $walas = Walas::find($walasIdSelected);
       }

       // Ambil data sesuai filter walas_id
       $rekapitulasiPDidik = $rekapitulasiPDidik->get();

       // Jika request untuk export ke PDF
       if ($request->has('export') && $request->get('export') === 'pdf') {
           $pdf = Pdf::loadView('pdfkepsek.rekapitulasijumlahsiswa', compact('walasList', 'walasIds', 'kepsek', 'rekapitulasiPDidik', 'walasIdSelected', 'walas'));
           return $pdf->stream('Rekap_Jumlah_Siswa.pdf');
       }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.rekapitulasijumlahsiswa.index", compact('walasIdSelected','walasList', 'walasIds', 'kepsek', 'rekapitulasiPDidik'));
    }

    public function homevisitkepsek(Request $request)
    {
       // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $homevisit = HomeVisit::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $homevisit = $homevisit->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $homevisit = $homevisit->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.homevisit.index", compact('walasList', 'walasIds', 'kepsek', 'homevisit', 'walasIdSelected'));
    }
    public function generatePDFkepsekhomevisit(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil walas_id yang dipilih dari request
        $walasIdSelected = $request->input('walas_id'); // Menggunakan input dari form POST

        // Ambil data home visit berdasarkan walas_id yang sesuai
        $homevisit = HomeVisit::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $homevisit = $homevisit->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data rombel berdasarkan walas yang dipilih
        $rombel = Rombel::where('walas_id', $walasIdSelected)->first();


        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }

        // Ambil data wali kelas berdasarkan walas_id yang dipilih
        $walas = Walas::where('id', $walasIdSelected)->first();

        // Debugging untuk memastikan data walas ditemukan
        if (!$walas) {
            return redirect()->back()->with('error', 'Data Wali Kelas tidak ditemukan.');
        }

        // Ambil data agenda sesuai filter walas_id
        $homevisit = $homevisit->get();

        // Ambil base64 dari request (grafik chart)
        $suratImage = $request->input('suratImage');
        $dokumImage = $request->input('dokumImage');

        // Konversi gambar bukti_url dan dokumentasi_url ke base64
        foreach ($homevisit as $item) {
            $item->bukti_base64 = $this->convertToBase64($item->bukti_url);
            $item->dokumentasi_base64 = $this->convertToBase64($item->dokumentasi_url);
        }

        // Load view PDF dengan variabel yang sudah didefinisikan
        $pdf = Pdf::loadView('pdfkepsek.homevisit', compact(
            'walas',
            'walasList',
            'rombel',
            'walasIds',
            'kepsek',
            'homevisit',
            'suratImage',
            'dokumImage',
            'walasIdSelected'
        ));

        return $pdf->stream('Home_Visit.pdf');
    }

    public function bukutamuortukepsek(Request $request)
    {
         // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $bukutamu = BukuTamuOrangtua::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $bukutamu = $bukutamu->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $bukutamu = $bukutamu->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.bukutamuortu.index", compact('walasIdSelected','walasList', 'walasIds', 'kepsek', 'bukutamu'));
    }
    public function generatePDFkepsekbukutamuortu(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();
    
        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));
    
        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }
    
        // Ambil semua ID walas
        $walasIds = Walas::pluck('id');
    
        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();
    
        // Ambil walas_id yang dipilih dari parameter request
        $walasIdSelected = $request->input('walas_id');
    
        // Jika tidak ada walas_id yang dipilih, gunakan default walas pertama dari daftar
        if (!$walasIdSelected && $walasList->isNotEmpty()) {
            $walasIdSelected = $walasList->first()->id;
        }
    
        // Ambil data walas yang dipilih
        $walas = Walas::find($walasIdSelected);
        if (!$walas) {
            return redirect()->back()->with('error', 'Data Wali Kelas tidak ditemukan.');
        }
    
        // Ambil data rombel berdasarkan walas_id yang dipilih
        $rombel = Rombel::where('walas_id', $walasIdSelected)->first();
        if (!$rombel) {
            return redirect()->back()->with('error', 'Rombel tidak ditemukan.');
        }
    
        $bukutamu = BukuTamuOrangtua::where('walas_id', $walasIdSelected)->get();
    
        // Konversi gambar ke base64 jika ada dokumentasi
        foreach ($bukutamu as $item) {
            $item->dokumentasi_base64 = $this->convertToBase64($item->dokumentasi_url);
        }
    
        // Load view PDF dengan data yang difilter
        $pdf = Pdf::loadView('pdfkepsek.bukutamuortu', compact('rombel', 'walas', 'kepsek', 'bukutamu'));
    
        return $pdf->stream('Buku_Tamu_Ortu.pdf');
    }
    
    public function persentasesosialekonomikepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
    $walasList = Walas::whereIn('id', $walasIds)->get();

    // Ambil walas_id yang dipilih dari URL query parameter
    $walasIdSelected = $request->query('walas_id'); 

    // Ambil data persentase sosial ekonomi berdasarkan walas_id yang sesuai
    $persentasesosialekonomi = PersentaseSosialEkonomi::whereIn('walas_id', $walasIds);

    // Jika walas_id dipilih, filter berdasarkan walas_id tersebut
    if ($walasIdSelected) {
        $persentasesosialekonomi = $persentasesosialekonomi->where('walas_id', $walasIdSelected);
        // Ambil data walas yang dipilih
        $walas = Walas::find($walasIdSelected);
    }

    // Ambil data sesuai filter walas_id
    $persentasesosialekonomi = $persentasesosialekonomi->get();

    // Jika request untuk export ke PDF
    if ($request->has('export') && $request->get('export') === 'pdf') {
        $pdf = Pdf::loadView('pdfkurikulum.persentasesosialekonomi', compact('walasList', 'walasIds', 'kepsek', 'persentasesosialekonomi', 'walas', 'walasIdSelected'));
        return $pdf->stream('Persentase_Sosial_Ekonomi.pdf');
    }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.persentasesosialekonomi.index", compact('walasList', 'walasIds', 'kepsek', 'persentasesosialekonomi', 'walasIdSelected'));
    }

    public function rentangpendapatanortukepsek(Request $request)
{
    // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
    $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

    // Periksa apakah session 'kepsek_id' ada
    if (!session()->has('kepsek_id')) {
        return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
    $kepsek = Kepsek::find(session('kepsek_id'));

    // Periksa apakah data kepsek ditemukan
    if (!$kepsek) {
        return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
    }

    // Ambil semua ID walas
    $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

    // Ambil data walas berdasarkan walas_id yang sesuai
    $walasList = Walas::whereIn('id', $walasIds)->get();

    // Ambil walas_id dari URL query parameter
    $walasIdSelected = $request->query('walas_id'); 

    // Query utama untuk data siswa
    $query = BiodataSiswa::whereIn('walas_id', $walasIds);

    // Filter jika ada walas_id yang dipilih
    if ($walasIdSelected) {
        $query->where('walas_id', $walasIdSelected);
    }

    $dataPendapatan = [
        'Kurang dari Rp1.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Kurang dari Rp1.000.000,00')->where('walas_id', $walasIdSelected)->count(),
        'Rp1.000.000,00 - Rp3.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp1.000.000,00 - Rp3.000.000,00')->where('walas_id', $walasIdSelected)->count(),
        'Rp3.000.000,00 - Rp5.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp3.000.000,00 - Rp5.000.000,00')->where('walas_id', $walasIdSelected)->count(),
        'Rp5.000.000,00 - Rp10.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp5.000.000,00 - Rp10.000.000,00')->where('walas_id', $walasIdSelected)->count(),
        'Rp10.000.000,00 - Rp25.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp10.000.000,00 - Rp25.000.000,00')->where('walas_id', $walasIdSelected)->count(),
        'Rp25.000.000,00 - Rp50.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp25.000.000,00 - Rp50.000.000,00')->where('walas_id', $walasIdSelected)->count(),
        'Lebih dari Rp50.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Lebih dari Rp50.000.000,00')->where('walas_id', $walasIdSelected)->count(),
    ];

    // Ambil data siswa hanya untuk walas yang sedang login
    $pendapatan = BiodataSiswa::select('id', 'nama_lengkap', 'pendapatan_ortu')
        ->where('walas_id', $walasIdSelected)
        ->get();


    // Return view dengan data yang difilter
    return view("homepagekepsek.admwalas.pendapatanortu.index", compact('walasList', 'walasIds', 'kepsek', 'dataPendapatan', 'pendapatan', 'walasIdSelected'));
}

    public function generatePDFkepsekpendapatanortu(Request $request)
    {
        // Ambil walas_id yang dipilih dari form
        $walasIdSelected = $request->input('walas_id');
        
        // Ambil data pendapatan siswa berdasarkan walas_id yang dipilih
        $pendapatan = BiodataSiswa::select('id', 'nama_lengkap', 'pendapatan_ortu')
            ->where('walas_id', $walasIdSelected)
            ->get();

        // Ambil data kepsek dan data pendapatan per rentang
        $kepsek = Kepsek::find(session('kepsek_id'));
        $walas = Walas::find($walasIdSelected);

        $dataPendapatan = [
            'Kurang dari Rp1.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Kurang dari Rp1.000.000,00')->count(),
            'Rp1.000.000,00 - Rp3.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp1.000.000,00 - Rp3.000.000,00')->count(),
            'Rp3.000.000,00 - Rp5.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp3.000.000,00 - Rp5.000.000,00')->count(),
            'Rp5.000.000,00 - Rp10.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp5.000.000,00 - Rp10.000.000,00')->count(),
            'Rp10.000.000,00 - Rp25.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp10.000.000,00 - Rp25.000.000,00')->count(),
            'Rp25.000.000,00 - Rp50.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp25.000.000,00 - Rp50.000.000,00')->count(),
            'Lebih dari Rp50.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Lebih dari Rp50.000.000,00')->count(),
        ];

        // Ambil chartImage dari request
        $chartImage = $request->input('chartImage');

        // Generate PDF dengan data yang diperlukan
        $pdf = Pdf::loadView('pdfkepsek.pendapatanortu', compact('pendapatan', 'kepsek', 'dataPendapatan', 'chartImage', 'walas'));
        return $pdf->stream('Pendapatan_Orang_Tua_Kepsek.pdf');
    }


    public function prestasisiswakepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kepsek = Auth::guard('kepseks')->user();  // Mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data prestasi siswa berdasarkan walas_id yang dipilih
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $prestasisiswa = PrestasiSiswa::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $prestasisiswa = $prestasisiswa->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data prestasi siswa sesuai filter walas_ids
        $prestasisiswa = $prestasisiswa->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.prestasisiswa.index", compact('walasList', 'walasIds', 'kepsek', 'prestasisiswa', 'walasIdSelected'));
    }

        public function generatePDFkepsekprestasi(Request $request)
        {
            // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
            $kepsek = Auth::guard('kepseks')->user();  // Mendapatkan data kepsek yang sedang login

            // Periksa apakah session 'kepsek_id' ada
            if (!session()->has('kepsek_id')) {
                return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
            }

            // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
            $kepsek = Kepsek::find(session('kepsek_id'));

            // Periksa apakah data kepsek ditemukan
            if (!$kepsek) {
                return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
            }

            // Ambil data walas berdasarkan walas_id yang dipilih
            $walasIdSelected = $request->input('walas_id'); // Ambil walas_id dari input POST
            $walasList = Walas::where('id', $walasIdSelected)->get(); // Mengambil data walas berdasarkan walas_id yang dipilih

            // Ambil data prestasi siswa berdasarkan walas_id yang dipilih
            $prestasisiswa = PrestasiSiswa::where('walas_id', $walasIdSelected)->get();
            // Ambil data rombel untuk keperluan PDF
            $rombel = Rombel::where('walas_id', $walasIdSelected)->first();

            // Periksa apakah rombel ditemukan
            if (!$rombel) {
                return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
            }

            // Ambil base64 dari request (grafik chart)
            $sertifImage = $request->input('sertifImage');
            $dokumImage = $request->input('dokumImage');
            

            // Konversi gambar bukti_url dan dokumentasi_url ke base64
            foreach ($prestasisiswa as $item) {
                $item->sertifikat_base64 = $this->convertToBase64($item->sertifikat_url);
                $item->dokumentasi_base64 = $this->convertToBase64($item->dokumentasi_url);
            }

            // Load view PDF dan kirim walasList bersama dengan data lainnya
            $pdf = Pdf::loadView('pdfkepsek.prestasisiswa', compact('walasList', 'kepsek', 'prestasisiswa', 'sertifImage', 'dokumImage', 'walasIdSelected','rombel'));

            return $pdf->stream('Prestasi_Siswa.pdf');
        }


// Fungsi untuk mengubah gambar ke base64
private function convertToBase64($path)
{
    $fullPath = storage_path("app/public/" . $path);
    
    if (file_exists($fullPath)) {
        $imageData = file_get_contents($fullPath);
        $mimeType = mime_content_type($fullPath);
        return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
    }

    return null;
}

    public function grafikjaraktempuhkepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $grafikjaraktempuh = BiodataSiswa::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $grafikjaraktempuh = $grafikjaraktempuh->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

         // Kelompokkan data berdasarkan rentang jarak tempuh
         $dataJarak = [
            'Kurang dari 1 km' => 0,
            '1 km - 3 km' => 0,
            '3 km - 5 km' => 0,
            '5 km - 10 km' => 0,
            '10 km - 25 km' => 0,
            '25 km - 50 km' => 0,
            'Lebih dari 50 km' => 0,
        ];
    
        $jarakSiswa = BiodataSiswa::where('walas_id', $walasIdSelected)->pluck('jarak_rumah');

        foreach ($jarakSiswa as $jarak) {
            preg_match('/\d+(\.\d+)?/', $jarak, $matches); // Ambil angka dari string (termasuk desimal)
            $km = isset($matches[0]) ? floatval($matches[0]) : null;
    
            if ($km !== null) {
                if ($km < 1) {
                    $dataJarak['Kurang dari 1 km']++;
                } elseif ($km < 3) {
                    $dataJarak['1 km - 3 km']++;
                } elseif ($km < 5) {
                    $dataJarak['3 km - 5 km']++;
                } elseif ($km < 10) {
                    $dataJarak['5 km - 10 km']++;
                } elseif ($km < 25) {
                    $dataJarak['10 km - 25 km']++;
                } elseif ($km < 50) {
                    $dataJarak['25 km - 50 km']++;
                } else {
                    $dataJarak['Lebih dari 50 km']++;
                }
            }
        }

        // Ambil data agenda sesuai filter walas_id
        $grafikjaraktempuh = $grafikjaraktempuh->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.grafikjaraktempuh.index", compact('walasList', 'walasIds', 'kepsek', 'grafikjaraktempuh', 'dataJarak'));
    }
    public function generatePDFkepsekgrafikjaraktempuh(Request $request)
    {
        // Ambil data kepsek berdasarkan session
        $kepsek = Kepsek::find(session('kepsek_id'));
    
        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepsek tidak ditemukan.');
        }
    
        // Ambil walas_id dari request untuk disaring
        $walasIdSelected = $request->input('walas_id');
    
        // Kelompokkan data jarak tempuh (sama seperti di index)
        $dataJarak = [
            'Kurang dari 1 km' => 0,
            '1 km - 3 km' => 0,
            '3 km - 5 km' => 0,
            '5 km - 10 km' => 0,
            '10 km - 25 km' => 0,
            '25 km - 50 km' => 0,
            'Lebih dari 50 km' => 0,
        ];
    
        // Ambil data jarak tempuh siswa berdasarkan walas_id yang dipilih
        $jarakSiswa = BiodataSiswa::where('walas_id', $walasIdSelected)->pluck('jarak_rumah');
    
        foreach ($jarakSiswa as $jarak) {
            preg_match('/\d+(\.\d+)?/', $jarak, $matches);
            $km = isset($matches[0]) ? floatval($matches[0]) : null;
    
            if ($km !== null) {
                if ($km < 1) {
                    $dataJarak['Kurang dari 1 km']++;
                } elseif ($km < 3) {
                    $dataJarak['1 km - 3 km']++;
                } elseif ($km < 5) {
                    $dataJarak['3 km - 5 km']++;
                } elseif ($km < 10) {
                    $dataJarak['5 km - 10 km']++;
                } elseif ($km < 25) {
                    $dataJarak['10 km - 25 km']++;
                } elseif ($km < 50) {
                    $dataJarak['25 km - 50 km']++;
                } else {
                    $dataJarak['Lebih dari 50 km']++;
                }
            }
        }
    
        // Ambil base64 dari request (gambar grafik)
        $chartImage = $request->input('chartImage');
    
        // Load view PDF
        $pdf = Pdf::loadView('pdfkepsek.grafikjaraktempuh', compact('kepsek', 'dataJarak', 'chartImage', 'walasIdSelected'))
            ->setPaper('A4', 'landscape');
    
        return $pdf->stream('Jarak_rumah_Siswa.pdf');
    }
    

    public function beritaacarakenaikankepsek(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();  
    
        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));
    
        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }
    
        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array
    
        // Ambil data wali kelas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();
    
        // Ambil data walas_id yang dipilih dari query parameter
        $walasIdSelected = $request->query('walas_id', null);  

        //$beritaAcara = BeritaAcaraKenaikan::with(['walas', 'rombel'])->get();
        $beritaAcara = BeritaAcaraKenaikan::where('walas_id', $walasIdSelected)->get();

        // Ambil data walas berdasarkan walas_id yang dipilih
        $walas = Walas::find($walasIdSelected);

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkepsek.beritaacarakenaikan', compact('walasIdSelected', 'beritaAcara','walas'));
            return $pdf->stream('Berita_Acara.pdf');
        }

        return view('homepagekepsek.admwalas.beritaacarakenaikan.index', compact('walasList', 'walasIds', 'kepsek', 'walasIdSelected','beritaAcara','walas'));
    }

    public function beritaacarakelulusankepsek(Request $request)
    {
        
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();  
    
        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));
    
        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }
    
        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array
    
        // Ambil data wali kelas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();
    
        // Ambil data walas_id yang dipilih dari query parameter
        $walasIdSelected = $request->query('walas_id', null);  

        //$beritaAcara = BeritaAcaraKenaikan::with(['walas', 'rombel'])->get();
        $beritaAcara = BeritaAcaraKenaikan::where('walas_id', $walasIdSelected)->get();

        // Ambil data walas berdasarkan walas_id yang dipilih
        $walas = Walas::find($walasIdSelected);

        //$beritaAcara = BeritaAcaraKenaikan::with(['walas', 'rombel'])->get();
        $beritaAcaraKelulusan = BeritaAcaraKelulusan::where('walas_id', $walasIdSelected)->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkepsek.beritaacarakelulusan', compact('walasIdSelected', 'beritaAcaraKelulusan', 'walas'));
            return $pdf->stream('Berita_Acara.pdf');
        }

        return view('homepagekepsek.admwalas.beritaacarakelulusan.index', compact('walasList', 'walasIds', 'kepsek', 'walasIdSelected','beritaAcaraKelulusan', 'walas'));
    }

    public function beritaacaraserahterimakepsek(Request $request)
    {
        
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();  
    
        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));
    
        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }
    
        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array
    
        // Ambil data wali kelas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();
    
        // Ambil data walas_id yang dipilih dari query parameter
        $walasIdSelected = $request->query('walas_id', null);  

        //$beritaAcara = BeritaAcaraKenaikan::with(['walas', 'rombel'])->get();
        $beritaAcara = BeritaAcaraKenaikan::where('walas_id', $walasIdSelected)->get();

        // Ambil data walas berdasarkan walas_id yang dipilih
        $walas = Walas::find($walasIdSelected);

        //$beritaAcara = BeritaAcaraKenaikan::with(['walas', 'rombel'])->get();
        $beritaacaraserahterima = BeritaAcaraSerahTerima::where('walas_id', $walasIdSelected)->get();

        return view('homepagekepsek.admwalas.beritaacaraserahterima.index', compact('walasList', 'walasIds', 'kepsek', 'walasIdSelected','beritaacaraserahterima'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($walas_id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login
    
        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }
  
        // Ambil data kurikulum berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));
        
        // Periksa apakah data kurikulum ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas berdasarkan walas_id
        $walas = Walas::find($walas_id);
    
        // Jika tidak ditemukan, kembalikan ke halaman sebelumnya dengan pesan error
        if (!$walas) {
            return redirect()->route('admwalasview.index')->with('error', 'Data Walas tidak ditemukan.');
        }
    
        // Kirim data ke view detail
        return view('homepagekaprog.admwalasview.admwalas', compact('walas', 'kakom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
