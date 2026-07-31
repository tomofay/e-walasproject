<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\AgendaKegiatanWalas;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AgendaKegiatanWalasController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $agendawalas = AgendaKegiatanWalas::where('walas_id', $walas->id)->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.agendawalas', compact('walas', 'agendawalas'));
            return $pdf->stream('Agenda_Walas.pdf');
        }

        return view('admwalas.agendawalas.index', compact('walas', 'agendawalas'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $walasid = Walas::all();
        return view('admwalas.agendawalas.create', compact('walas', 'walasid'));
    }

    public function store(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();

        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required',
            'nama_kegiatan' => 'required',
            'hasil' => 'required',
            'waktu' => 'required',
            'keterangan' => 'required',
            'tanggalttd' => 'required',
            'ttdwalas_url' => 'nullable|image|max:5000',
        ]);

        $imagePath = $request->hasFile('ttdwalas_url')
            ? $request->file('ttdwalas_url')->store('ttdwalas/Photos', 'public')
            : null;

        AgendaKegiatanWalas::create([
            'walas_id' => $walas->id,
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'nama_kegiatan' => $request->nama_kegiatan,
            'hasil' => $request->hasil,
            'waktu' => $request->waktu,
            'keterangan' => $request->keterangan,
            'tanggalttd' => $request->tanggalttd,
            'ttdwalas_url' => $imagePath,
        ]);

        return redirect('/agendawalas')->with('success', 'Agenda Wali Kelas berhasil ditambahkan!');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walas = $this->getAuthenticatedWalas();
        $walasid = Walas::all();
        $agendawalas = AgendaKegiatanWalas::findOrFail($id);

        return view('admwalas.agendawalas.edit', compact('walas', 'walasid', 'agendawalas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required',
            'nama_kegiatan' => 'required',
            'hasil' => 'required',
            'waktu' => 'required',
            'keterangan' => 'required',
            'tanggalttd' => 'required',
            'ttdwalas_url' => 'nullable|image|max:5000',
        ]);

        $agendawalas = AgendaKegiatanWalas::findOrFail($id);

        if ($request->hasFile('ttdwalas_url')) {
            if ($agendawalas->ttdwalas_url) {
                Storage::delete('public/' . $agendawalas->ttdwalas_url);
            }
            $agendawalas->ttdwalas_url = $request->file('ttdwalas_url')->store('ttdwalas', 'public');
        }

        $agendawalas->fill($request->except('ttdwalas_url'));
        $agendawalas->save();

        return redirect()->route('agendawalas.index')->with('success', 'Agenda berhasil diupdate');
    }

    public function hapusagendawalas(string $id)
    {
        $agendawalas = AgendaKegiatanWalas::find($id);
        if ($agendawalas) {
            $agendawalas->delete();
            return redirect('/agendawalas')->with('success', 'Agenda Walas data Berhasil Dihapus');
        }
        return redirect('/agendawalas')->with('error', 'Agenda Walas not found!');
    }
}
