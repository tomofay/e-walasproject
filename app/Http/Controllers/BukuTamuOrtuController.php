<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use App\Http\Concerns\ConvertsImagesToBase64;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BukuTamuOrangtua;
use Illuminate\Support\Facades\Storage;

class BukuTamuOrtuController extends Controller
{
    use HasWalasAuth;
    use ConvertsImagesToBase64;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();

        $bukutamuortu = BukuTamuOrangtua::where('walas_id', $walas->id)->get();

        return view("admwalas.bukutamuortu.index", compact('bukutamuortu', 'walas'));
    }

    public function generatePDF(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $bukutamuortu = BukuTamuOrangtua::where('walas_id', $walas->id)->get();
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $dokumImage = $request->input('dokumImage');

        foreach ($bukutamuortu as $item) {
            $item->dokumentasi_base64 = $this->convertToBase64($item->dokumentasi_url);
        }

        $pdf = Pdf::loadView('pdf.bukutamuortu', compact('walas', 'bukutamuortu', 'siswas', 'rombel', 'dokumImage'));

        return $pdf->stream('Buku_Tamu_Ortu.pdf');
    }

    public function create()
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $bukutamuortu = BukuTamuOrangtua::all();
        $walas = Walas::all();

        return view('admwalas.bukutamuortu.create', compact('bukutamuortu', 'rombel', 'siswas', 'walas', 'walaslogin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'tanggal' => 'required|date',
            'nama_peserta_didik' => 'required|string|max:255',
            'nama_orang_tua' => 'required|string',
            'tindak_lanjut' => 'required|string',
            'kasus' => 'required|string',
            'solusi' => 'required|string',
            'dokumentasi_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $filePath = $request->hasFile('dokumentasi_url')
            ? $request->file('dokumentasi_url')->store('homevisit/Photos', 'public')
            : null;

        BukuTamuOrangtua::create([
            'walas_id' => $request->walas_id,
            'tanggal' => $request->tanggal,
            'nama_peserta_didik' => $request->nama_peserta_didik,
            'nama_orang_tua' => $request->nama_orang_tua,
            'tindak_lanjut' => $request->tindak_lanjut,
            'kasus' => $request->kasus,
            'solusi' => $request->solusi,
            'dokumentasi_url' => $filePath,
        ]);

        return redirect('/bukutamuortu')->with('success', 'Data berhasil disimpan!');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $bukutamuortu = BukuTamuOrangtua::findOrFail($id);
        $walas = Walas::select('id', 'nama')->orderBy('nama')->get();

        return view('admwalas.bukutamuortu.edit', compact('bukutamuortu', 'walas', 'walaslogin', 'siswas', 'rombel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'nama_peserta_didik' => 'required',
            'nama_orang_tua' => 'required',
            'tanggal' => 'required',
            'kasus' => 'required',
            'solusi' => 'required',
            'tindak_lanjut' => 'required',
            'dokumentasi_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $bukutamuortu = BukuTamuOrangtua::findOrFail($id);

        if ($request->hasFile('dokumentasi_url')) {
            if ($bukutamuortu->dokumentasi_url && Storage::exists('public/' . $bukutamuortu->dokumentasi_url)) {
                Storage::delete('public/' . $bukutamuortu->dokumentasi_url);
            }

            $dokumentasiPath = $request->file('dokumentasi_url')->store('bukutamu/Photos', 'public');
        } else {
            $dokumentasiPath = $bukutamuortu->dokumentasi_url;
        }

        $bukutamuortu->update([
            'walas_id' => $request->walas_id,
            'nama_peserta_didik' => $request->nama_peserta_didik,
            'nama_orang_tua' => $request->nama_orang_tua,
            'tanggal' => $request->tanggal,
            'kasus' => $request->kasus,
            'solusi' => $request->solusi,
            'tindak_lanjut' => $request->tindak_lanjut,
            'dokumentasi_url' => $dokumentasiPath,
        ]);

        return redirect('/bukutamuortu')->with('success', 'Data berhasil diperbarui!');
    }

    public function hapusbukutamuortu(string $id)
    {
        $bukutamuortu = BukuTamuOrangtua::find($id);

        if ($bukutamuortu) {
            $bukutamuortu->delete();

            return redirect('/bukutamuortu')->with('success', 'Data Berhasil Dihapus ');
        }

        return redirect('/bukutamuortu')->with('error', 'Data not found!');
    }
}
