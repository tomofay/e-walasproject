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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiswaDataPageAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
         $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login
    
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
    
        // Ambil semua data rombels
        $siswas = Siswa::all();
        $rombel = Rombel::all();
    
        // Kirim data siswa, rombels, dan walas ke view
        return view("homepageadmin.siswadata.index", compact('siswas', 'walas', 'rombel'));
    }
    
    
        public function import(Request $request){
            Excel::import(new SiswaImport, $request->file('file'));
        return redirect('/siswadata');
        }
    
        public function downloadTemplate()
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
            // Validasi input
            $request->validate([
                'nama' => 'required|string|max:255',
                'rombels_id' => 'required',
                'jenis_kelamin' => 'required',
                'no_wa' => 'required|numeric',
                'image_url' => 'nullable|image|max:5000',
                'password' => 'required|string|min:2',
                'status' => 'required',
            ]);
        
            // Proses penyimpanan file gambar di folder walasfoto/Photos
            $imagePath = $request->file('image_url')->store('siswafoto/Photos', 'public'); // Simpan gambar di folder yang diinginkan
        
            // Simpan data ke database, termasuk path gambar
            Siswa::create([
                'nama' => $request->nama,
                'rombels_id' => $request->rombels_id,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_wa' => $request->no_wa,
                'password' => Hash::make($request->password),
                'status' => $request->status,
                'image_url' => $imagePath, // Simpan path gambar di database
            ]);
        
            /// Redirect kembali dengan data terbaru
            return redirect()->back()->with([
                'success' => 'Data Siswa berhasil ditambahkan!',
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
        $siswa = DB::table('vwsiswas')->where('siswa_id', $id)->first();
        $rombels = Rombel::all(); // Ambil semua data rombel
    
        // Kirim data ke view edit
        return view('homepagegtk.editsiswa', compact('siswa', 'rombels'));
    }
    
        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, $id)
        {
            // Validasi input
            $request->validate([
                'nama' => 'required|string|max:255',
                'rombels_id' => 'required',
                'jenis_kelamin' => 'required',
                'no_wa' => 'required|numeric',
                'image_url' => 'nullable|image|max:5000',
                'password' => 'required|string|min:2',
                'status' => 'required',
            ]);
        
            $siswa = Siswa::findOrFail($id); // Mengambil data dari tabel asli
    
            // Simpan foto jika ada file baru yang diunggah
            if ($request->hasFile('image_url')) {
                // Hapus foto lama jika ada
                if ($siswa->image_url) {
                    Storage::delete('public/' . $siswa->image_url);
                }
                
                // Simpan foto baru
                $imagePath = $request->file('image_url')->store('siswafoto/Photos', 'public');
                $siswa->image_url = $imagePath; // Update dengan path foto yang baru
            }
        
            // Update data Siswa
            $siswa->nama = $request->nama;
            $siswa->rombels_id = $request->rombels_id;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->no_wa = $request->no_wa;
            $siswa->status = $request->status;
        
            // Update password jika diisi (jika tidak, biarkan yang lama)
            if ($request->filled('password')) {
                $siswa->password = Hash::make($request->password);
            }
        
            // Simpan perubahan ke database
            $siswa->save();
        
            // Redirect dengan pesan sukses
            return redirect('/siswadata')->with('success', 'Data siswa Berhasil di Edit');
        }
        
        /**
         * Remove the specified resource from storage.
         */
        public function hapussiswa(string $id)
        {
            $siswa = Siswa::find($id);
            if ($siswa) {
                $siswa->delete();
                return redirect('/siswadata')->with('success', 'siswa data Berhasil Dihapus ');
            }
            return redirect('/siswadata')->with('error', 'siswa not found!');
        }
    
        public function siswadata_search(Request $request)
        {
            $search_text = $request->keyword;
            $keywords = explode(' ', $search_text); 
            $siswaQuery = Siswa::query();
        
            // Tambahkan pencarian berdasarkan nama siswa
            foreach ($keywords as $keyword) {
                $siswaQuery->where('nama', 'LIKE', '%' . $keyword . '%');
            }
        
            // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
            $walas = Auth::guard('walas')->user(); // ini akan mendapatkan data walas yang sedang login
        
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
        
            // Ambil data siswa berdasarkan rombel yang terkait dengan walas
            // Pastikan query hanya mengembalikan siswa yang ada di rombel tersebut
            $siswa = DB::table('vwsiswas')
                        ->where('id', $rombel->id) // Sesuaikan dengan relasi kolom rombel_id
                        ->where(function ($query) use ($keywords) {
                            foreach ($keywords as $keyword) {
                                $query->where('siswa_nama', 'LIKE', '%' . $keyword . '%');
                            }
                        })
                        ->get();
        
            // Ambil data rombel untuk ditampilkan di view (opsional)
            $rombels = Rombel::all();
        
            // Kirim data siswa hasil pencarian dan data lainnya ke view
            return view('homepagegtk.siswadata', compact( 'walas', 'rombels', 'rombel', 'siswa'));
        }

        public function tambahKeRombel(Request $request)
        {
            $request->validate([
                'siswa_id' => 'required|exists:siswas,id',
                'nama_kelas' => 'required|exists:rombels,nama_kelas', // Validasi berdasarkan nama_kelas
            ]);
        
            try {
                // Cari rombel_id berdasarkan nama_kelas
                $rombel = Rombel::where('nama_kelas', $request->nama_kelas)->first();
        
                if (!$rombel) {
                    return response()->json([
                        'message' => 'Rombel tidak ditemukan.'
                    ], 404);
                }
        
                // Update rombels_id siswa
                DB::table('siswas')->where('id', $request->siswa_id)->update([
                    'rombels_id' => $rombel->id, // Gunakan id rombel hasil pencarian
                    'keterangan' => 'tidak_naik_kelas'
                ]);
        
                // Hapus siswa dari keluar_rombel
                DB::table('keluar_rombels')->where('nama_siswa', $request->siswa_id)->delete();
        
                return response()->json([
                    'message' => 'Siswa berhasil dipindahkan ke rombel baru dan dihapus dari keluar_rombel!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
        }
          
    }
    

