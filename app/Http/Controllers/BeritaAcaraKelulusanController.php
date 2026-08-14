<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BeritaAcaraKelulusan;

class BeritaAcaraKelulusanController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();

        $beritaAcaraKelulusan = BeritaAcaraKelulusan::where('walas_id', $walas->id)->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.beritaacarakelulusan', compact('walas', 'beritaAcaraKelulusan'));

            return $pdf->stream('Berita_Acara.pdf');
        }

        return view('admwalas.beritaacarakelulusan.index', compact('beritaAcaraKelulusan', 'walas'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();

        $walasid = Walas::all();
        $rombels = Rombel::all();

        return view('admwalas.beritaacarakelulusan.create', compact('walasid', 'walas', 'rombels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'waktu_tanggal' => 'required|date',
            'tempat' => 'required|string|max:20',
            'jumlah_peserta_rapat' => 'required|string|max:5',
            'rombels_id' => 'required|exists:rombels,id',
            'laki_laki_lulus' => 'required|string|max:5',
            'perempuan_lulus' => 'required|string|max:5',
            'laki_laki_tidaklulus' => 'required|string|max:5',
            'perempuan_tidaklulus' => 'required|string|max:5',
        ]);

        BeritaAcaraKelulusan::create($request->all());

        return redirect()->route('beritaacarakelulusan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walas = $this->getAuthenticatedWalas();

        $beritaAcaraKelulusan = BeritaAcaraKelulusan::findOrFail($id);
        $rombels = Rombel::all();

        return view('admwalas.beritaacarakelulusan.edit', compact('beritaAcaraKelulusan', 'walas', 'rombels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'waktu_tanggal' => 'required|date',
            'tempat' => 'required|string|max:20',
            'jumlah_peserta_rapat' => 'required|string|max:5',
            'rombels_id' => 'required|exists:rombels,id',
            'laki_laki_lulus' => 'required|string|max:5',
            'perempuan_lulus' => 'required|string|max:5',
            'laki_laki_tidaklulus' => 'required|string|max:5',
            'perempuan_tidaklulus' => 'required|string|max:5',
        ]);

        $beritaAcaraKelulusan = BeritaAcaraKelulusan::findOrFail($id);
        $beritaAcaraKelulusan->update($request->all());

        return redirect()->route('beritaacarakelulusan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id) {}
}
