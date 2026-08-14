<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use App\Models\PersentaseSosialEkonomi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PersentasePekerjaanOrtuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();
        
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));
        
        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }
        
        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }
        
        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        
        // Ambil data rekapitulasi jumlah siswa berdasarkan walas_id tanpa relasi siswa
        $persentasesosialekonomi = PersentaseSosialEkonomi::where('walas_id', $walas->id)->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.persentasesosialekonomi', compact('walas', 'siswas', 'rombel', 'persentasesosialekonomi'));
            return $pdf->stream('Persentase Sosial Ekonomi.pdf');
        }
        // Kirim data walas, siswa, dan rekapitulasi jumlah siswa ke view
        return view('admwalas.persentasesosialekonomi.index', compact('walas', 'persentasesosialekonomi', 'siswas'));
    }



    /**
     * Show the form for creating a new resource.
     */

     public function create()
     {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
         $walas = Auth::guard('walas')->user();
     
         // Periksa apakah session 'walas_id' ada
         if (!session()->has('walas_id')) {
             return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
         }
     
         // Ambil data walas berdasarkan 'walas_id' yang ada di session
         $walas = Walas::find(session('walas_id'));
     
         // Periksa apakah data walas ditemukan
         if (!$walas) {
             return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
         }
     
         // Ambil data rombel berdasarkan 'walas_id'
         $rombel = Rombel::where('walas_id', $walas->id)->first();
     
         // Periksa apakah rombel ditemukan
         if (!$rombel) {
             return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
         }
     
         $siswas = Siswa::where('rombels_id', $rombel->id)
             ->with('biodata') // relasi biodata (bukan biodataSiswa)
             ->get();
             $jumlahPekerjaanAyah = $siswas->groupBy(fn($s) => $s->biodata?->pekerjaan_ayah ?? 'Tidak Diketahui')
             ->map(function ($items) {
                 return $items->count(); // Menghitung jumlah siswa dengan pekerjaan ayah yang sama
             });
         
         // Total siswa dalam rombel
         $totalSiswa = $siswas->count();
         
         // Persentase pekerjaan ayah
         $persentasePekerjaanAyah = $jumlahPekerjaanAyah->map(function ($jumlah) use ($totalSiswa) {
             return ($totalSiswa > 0) ? round(($jumlah / $totalSiswa) * 100, 2) : 0;
         });
         
         // Ambil pekerjaan ayah unik
         $pekerjaanAyah = $jumlahPekerjaanAyah->keys();
         
         return view('admwalas.persentasesosialekonomi.create', compact(
            'walas', 
            'siswas', 
            'rombel', 
            'pekerjaanAyah', 
            'jumlahPekerjaanAyah', 
            'persentasePekerjaanAyah', 
            'totalSiswa'
        ));
     }
     


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();

        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));

        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'jenis_sosial_ekonomi' => 'required',
            'jumlah' => 'required',
            'persentase' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
            'ttdwalas_url' => 'nullable|url',
        ]);

        // Tambahkan `walas_id` ke dalam data yang divalidasi
        $validatedData['walas_id'] = $walas->id;

        // Simpan data ke database
        PersentaseSosialEkonomi::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect('/persentasesosialekonomi')->with('success', 'Data berhasil disimpan.');
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
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();
    
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));
    
        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }
    
        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();
    
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }
    
        $siswas = Siswa::where('rombels_id', $rombel->id)
            ->with('biodata') // relasi biodata (bukan biodataSiswa)
            ->get();
            $jumlahPekerjaanAyah = $siswas->groupBy(fn($s) => $s->biodata?->pekerjaan_ayah ?? 'Tidak Diketahui')
            ->map(function ($items) {
                return $items->count(); // Menghitung jumlah siswa dengan pekerjaan ayah yang sama
            });
        
        // Total siswa dalam rombel
        $totalSiswa = $siswas->count();
        
        // Persentase pekerjaan ayah
        $persentasePekerjaanAyah = $jumlahPekerjaanAyah->map(function ($jumlah) use ($totalSiswa) {
            return ($totalSiswa > 0) ? round(($jumlah / $totalSiswa) * 100, 2) : 0;
        });
        
        // Ambil pekerjaan ayah unik
        $pekerjaanAyah = $jumlahPekerjaanAyah->keys();
        $persentase = PersentaseSosialEkonomi::findOrFail($id);
        
        return view('admwalas.persentasesosialekonomi.edit', compact(
           'walas', 
           'siswas', 
           'rombel', 
           'pekerjaanAyah', 
           'jumlahPekerjaanAyah', 
           'persentasePekerjaanAyah', 
           'totalSiswa', 
           'persentase'
       ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();

        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));

        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'jenis_sosial_ekonomi' => 'required',
            'jumlah' => 'required',
            'persentase' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
            'ttdwalas_url' => 'nullable|url',
        ]);

        // Tambahkan walas_id ke dalam data yang divalidasi
        $validatedData['walas_id'] = $walas->id;

        // Cari data berdasarkan id
        $persentase = PersentaseSosialEkonomi::find($id);

        // Periksa apakah data ditemukan
        if (!$persentase) {
            return redirect('/persentasesosialekonomi')->with('error', 'Data tidak ditemukan.');
        }

        // Perbarui data dengan input yang sudah divalidasi
        $persentase->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect('/persentasesosialekonomi')->with('success', 'Data berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function hapuspersentasesosialekonomi(string $id)
    {
        $persentasesosialekonomi = PersentaseSosialEkonomi::find($id);
        if ($persentasesosialekonomi) {
            $persentasesosialekonomi->delete();
            return redirect('/persentasesosialekonomi')->with('success', 'Data Berhasil Dihapus ');
        }
        return redirect('/persentasesosialekonomi')->with('error', 'Data not found!');
    }
}
