<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use App\Models\KeluarRombel;
use Illuminate\Http\Request;

class KeluarRombelController extends Controller
{
    use HasWalasAuth;

    public function index() {}

    public function create() {}

    public function store(Request $request, $id)
    {
        $walas = $this->getAuthenticatedWalas();

        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'keterangan' => 'required',
            'nama_kelas' => 'required|string',
        ]);

        $rombels = Rombel::where('nama_kelas', $validated['nama_kelas'])->first();

        if (! $rombels) {
            return back()->with('error', 'Kelas tidak ditemukan');
        }

        KeluarRombel::create([
            'siswa_id' => $siswa->id,
            'keterangan' => $validated['keterangan'],
            'rombels_id' => $rombels->id,
        ]);

        return back()->with('success', 'Keterangan Siswa berhasil Dirubah');
    }

    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}

    public function saveKeterangan(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'keterangan' => 'required|in:naik_kelas,tidak_naik_kelas,pindah_sekolah',
        ]);

        $siswa = Siswa::find($request->siswa_id);

        $keluarRombel = KeluarRombel::create([
            'siswa_id' => $siswa->id,
            'keterangan' => $request->keterangan,
            'rombels_id' => $rombel->id,
        ]);

        return response()->json(['success' => 'Data berhasil disimpan!', 'keluarRombel' => $keluarRombel]);
    }
}
