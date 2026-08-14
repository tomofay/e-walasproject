<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use App\Models\DaftarSerahTerimaRapor;
use Illuminate\Support\Facades\Storage;

class DaftarPenyerahanRapotController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();

        $penyerahanrapot = DaftarSerahTerimaRapor::where('walas_id', $walas->id)->get();

        return view("admwalas.daftarpenyerahanrapot.index", compact('penyerahanrapot', 'walas'));
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/Penyerahan Pengembalian Rapor.pdf');

        if (! file_exists($pathToFile)) {
            return back()->with('error', 'Template belum tersedia.');
        }

        return response()->download($pathToFile);
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $penyerahanrapot = DaftarSerahTerimaRapor::all();

        return view('admwalas.daftarpenyerahanrapot.create', compact('penyerahanrapot', 'walas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'image_url' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        $filePath = $request->hasFile('image_url')
            ? $request->file('image_url')->store('penyerahanrapot/Photos', 'public')
            : null;

        DaftarSerahTerimaRapor::create([
            'walas_id' => $request->walas_id,
            'image_url' => $filePath,
        ]);

        return redirect('/serahterimarapor')->with('success', 'Data berhasil disimpan!');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walas = $this->getAuthenticatedWalas();
        $penyerahanrapot = DaftarSerahTerimaRapor::findOrFail($id);

        return view('admwalas.daftarpenyerahanrapot.edit', compact('penyerahanrapot', 'walas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'image_url' => 'nullable|mimes:jpeg,png,jpg,gif,pdf,docx|max:2048',
        ]);

        $penyerahanrapot = DaftarSerahTerimaRapor::findOrFail($id);

        if ($request->hasFile('image_url')) {
            if ($penyerahanrapot->image_url && Storage::disk('public')->exists($penyerahanrapot->image_url)) {
                Storage::disk('public')->delete($penyerahanrapot->image_url);
            }

            $penyerahanrapot->image_url = $request->file('image_url')->store('penyerahanrapot/photos', 'public');
        }

        $penyerahanrapot->walas_id = $request->walas_id;
        $penyerahanrapot->save();

        return redirect('/serahterimarapor')->with('success', 'Data berhasil diperbarui!');
    }

    public function hapuspenyerahanrapot(string $id)
    {
        $penyerahanrapot = DaftarSerahTerimaRapor::find($id);

        if ($penyerahanrapot) {
            $penyerahanrapot->delete();

            return redirect('/serahterimarapor')->with('success', 'Data Berhasil Dihapus ');
        }

        return redirect('/serahterimarapor')->with('error', 'Data not found!');
    }
}
