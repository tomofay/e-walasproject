<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CatatanKasusSiswa;
use Illuminate\Support\Facades\Storage;

class CatatanKasusSiswaController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        $catatankasus = CatatanKasusSiswa::where('walas_id', $walas->id)
            ->with('siswa')
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu')
            ->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.catatankasus', compact('walas', 'rombel', 'siswas', 'catatankasus'));

            return $pdf->stream('Catatan_Kasus.pdf');
        }

        return view('admwalas.catatankasus.index', compact('walas', 'catatankasus', 'siswas'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.catatankasus.create', compact('walas', 'siswas', 'rombel'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'kasus' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_kasus' => 'nullable',
            'file_kasus.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $uploadedPaths = [];
        if ($request->hasFile('file_kasus')) {
            $files = $request->file('file_kasus');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $uploadedPaths[] = $file->store('catatankasus', 'public');
                }
            }
        }

        $validatedData['file_kasus'] = !empty($uploadedPaths) ? $uploadedPaths : null;

        CatatanKasusSiswa::create($validatedData);

        return redirect('/catatankasus')->with('success', 'Catatan kasus berhasil disimpan!');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $catatan = CatatanKasusSiswa::findOrFail($id);
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.catatankasus.edit', compact('walas', 'siswas', 'rombel', 'catatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswas_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'kasus' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_kasus' => 'nullable',
            'file_kasus.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $catatan = CatatanKasusSiswa::findOrFail($id);

        $currentFiles = is_array($catatan->file_kasus) ? $catatan->file_kasus : ($catatan->file_kasus ? [$catatan->file_kasus] : []);

        // If request originates from form with existing files list
        if ($request->has('form_has_files')) {
            $keepFiles = $request->input('keep_files', []);
            if (!is_array($keepFiles)) {
                $keepFiles = [];
            }
            // Delete removed files from disk
            foreach ($currentFiles as $file) {
                if (!in_array($file, $keepFiles)) {
                    if (Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $finalFiles = array_values(array_intersect($currentFiles, $keepFiles));
        } else {
            // For programmatic tests or requests without form_has_files:
            if ($request->hasFile('file_kasus')) {
                foreach ($currentFiles as $file) {
                    if (Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                    }
                }
                $finalFiles = [];
            } else {
                $finalFiles = $currentFiles;
            }
        }

        // Store new files if any
        if ($request->hasFile('file_kasus')) {
            $newFiles = $request->file('file_kasus');
            if (!is_array($newFiles)) {
                $newFiles = [$newFiles];
            }
            foreach ($newFiles as $file) {
                if ($file && $file->isValid()) {
                    $finalFiles[] = $file->store('catatankasus', 'public');
                }
            }
        }

        $updateData = [
            'walas_id' => $request->walas_id ?? $catatan->walas_id,
            'siswas_id' => $request->siswas_id,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'kasus' => $request->kasus,
            'tindak_lanjut' => $request->tindak_lanjut,
            'keterangan' => $request->keterangan,
            'file_kasus' => !empty($finalFiles) ? $finalFiles : null,
        ];

        $catatan->update($updateData);

        return redirect()->route('catatankasus.index')->with('success', 'Catatan kasus berhasil diupdate.');
    }

    public function hapuscatatankasus(string $id)
    {
        $catatankasus = CatatanKasusSiswa::find($id);

        if ($catatankasus) {
            $files = is_array($catatankasus->file_kasus) ? $catatankasus->file_kasus : ($catatankasus->file_kasus ? [$catatankasus->file_kasus] : []);
            foreach ($files as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
            $catatankasus->delete();

            return redirect('/catatankasus')->with('success', 'Catatan Kasus Siswa berhasil dihapus.');
        }

        return redirect('/catatankasus')->with('error', 'Catatan Kasus Siswa tidak ditemukan!');
    }
}
