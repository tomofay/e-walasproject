<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Rombel;
use App\Models\Walas;
use App\Models\Admin;
use App\Models\Kepsek;
use App\Models\Kurikulum;
use App\Models\Kakom;
use App\Models\KeluarRombel;
use Illuminate\Support\Facades\Auth;
use App\Http\Concerns\BuildsKeluarRombelPeriods;

class KeluarRombelViewKakomController extends Controller
{
    use BuildsKeluarRombelPeriods;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkakom')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom yang sedang login
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkakom')->with('error', 'Data kakom tidak ditemukan.');
        }

        // Ambil kompetensi dari kakom yang login
        $kompetensi = $kakom->kompetensi;

        // Ambil ID rombels yang memiliki kompetensi yang sama dengan kakom
        $rombelIds = Rombel::where('kompetensi', $kompetensi)->pluck('id');

        // Batasi periode dan data hanya pada kompetensi yang diampu Kakom.
        $periodQuery = KeluarRombel::whereHas('siswa', function ($query) use ($rombelIds) {
            $query->whereIn('rombels_id', $rombelIds);
        });
        $periods = $this->availableAcademicPeriods(clone $periodQuery);
        $selectedPeriod = $this->selectedAcademicPeriod($request);
        $kelasGroup = collect();

        if ($selectedPeriod) {
            $kelasGroup = $this->groupKeluarRombelByClass(
                $this->recordsForAcademicPeriod(clone $periodQuery, $selectedPeriod)
            );
        }

        return view('homepagekaprog.keluarrombel.index', compact('kakom', 'periods', 'selectedPeriod', 'kelasGroup'));
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
    public function showSiswaKeluarRombelKakom(string $id, Request $request)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data siswa yang sedang login
       
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkakom')->with('error', 'Silakan login terlebih dahulu.');
        }
   
        // Ambil data berdasarkan 'id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));
        
        // Periksa apakah data siswa ditemukan
        if (!$kakom) {
            return redirect('/loginkakom')->with('error', 'Data kakom tidak ditemukan.');
        }

        $rombelIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('id');
        abort_unless($rombelIds->contains((int) $id), 404);

        $selectedPeriod = $this->selectedAcademicPeriod($request);
        $query = KeluarRombel::query()->where('rombels_id', $id);
        if ($selectedPeriod) {
            $query = $this->recordsForAcademicPeriod($query, $selectedPeriod);
        }
        $kelasGroup = $this->groupKeluarRombelByClass($query);

        return view('homepagekaprog.keluarrombel.show', compact('kakom', 'kelasGroup', 'selectedPeriod'));
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
