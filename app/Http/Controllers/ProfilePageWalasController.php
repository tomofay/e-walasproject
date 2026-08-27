<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfilePageWalasController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswa = DB::table('vwsiswas')
            ->where('id', $rombel->id)
            ->get();

        $rombels = Rombel::all();

        return view('profilewalas.index', compact('walas', 'rombel', 'siswa', 'rombels'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}

    public function edit(string $id)
    {
        $this->getAuthenticatedWalas();

        $walas = Walas::findOrFail($id);

        return view('profilewalas.edit', compact('walas'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'image_url' => 'nullable|image|max:5000',
            'no_wa' => 'required|numeric',
            'password' => 'nullable|string|min:8',
            'nip' => 'required|numeric',
        ]);

        $walas = Walas::findOrFail($id);

        if ($request->hasFile('image_url')) {
            if ($walas->image_url) {
                Storage::delete('public/' . $walas->image_url);
            }

            $walas->image_url = $request->file('image_url')->store('walasfoto/Photos', 'public');
        }

        $walas->nama = $request->nama;
        $walas->no_wa = $request->no_wa;
        $walas->nip = $request->nip;

        if ($request->filled('password')) {
            $walas->password = Hash::make($request->password);
        }

        $walas->save();

        return redirect('/profilewalas')->with('success', 'Data Walas Berhasil di Edit');
    }

    public function destroy(string $id) {}
}
