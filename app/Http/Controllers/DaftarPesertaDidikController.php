<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use App\Models\DaftarPesertaDidik;
use App\Models\BiodataSiswa;
use App\Http\Concerns\HasWalasAuth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class DaftarPesertaDidikController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $daftarpdidik = DaftarPesertaDidik::where('walas_id', $walas->id)
            ->with('siswa')
            ->get();

        $jenisKelaminCount = $daftarpdidik->groupBy('jenis_kelamin')->map(function ($items) {
            return $items->count();
        });

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.daftarpesertadidik', compact('walas', 'siswas', 'daftarpdidik', 'jenisKelaminCount'));
            return $pdf->stream('Daftar_Peserta_Didik.pdf');
        }

        // Kirim data walas, siswa, catatan kasus, dan jenisKelaminCount ke view
        return view('admwalas.daftarpesertadidik.index', compact('walas', 'daftarpdidik', 'siswas', 'jenisKelaminCount'));
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
        return view('admwalas.daftarpesertadidik.create', compact('walas', 'siswas', 'rombel', 'kurikulumIdPertama'));
    }

    public function getSiswa(string $id)
    {
        $siswa = $this->siswaDiRombel($id);
        $biodata = $siswa->biodata;

        return response()->json([
            'id' => $siswa->id,
            'nis' => $biodata?->nis,
            'nisn' => $biodata?->nisn,
            'nama' => $siswa->nama,
        ]);
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
        'nis' => 'required',
        'nisn' => 'required',
        'nama_siswa' => 'required|string|max:255',
        'keterangan' => 'nullable|string|max:255',  // Menjadi nullable
        'tanggal' => 'required|date',
        'jenis_kelamin' => 'required',
        'ttdwalas_url' => 'nullable|url',
    ]);

    // Set 'keterangan' otomatis menjadi 'aktif'
    $validatedData['keterangan'] = 'aktif';

    // Simpan data ke database
    DaftarPesertaDidik::create($validatedData);

    return redirect('/daftarpesertadidik')->with('success', 'Data berhasil disimpan.');
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

        $siswas = Siswa::where('rombels_id', $rombel->id)
            ->with('biodata')
            ->get();

        $kurikulumIdPertama = optional(Kurikulum::first())->id;

        $daftarPesertaDidik = DaftarPesertaDidik::findOrFail($id);

        // Kirim data ke view
        return view('admwalas.daftarpesertadidik.edit', compact('walas', 'siswas', 'rombel', 'kurikulumIdPertama', 'daftarPesertaDidik'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $walas = $this->getAuthenticatedWalas();

        $daftarPesertaDidik = DaftarPesertaDidik::findOrFail($id);

        $kurikulum = Kurikulum::first();
        $kurikulum_id = $kurikulum ? $kurikulum->id : null;

    // Validasi input
    $validatedData = $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'kurikulum_id' => 'required|integer',
        'nis' => 'required',
        'nisn' => 'required',
        'nama_siswa' => 'required|string|max:255',
        'keterangan' => 'nullable|string|max:255',  // Menjadi nullable
        'tanggal' => 'required|date',
        'jenis_kelamin' => 'required',
        'ttdwalas_url' => 'nullable|url',
    ]);

    // Set 'keterangan' otomatis menjadi 'aktif'
    $validatedData['keterangan'] = 'aktif';

    DB::transaction(function () use ($daftarPesertaDidik, $validatedData) {
        $daftarPesertaDidik->update($validatedData);

        BiodataSiswa::where('siswas_id', $validatedData['nama_siswa'])
            ->update([
                'nis' => $validatedData['nis'],
                'nisn' => $validatedData['nisn'],
            ]);
    });

    return redirect('/daftarpesertadidik')->with('success', 'Data berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function hapusdaftarpesertadidik(string $id)
    {
        $daftarpdidik = DaftarPesertaDidik::find($id);
        if ($daftarpdidik) {
            $daftarpdidik->delete();
            return redirect('/daftarpesertadidik')->with('success', 'Data Peserta Didik Berhasil Dihapus ');
        }
        return redirect('/daftarpesertadidik')->with('error', 'Data Peserta Didik Walas not found!');
    }
}
