<?php

namespace App\Http\Controllers;
use App\Models\Kakom;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Imports\KakomImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KakomDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $admin = Auth::guard('admins')->user();  // ini akan mendapatkan data kurikulum yang sedang login
    
        // Periksa apakah session 'kurikulum_id' ada
        if (!session()->has('admin_id')) {
            return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
        }
  
        // Ambil data kurikulum berdasarkan 'admin_id' yang ada di session
        $admin = Admin::find(session('admin_id'));
        
        // Periksa apakah data kurikulum ditemukan
        if (!$admin) {
            return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
        }

        $kakomdata = Kakom::all();

        return view('homepageadmin.kakomdata.index', compact('kakomdata', 'admin'));
        }

    public function import(Request $request){
        Excel::import(new KakomImport, $request->file('file'));
    return redirect('/kakom');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_kakom.xlsx'); // Sesuaikan dengan lokasi file template Excel
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
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|numeric',
            'password' => 'required|string|min:2',
            'kompetensi' => 'required|string|max:255',
            'image_url' => 'nullable|image|max:5000',
        ]);
    
        // Proses penyimpanan file gambar di folder walasfoto/Photos
        $imagePath = $request->file('image_url')->store('kakom/Photos', 'public'); // Simpan gambar di folder yang diinginkan
    
        // Simpan data ke database, termasuk path gambar
        Kakom::create([
            'nama' => $request->nama,
            'no_wa' => $request->no_wa,
            'password' => Hash::make($request->password),
            'kompetensi' => $request->kompetensi,
            'image_url' => $imagePath, // Simpan path gambar di database
        ]);
    
        /// Redirect kembali dengan data terbaru
        return redirect()->back()->with([
            'success' => 'Data Wali Kelas berhasil ditambahkan!',
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
        // Ambil data produk berdasarkan ID
        $kakom = Kakom::findOrFail($id);

        // Kirim data ke view edit
        return view('homepageadmin.kakomdata.edit', compact('kakom'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|numeric',
            'password' => 'nullable|string|min:2',
            'kompetensi' => 'required',
            'image_url' => 'nullable|image|max:5000', 
        ]);
    
        // Cari Wali Kelas berdasarkan ID
        $kakom = Kakom::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404
    
        // Simpan foto jika ada file baru yang diunggah
        if ($request->hasFile('image_url')) {
            // Hapus foto lama jika ada
            if ($kakom->image_url) {
                Storage::delete('public/' . $kakom->image_url);
            }
            
            // Simpan foto baru
            $imagePath = $request->file('image_url')->store('kakomfoto/Photos', 'public');
            $kakom->image_url = $imagePath; // Update dengan path foto yang baru
        }
    
        // Update data Wali Kelas
        $kakom->nama = $request->nama;
        $kakom->no_wa = $request->no_wa;
        $kakom->kompetensi = $request->kompetensi;
    
        // Update password jika diisi (jika tidak, biarkan yang lama)
        if ($request->filled('password')) {
            $kakom->password = Hash::make($request->password);
        }
    
        // Simpan perubahan ke database
        $kakom->save();
    
        // Redirect dengan pesan sukses
        return redirect('/kakom')->with('success', 'Data Kakom Berhasil di Edit');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function kakom_search(Request $request)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $admin = Auth::guard('admins')->user();  // ini akan mendapatkan data kurikulum yang sedang login
    
        // Periksa apakah session 'kurikulum_id' ada
        if (!session()->has('admin_id')) {
            return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
        }
  
        // Ambil data kurikulum berdasarkan 'admin_id' yang ada di session
        $admin = Admin::find(session('admin_id'));
        
        // Periksa apakah data kurikulum ditemukan
        if (!$admin) {
            return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
        }
        $search_text = $request->keyword;
        $keywords = explode(' ', $search_text); 
        $kakomsQuery = Kakom::query();
    
        foreach ($keywords as $keyword) {
            $kakomsQuery->where('nama', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('kompetensi', 'LIKE', '%' . $keyword . '%');
        }
    
        $kakomdata = $kakomsQuery->get();
    
        return view('homepageadmin.kakomdata.index', compact('kakomdata', 'admin'));
    }

    public function hapuskakom(string $id)
    {
        $kakom = Kakom::find($id);
        if ($kakom) {
            $kakom->delete();
            return redirect('/kakom')->with('success', 'kakom data Berhasil Dihapus ');
        }
        return redirect('/kakom')->with('error', 'kakom not found!');
    }
}
