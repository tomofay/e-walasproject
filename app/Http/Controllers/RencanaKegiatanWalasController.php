<?php

namespace App\Http\Controllers;

use App\Models\RencanaKegiatanWalas;
use App\Models\RencanaKegiatanWalasGenap;
use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;

class RencanaKegiatanWalasController extends Controller
{
    use HasWalasAuth;

    public function index($semester)
    {
        $walas = $this->getAuthenticatedWalas();

        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;
        $data = $model::with('walas', 'kurikulum')->get();

        return view('admwalas.rencana_kegiatan_walas.index', compact('data', 'semester', 'walas'));
    }

    public function create($semester)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        return view('admwalas.rencana_kegiatan_walas.create', compact('semester', 'walas', 'rombel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'minggu_ke' => 'required',
            'kegiatan_bukti' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'nullable|date',
            'ttdwalas_url' => 'nullable|url',
        ]);

        if ($request->semester === 'ganjil') {
            RencanaKegiatanWalas::create($validated);
        } else {
            RencanaKegiatanWalasGenap::create($validated);
        }

        return redirect()->route('rencana_kegiatan_walas.index', ['semester' => $request->semester])
            ->with('success', 'Data berhasil disimpan');
    }

    public function edit($semester, $id)
    {
        $walas = $this->getAuthenticatedWalas();

        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;
        $rencana_kegiatan = $model::findOrFail($id);
        $walasList = Walas::all();

        return view('admwalas.rencana_kegiatan_walas.edit', compact('rencana_kegiatan', 'walasList', 'walas', 'semester'));
    }

    public function update(Request $request, $semester, $id)
    {
        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;

        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'minggu_ke' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18',
            'kegiatan_bukti' => 'required',
            'keterangan' => 'required|in:true,false',
            'tanggalttd' => 'nullable|date',
            'ttdkurikulum_url' => 'nullable|string|max:255',
            'ttdwalas_url' => 'nullable|string|max:255',
        ]);

        $data = $model::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('rencana_kegiatan_walas.index', $semester)
            ->with('success', 'Data berhasil diperbarui!');
    }
}
