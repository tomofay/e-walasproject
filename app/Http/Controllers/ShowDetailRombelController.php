<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Walas;
use App\Models\KeluarRombel;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Imports\RombelImport;
use Maatwebsite\Excel\Facades\Excel;

class ShowDetailRombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showDetail($rombel_id)
    {
        // Ambil data rombel berdasarkan rombel_id
        $rombel = Rombel::where('id', $rombel_id)->with('walas')->first();
    
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }
    
        // Ambil data siswa berdasarkan rombel_id
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
    
        // Ambil wali kelas berdasarkan relasi di model Rombel
        $walas = $rombel->walas;
    
        // Ambil semua data rombels
        $rombels = Rombel::with('walas')->get();
    
        // Ambil nama_kompetensi dari rombel yang dipilih
        $kompetensi = $rombel->kompetensi;
    
        $siswa_tidak_naik_ids = KeluarRombel::whereHas('rombel', function($query) use ($kompetensi) {
            $query->where('kompetensi', $kompetensi);
        })->pluck('nama_siswa');
    
        // Mengambil objek Siswa lengkap, bukan hanya nama
        $siswa_tidak_naik = Siswa::whereIn('id', $siswa_tidak_naik_ids)->get();
    
        return view('homepageadmin.siswadata.datarombel', compact('siswas', 'rombel', 'rombels', 'walas', 'siswa_tidak_naik_ids', 'siswa_tidak_naik'));
    }
    

    public function importsiswaadmin(Request $request){
        Excel::import(new SiswaImport, $request->file('file'));
        return back();
    }

    public function downloadTemplateAdmin()
    {
        $pathToFile = storage_path('app/public/template_siswa.xlsx'); // Sesuaikan dengan lokasi file template Excel
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
