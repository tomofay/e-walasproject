<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Presensi;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PresensiController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();

        $semester = request()->get('semester');

        $presensis = Presensi::where('walas_id', $walas->id)
            ->when($semester === 'ganjil', function ($query) {
                return $query->whereMonth('tanggal', '>=', 7)->whereMonth('tanggal', '<=', 12);
            })
            ->when($semester === 'genap', function ($query) {
                return $query->whereMonth('tanggal', '>=', 1)->whereMonth('tanggal', '<=', 6);
            })
            ->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.rekapkehadiran', compact('walas', 'presensis', 'semester'))
                ->setPaper('A4', 'landscape');

            return $pdf->stream('rekap_kehadiran_' . $semester . '.pdf');
        }

        $presensi = Presensi::where('walas_id', $walas->id)->get();

        return view('admwalas.presensi.index', compact('presensis', 'walas', 'presensi'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();

        return view('admwalas.presensi.create', compact('walas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'kelas' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        Presensi::create($request->all());

        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil ditambahkan!');
    }

    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
