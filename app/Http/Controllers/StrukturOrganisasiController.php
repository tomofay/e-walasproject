<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Kepsek;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StrukturOrganisasiKelas;
use Barryvdh\DomPDF\Facade\Pdf;

class StrukturOrganisasiController extends Controller
{
    use HasWalasAuth;

    public function index(Request $request)
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $struktur = DB::table('vwstrukturorganisasi')
            ->where('wali_kelas', $walaslogin->nama)
            ->get();

        if ($request->get('export') == 'pdf') {
            if ($struktur->isEmpty()) {
                return redirect()->route('strukturorganisasi.index')->with('error', 'Data tidak tersedia untuk diunduh.');
            }

            $pdf = Pdf::loadView('pdf.strukturorganisasi', compact('struktur', 'walaslogin'));

            return $pdf->stream('Struktur_Organisasi.pdf');
        }

        return view("admwalas.strukturorganisasi.index", compact('struktur', 'walaslogin', 'rombel'));
    }

    public function create()
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswa = Siswa::where('rombels_id', $rombel->id)->get();
        $kepsek = Kepsek::all();
        $walas = Walas::all();

        return view('admwalas.strukturorganisasi.create', compact('siswa', 'kepsek', 'walaslogin', 'walas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'walas_id' => 'required|string|max:255',
            'kepala_sekolah' => 'required|string|max:255',
            'walas' => 'required|string|max:255',
            'ketuakelas' => 'required|string|max:255',
            'waketuakelas' => 'required|string|max:255',
            'bendahara' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'seksi_kebersihan' => 'required|string|max:255',
            'seksi_perlengkapan' => 'required|string|max:255',
            'seksi_keamanan' => 'required|string|max:255',
            'seksi_kerohanian' => 'required|string|max:255',
        ]);

        StrukturOrganisasiKelas::create($validated);

        return redirect()->route('strukturorganisasi.index')->with('success', 'Struktur organisasi berhasil dibuat.');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $struktur = StrukturOrganisasiKelas::findOrFail($id);
        $siswa = Siswa::where('rombels_id', $rombel->id)->get();
        $kepsek = Kepsek::all();
        $walas = Walas::all();

        return view('admwalas.strukturorganisasi.edit', compact('siswa', 'kepsek', 'walas', 'struktur', 'walaslogin', 'rombel'));
    }

    public function update(Request $request, string $id)
    {
        $struktur = StrukturOrganisasiKelas::findOrFail($id);

        $validated = $request->validate([
            'walas_id' => 'required|string|max:255',
            'kepala_sekolah' => 'required|string|max:255',
            'walas' => 'required|string|max:255',
            'ketuakelas' => 'required|string|max:255',
            'waketuakelas' => 'required|string|max:255',
            'bendahara' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'seksi_kebersihan' => 'required|string|max:255',
            'seksi_perlengkapan' => 'required|string|max:255',
            'seksi_keamanan' => 'required|string|max:255',
            'seksi_kerohanian' => 'required|string|max:255',
        ]);

        $struktur->update($validated);

        return redirect()->route('strukturorganisasi.index')->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    public function destroy(string $id) {}
}
