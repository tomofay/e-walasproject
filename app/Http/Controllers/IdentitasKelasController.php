<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use App\Models\IdentitasKelas;
use Illuminate\Support\Facades\DB;

class IdentitasKelasController extends Controller
{
    use HasWalasAuth;

    public function index(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $identitaskelas = IdentitasKelas::with(['walas10', 'walas11', 'walas12', 'walas13', 'siswa10', 'siswa11', 'siswa12', 'siswa13'])
            ->where(function ($query) use ($walas) {
                $query->where('walas_id_10', $walas->id)
                    ->orWhere('walas_id_11', $walas->id)
                    ->orWhere('walas_id_12', $walas->id);
            })
            ->get();

        if ($request->get('export') == 'pdf') {
            $pdf = Pdf::loadView('pdf.identitaskelas', ['data' => $identitaskelas]);

            return $pdf->stream('Identitas_Kelas.pdf');
        }

        return view('admwalas.identitaskelas.index', compact('identitaskelas', 'walas', 'rombel'));
    }

    public function create()
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $walas = Walas::all();

        return view('admwalas.identitaskelas.create', compact('walas', 'siswas', 'rombel', 'walaslogin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'program_keahlian' => 'required|in:SIJA,TKJ,RPL,DKV,DPIB,TKP,TP,TFLM,TKR,TOI',
            'kompetensi_keahlian' => 'required|in:SIJA,TKJ,RPL,DKV,DPIB,TKP,TP,TFLM,TKR,TOI',
            'walas_id_10' => 'nullable|exists:walas,id',
            'walas_id_11' => 'nullable|exists:walas,id',
            'walas_id_12' => 'nullable|exists:walas,id',
            'walas_id_13' => 'nullable|exists:walas,id',
            'siswas_id_10' => 'nullable|exists:siswas,id',
            'siswas_id_11' => 'nullable|exists:siswas,id',
            'siswas_id_12' => 'nullable|exists:siswas,id',
            'siswas_id_13' => 'nullable|exists:siswas,id',
        ]);

        IdentitasKelas::create($request->all());

        return redirect('/identitaskelas')->with('success', 'Data identitas kelas berhasil disimpan');
    }

    public function show(string $id) {}

    public function edit($identitas_kelas_id)
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $identitaskelas = IdentitasKelas::findOrFail($identitas_kelas_id);
        $walas = Walas::all();
        $siswas = Siswa::all();

        return view('admwalas.identitaskelas.edit', compact('identitaskelas', 'walas', 'siswas', 'walaslogin', 'rombel'));
    }

    public function update(Request $request, $identitas_kelas_id)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'program_keahlian' => 'required|in:SIJA,TKJ,RPL,DKV,DPIB,TKP,TP,TFLM,TKR,TOI',
            'kompetensi_keahlian' => 'required|in:SIJA,TKJ,RPL,DKV,DPIB,TKP,TP,TFLM,TKR,TOI',
            'walas_id_10' => 'required|exists:walas,id',
            'walas_id_11' => 'nullable|exists:walas,id',
            'walas_id_12' => 'nullable|exists:walas,id',
            'walas_id_13' => 'nullable|exists:walas,id',
            'siswas_id_10' => 'required|exists:siswas,id',
            'siswas_id_11' => 'nullable|exists:siswas,id',
            'siswas_id_12' => 'nullable|exists:siswas,id',
            'siswas_id_13' => 'nullable|exists:siswas,id',
        ]);

        $identitaskelas = IdentitasKelas::findOrFail($identitas_kelas_id);
        $identitaskelas->update($request->all());

        return redirect()->route('identitaskelas.index')->with('success', 'Data identitas kelas berhasil diperbarui');
    }

    public function destroy(string $id) {}
}
