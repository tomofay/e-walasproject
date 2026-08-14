<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BeritaAcaraKenaikan;

class BeritaAcaraKenaikanController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();

        $beritaAcara = BeritaAcaraKenaikan::where('walas_id', $walas->id)->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.beritaacarakenaikan', compact('walas', 'beritaAcara'));

            return $pdf->stream('Berita_Acara.pdf');
        }

        return view('admwalas.beritaacarakenaikan.index', compact('beritaAcara', 'walas'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();

        $walasid = Walas::all();
        $rombels = Rombel::all();

        return view('admwalas.beritaacarakenaikan.create', compact('walasid', 'walas', 'rombels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'waktu_tanggal' => 'required|date',
            'tempat' => 'required|string|max:20',
            'jumlah_peserta_rapat' => 'required|string|max:5',
            'rombels_id' => 'required|exists:rombels,id',
            'kelas_baru' => 'required|string',
            'laki_laki_naik' => 'required|string|max:5',
            'perempuan_naik' => 'required|string|max:5',
            'laki_laki_tinggal' => 'required|string|max:5',
            'perempuan_tinggal' => 'required|string|max:5',
        ]);

        BeritaAcaraKenaikan::create($request->all());

        return redirect()->route('beritaacarakenaikan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walas = $this->getAuthenticatedWalas();

        $beritaAcara = BeritaAcaraKenaikan::findOrFail($id);
        $rombels = Rombel::all();

        return view('admwalas.beritaacarakenaikan.edit', compact('beritaAcara', 'walas', 'rombels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'waktu_tanggal' => 'required|date',
            'tempat' => 'required|string|max:20',
            'jumlah_peserta_rapat' => 'required|string|max:5',
            'rombels_id' => 'required|exists:rombels,id',
            'kelas_baru' => 'required|string',
            'laki_laki_naik' => 'required|string|max:5',
            'perempuan_naik' => 'required|string|max:5',
            'laki_laki_tinggal' => 'required|string|max:5',
            'perempuan_tinggal' => 'required|string|max:5',
        ]);

        $beritaAcara = BeritaAcaraKenaikan::findOrFail($id);
        $beritaAcara->update($request->all());

        return redirect()->route('beritaacarakenaikan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id) {}
}
