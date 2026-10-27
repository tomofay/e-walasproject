<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use App\Models\LembarPengesahan;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LembarPengesahanController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $lembarpengesahan = LembarPengesahan::where('walas_id', $walas->id)->get();

        return view("admwalas.lembarpengesahan.index", compact('lembarpengesahan', 'walas', 'rombel'));
    }

    public function downloadTemplate()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        return Pdf::loadView('pdf.template-lembar-pengesahan', compact('walas', 'rombel'))
            ->setPaper('a4')
            ->download('Lembar_Pengesahan_Wali_Kelas.pdf');
    }

    public function create()
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $walasList = Walas::all();
        $lembarpengesahan = LembarPengesahan::all();

        return view('admwalas.lembarpengesahan.create', compact('lembarpengesahan', 'walasList', 'walaslogin', 'rombel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'image_url' => 'required|mimes:jpeg,png,jpg,gif,pdf,jfif|max:1024',
        ]);

        $filePath = $request->hasFile('image_url')
            ? $request->file('image_url')->store('images/photos', 'public')
            : null;

        LembarPengesahan::create([
            'walas_id' => $request->walas_id,
            'image_url' => $filePath,
        ]);

        return redirect()->route('lembarpengesahan.index')->with('success', 'Data berhasil disimpan!');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $lembarpengesahan = LembarPengesahan::findOrFail($id);
        $walasList = Walas::all();

        return view('admwalas.lembarpengesahan.edit', compact('lembarpengesahan', 'walasList', 'walaslogin', 'rombel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'image_url' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:1024',
        ]);

        $lembarpengesahan = LembarPengesahan::findOrFail($id);

        if ($request->hasFile('image_url')) {
            if ($lembarpengesahan->image_url && Storage::disk('public')->exists($lembarpengesahan->image_url)) {
                Storage::disk('public')->delete($lembarpengesahan->image_url);
            }

            $lembarpengesahan->image_url = $request->file('image_url')->store('images/photos', 'public');
        }

        $lembarpengesahan->walas_id = $request->walas_id;
        $lembarpengesahan->save();

        return redirect()->route('lembarpengesahan.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(string $id) {}
}
