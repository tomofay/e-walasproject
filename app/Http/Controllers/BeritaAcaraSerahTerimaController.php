<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use App\Models\BeritaAcaraSerahTerima;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BeritaAcaraSerahTerimaController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $beritaacaraserahterima = BeritaAcaraSerahTerima::where('walas_id', $walas->id)->get();

        return view("admwalas.beritaacaraserahterima.index", compact('beritaacaraserahterima', 'walas', 'rombel'));
    }

    public function downloadTemplate()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        return Pdf::loadView('pdf.template-berita-acara-serah-terima', compact('walas', 'rombel'))
            ->setPaper('a4')
            ->download('Berita_Acara_Serah_Terima.pdf');
    }

    public function create()
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $walas = Walas::all();
        $beritaacaraserahterima = BeritaAcaraSerahTerima::all();

        return view('admwalas.beritaacaraserahterima.create', compact('beritaacaraserahterima', 'walas', 'walaslogin', 'rombel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'image_url' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        $filePath = $request->hasFile('image_url')
            ? $request->file('image_url')->store('images/photos', 'public')
            : null;

        BeritaAcaraSerahTerima::create([
            'walas_id' => $request->walas_id,
            'image_url' => $filePath,
        ]);

        return redirect()->route('beritaacaraserahterima.index')->with('success', 'Data berhasil disimpan!');
    }

    public function show(string $id) {}

    public function edit($id)
    {
        $walaslogin = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $beritaacaraserahterima = BeritaAcaraSerahTerima::findOrFail($id);
        $walas = Walas::all();

        return view('admwalas.beritaacaraserahterima.edit', compact('beritaacaraserahterima', 'walas', 'walaslogin', 'rombel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'image_url' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        $beritaacaraserahterima = BeritaAcaraSerahTerima::findOrFail($id);

        if ($request->hasFile('image_url')) {
            if ($beritaacaraserahterima->image_url && Storage::disk('public')->exists($beritaacaraserahterima->image_url)) {
                Storage::disk('public')->delete($beritaacaraserahterima->image_url);
            }

            $beritaacaraserahterima->image_url = $request->file('image_url')->store('images/photos', 'public');
        }

        $beritaacaraserahterima->walas_id = $request->walas_id;
        $beritaacaraserahterima->save();

        return redirect()->route('beritaacaraserahterima.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(string $id) {}
}
