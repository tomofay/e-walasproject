<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Models\BeritaAcaraSerahTerima;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class BeritaAcaraSerahTerimaController extends Controller
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

    // Ambil data rombel yang dimiliki walas yang sedang login
    $rombel = Rombel::where('walas_id', $walas->id)->first();

    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }

    $walas_id = session('walas_id'); // Ambil ID walas yang sedang login

    $beritaacaraserahterima = BeritaAcaraSerahTerima::where('walas_id', $walas_id)->get();
    
        return view("admwalas.beritaacaraserahterima.index" , compact('beritaacaraserahterima', 'walas', 'rombel'));
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/Berita_Acara_Serah_Terima.pdf');
        if (!file_exists($pathToFile)) {
            return back()->with('error', 'Template belum tersedia.');
        }
        return response()->download($pathToFile);
    }

    public function create()
    {
             // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
    $walaslogin = Auth::guard('walas')->user();

    // Periksa apakah session 'walas_id' ada
    if (!session()->has('walas_id')) {
        return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data walas berdasarkan 'walas_id' yang ada di session
    $walaslogin = Walas::find(session('walas_id'));

    // Periksa apakah data walas ditemukan
    if (!$walaslogin) {
        return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
    }

    // Ambil data rombel yang dimiliki walas yang sedang login
    $rombel = Rombel::where('walas_id', $walaslogin->id)->first();

    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }
        $walas = Walas::all();
        $beritaacaraserahterima = BeritaAcaraSerahTerima::all();
        return view('admwalas.beritaacaraserahterima.create', compact('beritaacaraserahterima', 'walas', 'walaslogin', 'rombel'));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    // validasi input
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'image_url' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:2048', // validasi file gambar
    ]);

    // simpan file ke storage
    if ($request->hasFile('image_url')) {
        $filePath = $request->file('image_url')->store('images/photos', 'public'); // simpan di storage/app/public/images
        
    }

    // simpan data ke database
    BeritaAcaraSerahTerima::create([
        'walas_id' => $request->walas_id,
        'image_url' => $filePath, // simpan path file di database
    ]);

    // redirect dengan pesan sukses
    return redirect()->route('beritaacaraserahterima.index')->with('success', 'Data berhasil disimpan!');
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
             $walaslogin = Auth::guard('walas')->user();

             // Periksa apakah session 'walas_id' ada
             if (!session()->has('walas_id')) {
                 return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
             }
         
             // Ambil data walas berdasarkan 'walas_id' yang ada di session
             $walaslogin = Walas::find(session('walas_id'));
         
             // Periksa apakah data walas ditemukan
             if (!$walaslogin) {
                 return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
             }
         
             // Ambil data rombel yang dimiliki walas yang sedang login
             $rombel = Rombel::where('walas_id', $walaslogin->id)->first();
         
             // Periksa apakah rombel ditemukan
             if (!$rombel) {
                 return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
             }
    // ambil data berdasarkan id
    $beritaacaraserahterima = BeritaAcaraSerahTerima::findOrFail($id);
    $walas = Walas::all(); // untuk dropdown wali kelas

    return view('admwalas.beritaacaraserahterima.edit', compact('beritaacaraserahterima', 'walas', 'walaslogin', 'rombel'));
}

public function update(Request $request, $id)
{
    // validasi input
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'image_url' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048', // validasi file gambar
    ]);

    // ambil data lama
    $beritaacaraserahterima = BeritaAcaraSerahTerima::findOrFail($id);

    // simpan file baru jika ada
    if ($request->hasFile('image_url')) {
        // hapus file lama
        if ($beritaacaraserahterima->image_url && Storage::disk('public')->exists($beritaacaraserahterima->image_url)) {
            Storage::disk('public')->delete($beritaacaraserahterima->image_url);
        }

        // simpan file baru
        $filePath = $request->file('image_url')->store('images/photos', 'public');
        $beritaacaraserahterima->image_url = $filePath;
    }

    // update data lainnya
    $beritaacaraserahterima->walas_id = $request->walas_id;
    $beritaacaraserahterima->save();

    // redirect dengan pesan sukses
    return redirect()->route('beritaacaraserahterima.index')->with('success', 'Data berhasil diperbarui!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
