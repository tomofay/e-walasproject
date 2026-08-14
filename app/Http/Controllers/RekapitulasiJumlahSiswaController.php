<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\RekapitulasiJumlahSiswa;


class RekapitulasiJumlahSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();
        
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));
        
        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }
        
        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }
        
        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        
        // Ambil data rekapitulasi jumlah siswa berdasarkan walas_id tanpa relasi siswa
        $rekapjumlahsiswa = RekapitulasiJumlahSiswa::where('walas_id', $walas->id)->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.rekapitulasijumlahsiswa', compact('walas', 'rekapjumlahsiswa', 'siswas'));
            return $pdf->stream('Rekap_Jumlah_Siswa.pdf');
        }
        
        // Kirim data walas, siswa, dan rekapitulasi jumlah siswa ke view
        return view('admwalas.rekapitulasijumlahsiswa.index', compact('walas', 'rekapjumlahsiswa', 'siswas'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();

        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));

        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();

        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }

        // Ambil data siswa dengan relasi biodata siswa
        $siswas = Siswa::where('rombels_id', $rombel->id)
            ->with('biodata') // relasi biodata (bukan biodataSiswa)
            ->get();

        // Ambil ID pertama dari tabel kurikulums
        $kurikulumIdPertama = optional(Kurikulum::first())->id;

        // Kirim data ke view
        return view('admwalas.rekapitulasijumlahsiswa.create', compact('walas', 'siswas', 'rombel', 'kurikulumIdPertama'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();
        
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));

        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Ambil ID pertama dari tabel kurikulums
        $kurikulum = Kurikulum::first();
        $kurikulum_id = $kurikulum ? $kurikulum->id : null;

        // Validasi input
        $validatedData = $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'kurikulum_id' => 'required|integer',
            'jumlah_awal_siswa' => 'required',
            'jumlah_akhir_siswa' => 'required',
            'keterangan' => 'required|string|max:255',
            'bulan' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
            'ttdkurikulum_url' => 'nullable|url',
            'ttdwalas_url' => 'nullable|url',
        ]);

        // Tambahkan kurikulum_id secara otomatis
        $validatedData['kurikulum_id'] = $kurikulum_id;

        // Simpan data ke database
        RekapitulasiJumlahSiswa::create($validatedData);

        return redirect('/rekapjumlahsiswa')->with('success', 'Data berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();

        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));

        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();

        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }
        // Ambil ID pertama dari tabel kurikulums
        $kurikulumIdPertama = optional(Kurikulum::first())->id;

        $rekapjumlahsiswa = RekapitulasiJumlahSiswa::findOrFail($id);

        // Kirim data ke view
        return view('admwalas.rekapitulasijumlahsiswa.edit', compact('walas', 'rombel', 'kurikulumIdPertama', 'rekapjumlahsiswa'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
    $walas = Auth::guard('walas')->user();
    
    // Periksa apakah session 'walas_id' ada
    if (!session()->has('walas_id')) {
        return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data walas berdasarkan 'walas_id' yang ada di session
    $walas = Walas::find(session('walas_id'));

    // Periksa apakah data walas ditemukan
    if (!$walas) {
        return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
    }

    // Ambil data DaftarPesertaDidik yang akan diedit
    $rekapjumlahsiswa = RekapitulasiJumlahSiswa::findOrFail($id);

    // Ambil ID pertama dari tabel kurikulums
    $kurikulum = Kurikulum::first();
    $kurikulum_id = $kurikulum ? $kurikulum->id : null;

    // Validasi input
    $validatedData = $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'kurikulum_id' => 'required|integer',
        'jumlah_awal_siswa' => 'required',
        'jumlah_akhir_siswa' => 'required',
        'keterangan' => 'required|string|max:255',
        'bulan' => 'required|string|max:255',
        'tanggal' => 'nullable|date',
        'ttdkurikulum_url' => 'nullable|url',
        'ttdwalas_url' => 'nullable|url',
    ]);

    // Tambahkan kurikulum_id secara otomatis
    $validatedData['kurikulum_id'] = $kurikulum_id;

    // Update data DaftarPesertaDidik
    $rekapjumlahsiswa->update($validatedData);

    return redirect('/rekapjumlahsiswa')->with('success', 'Data berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function hapusrekapjumlahsiswa(string $id)
    {
        $rekapjumlahsiswa = RekapitulasiJumlahSiswa::find($id);
        if ($rekapjumlahsiswa) {
            $rekapjumlahsiswa->delete();
            return redirect('/rekapjumlahsiswa')->with('success', 'Data Rekaptiulasi Berhasil Dihapus ');
        }
        return redirect('/rekapjumlahsiswa')->with('error', 'Data Rekapitulasi not found!');
    }
}
