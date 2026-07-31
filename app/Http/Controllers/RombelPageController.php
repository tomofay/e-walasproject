<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Walas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
            $updatedStudents = [];
            $rombels = DB::table('rombels')->get();

            // Hapus semua siswa dengan keterangan 'tidak_naik_kelas' sebelum naik kelas
            DB::table('siswas')->where('keterangan', 'tidak_naik_kelas')->delete();
            dump("Siswa dengan keterangan 'tidak_naik_kelas' telah dihapus.");

            foreach ($rombels as $rombel) {
                $currentRombelId = $rombel->id;
                $currentNamaKelas = $rombel->nama_kelas;
                $walas_id = $rombel->walas_id; // Ambil walas dari rombel lama

                // Ambil tingkat kelas dari nama_kelas (misal: X RPL 1 → X)
                $kelas_split = explode(' ', $currentNamaKelas, 2);
                $currentTingkat = $kelas_split[0] ?? ''; // X, XI, XII
                $kompetensi = $kelas_split[1] ?? ''; // RPL 1, TKJ 2, SIJA 3

                // Tentukan kelas baru
                if ($currentTingkat === 'X') {
                    $new_kelas = 'XI ' . $kompetensi;
                } elseif ($currentTingkat === 'XI') {
                    $new_kelas = 'XII ' . $kompetensi;
                } else {
                    continue; // Jika XII, biarkan saja (tidak naik)
                }

                // Cek apakah rombel baru sudah ada
                $rombels_baru = DB::table('rombels')->where('nama_kelas', $new_kelas)->first();

                // Jika belum ada, buat otomatis
                if (!$rombels_baru) {
                    $rombels_baru_id = DB::table('rombels')->insertGetId([
                        'nama_kelas' => $new_kelas,
                        'walas_id' => $walas_id, // Pakai walas yang sama dari rombel lama
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    dump("Rombel baru $new_kelas dibuat dengan walas ID: $walas_id.");
                } else {
                    $rombels_baru_id = $rombels_baru->id;
                }

                dump("Pindahkan siswa dari $currentNamaKelas ke $new_kelas");

                // Update data siswa ke rombel baru
                DB::table('siswas')->where('rombels_id', $currentRombelId)
                    ->update([
                        'rombels_id' => $rombels_baru_id,
                        'keterangan' => 'naik_kelas'
                    ]);

                // 🛠 **Perbaiki Kompetensi yang Acak-acakan**
                if (Schema::hasColumn('kompetensi', 'rombels_id')) {
                    DB::table('kompetensi')->where('rombels_id', $currentRombelId)
                        ->update(['rombels_id' => $rombels_baru_id]);

                    dump("Kompetensi dari $currentNamaKelas tetap di $new_kelas.");
                }

                $updatedStudents[] = [
                    'dari_kelas' => $currentNamaKelas,
                    'ke_kelas' => $new_kelas
                ];
            }

            // Nonaktifkan siswa kelas XIII (sudah lulus)
            DB::table('siswas')->whereIn('rombels_id', function ($query) {
                $query->select('id')->from('rombels')->where('nama_kelas', 'like', 'XIII%');
            })->update(['status' => 'aktif']);

            dump("Siswa kelas XIII yang sudah lulus telah dinonaktifkan.");
        });
    }

public function import(Request $request){
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
