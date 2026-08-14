<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Siswa;
use App\Models\KelompokSiswa;
use App\Models\Rombel;
use App\Models\DenahTempatKerjaKelompok;
use App\Http\Concerns\HasWalasAuth;

class DenahKerjaKelompokSiswaController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $kelompok = DenahTempatKerjaKelompok::where('walas_id', $walas->id)->get();
        $kelompokSiswa = KelompokSiswa::whereIn('kelompok_id', $kelompok->pluck('id'))->get();
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        $data = $kelompok->map(function ($item) use ($kelompokSiswa) {
            $siswas = $kelompokSiswa->where('kelompok_id', $item->id)->map(function ($kelompokSiswa) {
                return \App\Models\Siswa::find($kelompokSiswa->siswa_id);
            });

            return [
                'id' => $item->id,
                'nama_kelompok' => $item->nama_kelompok,
                'siswas' => $siswas,
            ];
        })->toArray();

        return view('admwalas.denahtempatkerjakelompok.index', compact('walas', 'data', 'siswas', 'rombel'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        if ($siswas->isEmpty()) {
            $dataSiswa = 'Tidak ada siswa di kelompok ini';
        } else {
            $dataSiswa = $siswas;
        }

        $kelompok = DenahTempatKerjaKelompok::select('nama_kelompok')
            ->where('walas_id', $walas->id)
            ->distinct()
            ->get();

        if ($kelompok->isEmpty()) {
            $data = [
                ['nama_kelompok' => 'Kelompok 1', 'siswas' => '0'],
                ['nama_kelompok' => 'Kelompok 2', 'siswas' => '0'],
                ['nama_kelompok' => 'Kelompok 3', 'siswas' => '0'],
                ['nama_kelompok' => 'Kelompok 4', 'siswas' => '0'],
                ['nama_kelompok' => 'Kelompok 5', 'siswas' => '0'],
                ['nama_kelompok' => 'Kelompok 6', 'siswas' => '0'],
            ];
        } else {
            $data = $kelompok->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_kelompok' => $item->nama_kelompok,
                    'siswas' => $item->siswas_id,
                ];
            })->toArray();
        }

        $kelompok = DenahTempatKerjaKelompok::where('walas_id', $walas->id)->with('siswas')->get();

        return view('admwalas.denahtempatkerjakelompok.create', compact('walas', 'kelompok', 'dataSiswa', 'siswas', 'data'));
    }

    public function store(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();

        $validatedData = $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'nullable',
        ]);

        $kelompok = DenahTempatKerjaKelompok::create([
            'nama_kelompok' => $validatedData['nama_kelompok'],
            'walas_id' => $validatedData['walas_id'],
        ]);

        if (! empty($validatedData['siswas_id'])) {
            $kelompok->siswas()->attach($validatedData['siswas_id']);
        }

        return redirect()->route('denahkerjakelompok.index')->with('success', 'Kelompok berhasil dibuat!');
    }

    public function showSiswa($kelompokId)
    {
        $kelompok = DenahTempatKerjaKelompok::find($kelompokId);
        $siswas = Siswa::whereDoesntHave('kelompok', function ($query) use ($kelompokId) {
            $query->where('kelompok_id', $kelompokId);
        })->get();

        return view('/createkelompok', compact('kelompok', 'siswas'));
    }

    public function addSiswa(Request $request, $id)
    {
        $kelompok = DenahTempatKerjaKelompok::findOrFail($id);

        if ($kelompok->siswas->count() >= 7) {
            return redirect()->back()->with('error', 'Maksimal 7 siswa per kelompok.');
        }

        $kelompok->siswas()->attach($request->siswas_id);

        return redirect('/denahkerjakelompok')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function simpan(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();

        $request->validate([
            'kelompok_id' => 'required|exists:denah_tempat_kerja_kelompoks,id',
            'siswas_id' => 'required|exists:siswas,id',
        ]);

        $existingSiswa = KelompokSiswa::where('kelompok_id', $request->kelompok_id)
            ->where('siswa_id', $request->siswas_id)
            ->exists();

        if ($existingSiswa) {
            return redirect()->back()->with('error', 'Siswa sudah ada dalam kelompok ini.');
        }

        KelompokSiswa::create([
            'kelompok_id' => $request->kelompok_id,
            'siswa_id' => $request->siswas_id,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke kelompok.');
    }

    public function edit(string $id) {}

    public function update(Request $request, $id)
    {
        $kelompokSiswa = KelompokSiswa::find($id);

        if ($kelompokSiswa) {
            $kelompokSiswa->siswas_id = $request->siswas_id;
            $kelompokSiswa->save();

            return redirect('/denahkerjakelompok')->with('success', 'Siswa berhasil diupdate');
        }

        return redirect('/denahkerjakelompok')->with('error', 'Siswa tidak ditemukan');
    }

    public function hapussiswadata(string $siswa_id)
    {
        $siswa = KelompokSiswa::where('siswa_id', $siswa_id)->first();

        if ($siswa) {
            $siswa->delete();

            return redirect('/denahkerjakelompok')->with('success', 'Siswa Berhasil Dihapus');
        }

        return redirect('/denahkerjakelompok')->with('error', 'Siswa tidak ditemukan!');
    }
}

