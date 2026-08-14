<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use App\Http\Concerns\ConvertsImagesToBase64;
use Illuminate\Http\Request;
use App\Models\PrestasiSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PrestasiSiswaController extends Controller
{
    use HasWalasAuth;
    use ConvertsImagesToBase64;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $prestasisiswa = PrestasiSiswa::where('walas_id', $walas->id)->get();

        return view('admwalas.prestasisiswa.index', compact('walas', 'prestasisiswa', 'siswas'));
    }

    public function generatePDF(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $prestasisiswa = PrestasiSiswa::where('walas_id', $walas->id)->get();

        $sertifImage = $request->input('sertifImage');
        $dokumImage = $request->input('dokumImage');

        foreach ($prestasisiswa as $item) {
            $item->sertifikat_base64 = $this->convertToBase64($item->sertifikat_url);
            $item->dokumentasi_base64 = $this->convertToBase64($item->dokumentasi_url);
        }

        $pdf = Pdf::loadView('pdf.prestasisiswa', compact('walas', 'prestasisiswa', 'siswas', 'rombel', 'sertifImage', 'dokumImage'));

        return $pdf->stream('Prestasi_Siswa.pdf');
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.prestasisiswa.create', compact('walas', 'siswas', 'rombel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'required|exists:siswas,id',
            'rombels_id' => 'required',
            'jenis_prestasi' => 'required',
            'nama_prestasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'sertifikat_url' => 'nullable',
            'dokumentasi_url' => 'nullable',
        ]);

        $sertifikatPath = $request->hasFile('sertifikat_url')
            ? $request->file('sertifikat_url')->store('prestasisiswa/Photos', 'public')
            : null;

        $dokumentasiPath = $request->hasFile('dokumentasi_url')
            ? $request->file('dokumentasi_url')->store('prestasisiswa/Photos', 'public')
            : null;

        PrestasiSiswa::create([
            'walas_id' => $request->walas_id,
            'siswas_id' => $request->siswas_id,
            'rombels_id' => $request->rombels_id,
            'jenis_prestasi' => $request->jenis_prestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'tanggal' => $request->tanggal,
            'sertifikat_url' => $sertifikatPath,
            'dokumentasi_url' => $dokumentasiPath,
        ]);

        return redirect('/prestasisiswa')->with('success', 'Data berhasil disimpan.');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $prestasisiswa = PrestasiSiswa::findOrFail($id);

        return view('admwalas.prestasisiswa.edit', compact('walas', 'rombel', 'prestasisiswa', 'siswas'));
    }

    public function update(Request $request, $id)
    {
        $prestasisiswa = PrestasiSiswa::findOrFail($id);

        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'required|exists:siswas,id',
            'rombels_id' => 'required',
            'jenis_prestasi' => 'required',
            'nama_prestasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'sertifikat_url' => 'nullable',
            'dokumentasi_url' => 'nullable',
        ]);

        if ($request->hasFile('sertifikat_url')) {
            if ($prestasisiswa->sertifikat_url && Storage::exists('public/' . $prestasisiswa->sertifikat_url)) {
                Storage::delete('public/' . $prestasisiswa->sertifikat_url);
            }
            $sertifikatPath = $request->file('sertifikat_url')->store('prestasisiswa/Photos', 'public');
        } else {
            $sertifikatPath = $prestasisiswa->sertifikat_url;
        }

        if ($request->hasFile('dokumentasi_url')) {
            if ($prestasisiswa->dokumentasi_url && Storage::exists('public/' . $prestasisiswa->dokumentasi_url)) {
                Storage::delete('public/' . $prestasisiswa->dokumentasi_url);
            }
            $dokumentasiPath = $request->file('dokumentasi_url')->store('prestasisiswa/Photos', 'public');
        } else {
            $dokumentasiPath = $prestasisiswa->dokumentasi_url;
        }

        $prestasisiswa->update([
            'walas_id' => $request->walas_id,
            'siswas_id' => $request->siswas_id,
            'rombels_id' => $request->rombels_id,
            'jenis_prestasi' => $request->jenis_prestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'tanggal' => $request->tanggal,
            'sertifikat_url' => $sertifikatPath,
            'dokumentasi_url' => $dokumentasiPath,
        ]);

        return redirect('/prestasisiswa')->with('success', 'Data berhasil diperbarui.');
    }

    public function hapusprestasisiswa(string $id)
    {
        $prestasisiswa = PrestasiSiswa::find($id);

        if ($prestasisiswa) {
            $prestasisiswa->delete();

            return redirect('/prestasisiswa')->with('success', 'Data Prestasi Siswa Berhasil Dihapus ');
        }

        return redirect('/prestasisiswa')->with('error', 'Data Prestasi Siswa not found!');
    }
}
