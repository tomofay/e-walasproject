<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\HomeVisit;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeVisitController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $homevisit = HomeVisit::where('walas_id', $walas->id)->get();
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view("admwalas.homevisit.index", compact('homevisit', 'walas', 'siswas', 'rombel'));
    }

    public function generatePDF(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $homevisit = HomeVisit::where('walas_id', $walas->id)->get();
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        foreach ($homevisit as $item) {
            $item->bukti_base64 = $this->toBase64($item->bukti_url);
            $item->dokumentasi_base64 = $this->toBase64($item->dokumentasi_url);
        }

        $pdf = Pdf::loadView('pdf.homevisit', [
            'walas' => $walas,
            'homevisit' => $homevisit,
            'siswas' => $siswas,
            'rombel' => $rombel,
            'suratImage' => $request->input('suratImage'),
            'dokumImage' => $request->input('dokumImage'),
        ]);

        return $pdf->stream('Home_Visit.pdf');
    }

    private function toBase64($path)
    {
        $fullPath = storage_path("app/public/" . $path);
        if (file_exists($fullPath)) {
            return 'data:' . mime_content_type($fullPath) . ';base64,' . base64_encode(file_get_contents($fullPath));
        }
        return null;
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.homevisit.create', compact('walas', 'siswas'));
    }

    public function store(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();

        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'nama_peserta_didik' => 'required',
            'tanggal' => 'required',
            'kasus' => 'required',
            'solusi' => 'required',
            'tindak_lanjut' => 'required',
            'bukti_url' => 'required|image|max:2048',
            'dokumentasi_url' => 'required|image|max:1024',
        ]);

        $buktiPath = $request->file('bukti_url')->store('homevisit/Photos', 'public');
        $dokumentasiPath = $request->file('dokumentasi_url')->store('homevisit/Photos', 'public');

        HomeVisit::create([
            'walas_id' => $request->walas_id,
            'nama_peserta_didik' => $request->nama_peserta_didik,
            'tanggal' => $request->tanggal,
            'kasus' => $request->kasus,
            'solusi' => $request->solusi,
            'tindak_lanjut' => $request->tindak_lanjut,
            'bukti_url' => $buktiPath,
            'dokumentasi_url' => $dokumentasiPath,
        ]);

        return redirect('/homevisit')->with('success', 'Data berhasil disimpan!');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $homevisit = HomeVisit::findOrFail($id);
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.homevisit.edit', compact('homevisit', 'walas', 'siswas'));
    }

    public function update(Request $request, $id)
    {
        $walas = $this->getAuthenticatedWalas();

        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'nama_peserta_didik' => 'required',
            'tanggal' => 'required',
            'kasus' => 'required',
            'solusi' => 'required',
            'tindak_lanjut' => 'required',
            'bukti_url' => 'nullable|image|max:2048',
            'dokumentasi_url' => 'nullable|image|max:2048',
        ]);

        $homevisit = HomeVisit::findOrFail($id);

        if ($request->hasFile('bukti_url')) {
            if ($homevisit->bukti_url && Storage::exists('public/' . $homevisit->bukti_url)) {
                Storage::delete('public/' . $homevisit->bukti_url);
            }
            $buktiPath = $request->file('bukti_url')->store('homevisit/Photos', 'public');
        } else {
            $buktiPath = $homevisit->bukti_url;
        }

        if ($request->hasFile('dokumentasi_url')) {
            if ($homevisit->dokumentasi_url && Storage::exists('public/' . $homevisit->dokumentasi_url)) {
                Storage::delete('public/' . $homevisit->dokumentasi_url);
            }
            $dokumentasiPath = $request->file('dokumentasi_url')->store('homevisit/Photos', 'public');
        } else {
            $dokumentasiPath = $homevisit->dokumentasi_url;
        }

        $homevisit->update([
            'walas_id' => $request->walas_id,
            'nama_peserta_didik' => $request->nama_peserta_didik,
            'tanggal' => $request->tanggal,
            'kasus' => $request->kasus,
            'solusi' => $request->solusi,
            'tindak_lanjut' => $request->tindak_lanjut,
            'bukti_url' => $buktiPath,
            'dokumentasi_url' => $dokumentasiPath,
        ]);

        return redirect('/homevisit')->with('success', 'Data berhasil diperbarui!');
    }

    public function hapushomevisit(string $id)
    {
        $this->getAuthenticatedWalas();

        $homevisit = HomeVisit::find($id);
        if ($homevisit) {
            $homevisit->delete();
            return redirect('/homevisit')->with('success', 'Data Berhasil Dihapus');
        }
        return redirect('/homevisit')->with('error', 'Data not found!');
    }
}
