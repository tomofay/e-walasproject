<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CatatanKasusSiswa;

class CatatanKasusSiswaController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $catatankasus = CatatanKasusSiswa::where('walas_id', $walas->id)
            ->with('siswa')
            ->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.catatankasus', compact('walas', 'rombel', 'siswas', 'catatankasus'));

            return $pdf->stream('Catatan_Kasus.pdf');
        }

        return view('admwalas.catatankasus.index', compact('walas', 'catatankasus', 'siswas'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.catatankasus.create', compact('walas', 'siswas', 'rombel'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'required|exists:siswas,id',
            'kasus' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        CatatanKasusSiswa::create($validatedData);

        return redirect('/catatankasus')->with('success', 'Catatan kasus berhasil disimpan!');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $catatan = CatatanKasusSiswa::findOrFail($id);
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.catatankasus.edit', compact('walas', 'siswas', 'rombel', 'catatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswas_id' => 'required|exists:siswas,id',
            'kasus' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        $catatan = CatatanKasusSiswa::findOrFail($id);

        $catatan->update([
            'walas_id' => $request->walas_id,
            'siswas_id' => $request->siswas_id,
            'kasus' => $request->kasus,
            'tindak_lanjut' => $request->tindak_lanjut,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('catatankasus.index')->with('success', 'Catatan kasus berhasil diupdate.');
    }

    public function hapuscatatankasus(string $id)
    {
        $catatankasus = CatatanKasusSiswa::find($id);

        if ($catatankasus) {
            $catatankasus->delete();

            return redirect('/catatankasus')->with('success', 'Agenda Walas data Berhasil Dihapus ');
        }

        return redirect('/catatankasus')->with('error', 'Agenda Walas not found!');
    }
}
