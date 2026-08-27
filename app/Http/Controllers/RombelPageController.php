<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Walas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Imports\RombelImport;
use Maatwebsite\Excel\Facades\Excel;

class RombelPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data dari tabel walas
        $walas = DB::table('walas')->select('id', 'nama')->get();

        // Mengirim data ke view
        return view('homepageadmin.rombeldata.index', [
            'vwrombels' => DB::table('vwrombels')->get(),
            'walas' => $walas // Kirim data wali kelas ke view
        ]);
    }

    public function naikKelas()
    {
        DB::transaction(function () {
            $rombels = DB::table('rombels')->get();

            // Hapus semua siswa dengan keterangan 'tidak_naik_kelas' sebelum naik kelas
            DB::table('siswas')->where('keterangan', 'tidak_naik_kelas')->delete();
            Log::info("Siswa dengan keterangan 'tidak_naik_kelas' telah dihapus.");

            foreach ($rombels as $rombel) {
                $currentRombelId = $rombel->id;
                $walas_id = $rombel->walas_id;
                $currentTingkat = $rombel->tingkat;
                $kompetensi = $rombel->kompetensi;
                $nama_kelas = $rombel->nama_kelas;

                // Tentukan tingkat baru
                if ($currentTingkat === 'X') {
                    $newTingkat = 'XI';
                } elseif ($currentTingkat === 'XI') {
                    $newTingkat = 'XII';
                } else {
                    continue; // XII dan XIII tidak naik
                }

                // Bangun nama kelas baru berdasarkan pola "Tingkat Kompetensi N"
                $suffix = preg_replace('/^[^\s]+\s*/', '', $nama_kelas);
                $new_kelas = $newTingkat . ' ' . $suffix;

                // Cek apakah rombel baru sudah ada
                $rombels_baru = DB::table('rombels')->where('nama_kelas', $new_kelas)->first();

                // Jika belum ada, buat otomatis
                if (!$rombels_baru) {
                    $rombels_baru_id = DB::table('rombels')->insertGetId([
                        'tingkat' => $newTingkat,
                        'kompetensi' => $kompetensi,
                        'nama_kelas' => $new_kelas,
                        'walas_id' => $walas_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    Log::info("Rombel baru $new_kelas dibuat dengan walas ID: $walas_id.");
                } else {
                    $rombels_baru_id = $rombels_baru->id;
                }

                // Update data siswa ke rombel baru
                DB::table('siswas')->where('rombels_id', $currentRombelId)
                    ->update([
                        'rombels_id' => $rombels_baru_id,
                        'keterangan' => 'naik_kelas',
                    ]);
            }

            // Nonaktifkan siswa kelas XIII (sudah lulus)
            DB::table('siswas')->whereIn('rombels_id', function ($query) {
                $query->select('id')->from('rombels')->where('tingkat', 'XIII');
            })->update(['status' => 'nonaktif']);

            Log::info("Siswa kelas XIII yang sudah lulus telah dinonaktifkan.");
        });
    }

public function import(Request $request){
    if (! $request->hasFile('file')) {
        return back()->with('error', 'File tidak ditemukan.');
    }
    Excel::import(new RombelImport, $request->file('file'));
return redirect('/rombel');
}

public function downloadTemplate()
{
    $pathToFile = storage_path('app/public/template_rombel.xlsx'); // Sesuaikan dengan lokasi file template Excel
        if (!file_exists($pathToFile)) {
            return back()->with('error', 'Template belum tersedia.');
        }
        return response()->download($pathToFile);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tingkat' => 'required',
            'kompetensi' => 'required',
            'nama_kelas' => 'required',
            'walas_id' => 'required|exists:walas,id',
        ]);
    
        // Simpan data ke tabel rombels
        Rombel::create([
            'tingkat' => $request->tingkat,
            'kompetensi' => $request->kompetensi,
            'nama_kelas' => $request->nama_kelas,
            'walas_id' => $request->walas_id
        ]);
    
        // Redirect kembali dengan data terbaru
        return redirect()->back()->with([
            'success' => 'Data Rombel berhasil ditambahkan!',
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data rombel berdasarkan ID
        $rombel = Rombel::findOrFail($id);
        // Cek jika data walas ada
        $walas = Walas::all();
    
        if (!$walas) {
            // Jika data walas tidak ditemukan, kembalikan dengan error
            return redirect()->back()->with('error', 'Wali Kelas tidak ditemukan!');
        }
    
        // Kirim data ke view edit
        return view('homepageadmin.rombeldata.edit', compact('rombel', 'walas'));
    }
    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tingkat' => 'required',
            'kompetensi' => 'required',
            'nama_kelas' => 'required',
            'walas_id' => 'required',
        ]);
    
        $rombel = Rombel::findOrFail($id);
        $rombel->update($validated);
    
         // Redirect kembali dengan data terbaru
         return redirect('/rombel')->with('success', 'Data Rombel Berhasil di Edit');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function rombel_search(Request $request)
{
    $search_text = $request->keyword;
    $keywords = explode(' ', $search_text); 

    // Query untuk data vwrombels (table view)
    $vwrombels = DB::table('vwrombels');
    
    foreach ($keywords as $keyword) {
        $vwrombels->where('tingkat', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('kompetensi', 'LIKE', '%' . $keyword . '%');
    }
    
    $vwrombels = $vwrombels->get(); // Ambil data hasil pencarian

    // Ambil data wali kelas (misalnya dari tabel wali_kelas)
    $walas = Walas::all(); // Sesuaikan dengan model dan tabel yang benar

    // Kirim data ke view
    return view('homepageadmin.rombeldata.index', compact('vwrombels', 'walas'));
}

public function hapusrombel(string $id)
    {
        $rombel = Rombel::find($id);
        if ($rombel) {
            $rombel->delete();
            return redirect('/rombel')->with('success', 'Rombel data Berhasil Dihapus ');
        }
        return redirect('/rombel')->with('error', 'Rombel not found!');
    }

}
