<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mapel;
use App\Exports\MapelExport;
use App\Imports\MapelImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class MapelPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapeldata = Mapel::all();
        return view('homepageadmin.mapeldata.index', compact('mapeldata'));
    }

    public function import(Request $request){
        Excel::import(new MapelImport, $request->file('file'));
    return redirect('/datamapel');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_mapel.xlsx'); // Sesuaikan dengan lokasi file template Excel
        if (!file_exists($pathToFile)) {
            return back()->with('error', 'Template belum tersedia.');
        }
        return response()->download($pathToFile);
    }

    public function export() 
    {
        return Excel::download(new MapelExport, 'mapel-'.Carbon::now()->timestamp.'.xlsx');
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
            'nama_mapel' => 'required|string|max:255',
        ]);
    
        // Simpan data ke database, termasuk path gambar
        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
        ]);
    
        /// Redirect kembali dengan data terbaru
        return redirect()->back()->with([
            'success' => 'Data Mata Pelajaran berhasil ditambahkan!',
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
    public function edit(string $id)
    {
        {
            // Ambil data produk berdasarkan ID
            $mapel = Mapel::findOrFail($id);
    
            // Kirim data ke view edit
            return view('homepageadmin.mapeldata.edit', compact('mapeldata'));
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
        ]);
    
        // Cari Wali Kelas berdasarkan ID
        $mapel = Mapel::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404
    
        // Update data Wali Kelas
        $mapel->nama_mapel = $request->nama_mapel;
    
        // Simpan perubahan ke database
        $mapel->save();
    
        // Redirect dengan pesan sukses
        return redirect('/datamapel')->with('success', 'Data Mata pelajaran Berhasil di Edit');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function hapusmapel(string $id)
    {
        $mapel = Mapel::find($id);
        if ($mapel) {
            $mapel->delete();
            return redirect('/datamapel')->with('success', 'Data Mata Pelajaran Berhasil Dihapus ');
        }
        return redirect('/datamapel')->with('error', 'Mapel not found!');
    }

    public function mapel_search(Request $request)
    {
        $search_text = $request->keyword;
        $keywords = explode(' ', $search_text); 
        $mapelQuery = Mapel::query();
    
        foreach ($keywords as $keyword) {
            $mapelQuery->where('nama_mapel', 'LIKE', '%' . $keyword . '%');
        }
    
        $mapeldata = $mapelQuery->get();
    
        return view('homepageadmin.mapeldata.index', compact('mapeldata'));
    }
}
