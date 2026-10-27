<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Kakom;
use App\Models\KeluarRombel;
use Illuminate\Support\Facades\Auth;
use App\Support\AcademicYear;

class KakomTAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login
    
       // Periksa apakah session 'kakom_id' ada
       if (!session()->has('kakom_id')) {
           return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
       }
 
       // Ambil data kurikulum berdasarkan 'kakom_id' yang ada di session
       $kakom = Kakom::find(session('kakom_id'));
       
       // Periksa apakah data kurikulum ditemukan
       if (!$kakom) {
           return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
       }

        // Ambil kompetensi dari kakom yang sedang login
        $kompetensi_kakom = $kakom->kompetensi;

        // Ambil semua rombel yang memiliki kompetensi yang sama dengan kompetensi kakom yang sedang login
        $kompetensi = Rombel::where('kompetensi', $kompetensi_kakom)->get();

        ['year' => $tahunAjaran, 'status' => $status] = AcademicYear::current();
        $keluarRombelPeriods = KeluarRombel::query()
            ->whereHas('siswa.rombel', fn ($query) => $query->where('kompetensi', $kakom->kompetensi))
            ->select(['academic_year', 'semester'])
            ->selectRaw('COUNT(*) as record_count')
            ->whereNotNull('academic_year')
            ->whereNotNull('semester')
            ->groupBy('academic_year', 'semester')
            ->orderByDesc('academic_year')
            ->orderBy('semester')
            ->get();
  

        return view ('homepagekaprog.tahunakademik', compact('kakom', 'kompetensi_kakom', 'kompetensi', 'tahunAjaran', 'status', 'keluarRombelPeriods'));
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
