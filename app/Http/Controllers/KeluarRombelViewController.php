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
use App\Models\KeluarRombel;
use Illuminate\Support\Facades\Auth;
use App\Http\Concerns\BuildsKeluarRombelPeriods;

class KeluarRombelViewController extends Controller
{
    use BuildsKeluarRombelPeriods;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $admin = Auth::guard('admins')->user();  // ini akan mendapatkan data siswa yang sedang login
       
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('admin_id')) {
            return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
        }
   
        // Ambil data berdasarkan 'id' yang ada di session
        $admin = Admin::find(session('admin_id'));
        
        // Periksa apakah data siswa ditemukan
        if (!$admin) {
            return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
        }

        $periodQuery = KeluarRombel::query();
        $periods = $this->availableAcademicPeriods(clone $periodQuery);
        $selectedPeriod = $this->selectedAcademicPeriod($request);
        $kelasGroup = collect();

        if ($selectedPeriod) {
            $kelasGroup = $this->groupKeluarRombelByClass(
                $this->recordsForAcademicPeriod(clone $periodQuery, $selectedPeriod)
            );
        }

        return view('homepageadmin.keluarrombel.index', compact('admin', 'periods', 'selectedPeriod', 'kelasGroup'));
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
    public function show(string $id, Request $request)
    {
        $keluarrombel = KeluarRombel::findOrFail($id);

        return $this->showSiswaKeluarRombel((string) $keluarrombel->rombels_id, $request);
    }

    public function showSiswaKeluarRombel(string $id, Request $request)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $admin = Auth::guard('admins')->user();  // ini akan mendapatkan data siswa yang sedang login
       
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('admin_id')) {
            return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
        }
   
        // Ambil data berdasarkan 'id' yang ada di session
        $admin = Admin::find(session('admin_id'));
        
        // Periksa apakah data siswa ditemukan
        if (!$admin) {
            return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
        }

        $selectedPeriod = $this->selectedAcademicPeriod($request);
        $query = KeluarRombel::query()->where('rombels_id', $id);
        if ($selectedPeriod) {
            $query = $this->recordsForAcademicPeriod($query, $selectedPeriod);
        }
        $kelasGroup = $this->groupKeluarRombelByClass($query);

        return view('homepageadmin.keluarrombel.show', compact('admin', 'kelasGroup', 'selectedPeriod'));
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
