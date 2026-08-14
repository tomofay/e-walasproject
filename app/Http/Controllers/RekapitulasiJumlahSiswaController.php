<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RekapitulasiJumlahSiswa;


class RekapitulasiJumlahSiswaController extends Controller
{
    use HasWalasAuth;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
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
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)
            ->with('biodata')
            ->get();

        $kurikulumIdPertama = optional(Kurikulum::first())->id;

        // Kirim data ke view
        return view('admwalas.rekapitulasijumlahsiswa.create', compact('walas', 'siswas', 'rombel', 'kurikulumIdPertama'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();

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
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

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
        $walas = $this->getAuthenticatedWalas();

        $rekapjumlahsiswa = RekapitulasiJumlahSiswa::findOrFail($id);

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
