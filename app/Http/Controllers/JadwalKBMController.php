<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\JadwalKbm;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalKbmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
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
        // Ambil data siswa berdasarkan rombel yang terkait dengan walas
        $siswa = DB::table('siswas')
                    ->where('rombels_id', $rombel->id)  // Sesuaikan dengan kolom yang tepat
                    ->get();
    
        // Ambil semua data rombel
        $rombels = Rombel::all();
    
        $jadwalKbms = JadwalKBM::with(['rombel', 'walas'])
            ->where('walas_id', $walas->id)
            ->get();
    
        $mapels = Mapel::all()->keyBy('id');
        $gurus = Guru::all()->keyBy('id');
    
        if ($request->input('export') === 'pdf') {
            if ($jadwalKbms->isEmpty()) {
                return back()->with('error', 'Jadwal belum tersedia, tidak bisa mengunduh PDF.');
            }
        
            $pdf = Pdf::loadView('pdf.jadwalkbm', compact('jadwalKbms', 'mapels', 'gurus', 'walas'))
                      ->setPaper('A4', 'portrait');
            return $pdf->stream('Jadwal_KBM.pdf');
        }
        
    
        return view('admwalas.jadwalkbm.index', compact('jadwalKbms', 'mapels', 'gurus', 'walas', 'rombels', 'rombel', 'siswa'));
    }
    
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
 
     public function create()
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

          // Ambil data rombel yang dimiliki walas yang sedang login
    $rombel = Rombel::where('walas_id', $walas->id)->first();
 
    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }
 
    // Ambil data siswa berdasarkan rombel yang terkait dengan walas
    $siswa = DB::table('vwsiswas')
                ->where('id', $rombel->id)  // Pastikan kolom yang digunakan sesuai dengan relasi rombel
                ->get();
 
    

    // Ambil data rombel yang dimiliki walas yang sedang login
    $rombel = Rombel::where('walas_id', $walas->id)->first();

    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }

        $rombels = Rombel::all(); 
        $walasList = Walas::all(); 
        $mapels = Mapel::all();
        $gurus = Guru::all();

        return view('admwalas.jadwalkbm.create', compact('rombels', 'walasList', 'mapels', 'gurus', 'walas', 'rombel'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function store(Request $request)
{
    
    $request->validate([
        'rombels_id' => 'required|exists:rombels,id',
        'walas_id' => 'required|exists:walas,id',
        'senin' => 'nullable|array',
        'selasa' => 'nullable|array',
        'rabu' => 'nullable|array',
        'kamis' => 'nullable|array',
        'jumat' => 'nullable|array',
    ]);

    // Ambil data jadwal
    $senin = $this->prepareScheduleData($request->senin);
    $selasa = $this->prepareScheduleData($request->selasa);
    $rabu = $this->prepareScheduleData($request->rabu);
    $kamis = $this->prepareScheduleData($request->kamis);
    $jumat = $this->prepareScheduleData($request->jumat);

    JadwalKbm::create([
        'rombels_id' => $request->rombels_id,
        'walas_id' => $request->walas_id,
        'senin' => json_encode($senin ?? []),
        'selasa' => json_encode($selasa ?? []),
        'rabu' => json_encode($rabu ?? []),
        'kamis' => json_encode($kamis ?? []),
        'jumat' => json_encode($jumat ?? []),
    ]);
    
    
    return redirect()->route('jadwalkbm.index')->with('success', 'Jadwal berhasil ditambahkan.');
}

    


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalKbm  $jadwalKbm
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
 
    // Ambil data rombel yang dimiliki walas yang sedang login
    $rombel = Rombel::where('walas_id', $walas->id)->first();
 
    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }

    $jadwalKbm = JadwalKbm::find($id);

    if (!$jadwalKbm) {
        abort(404);
    }

    // Dekode JSON untuk setiap hari
    foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $hari) {
        $jadwalKbm->$hari = json_decode($jadwalKbm->$hari, true) ?? [];
    }

    $rombels = Rombel::all();
    $walasList = Walas::all();
    $mapels = Mapel::all();
    $gurus = Guru::all();

    return view('admwalas.jadwalkbm.edit', compact('jadwalKbm', 'rombels', 'walasList', 'mapels', 'gurus', 'walas', 'rombel'));
}

public function update(Request $request, $id)
{
    // Ambil data jadwal berdasarkan ID
    $jadwalKbm = JadwalKbm::find($id);

    if (!$jadwalKbm) {
        return redirect()->route('jadwalkbm.index')->with('error', 'Data tidak ditemukan');
    }

    // Validasi data (contoh validasi)
    $request->validate([
        'rombels_id' => 'required|exists:rombels,id',
        'walas_id' => 'required|exists:walas,id',
        // Tambahkan validasi lain sesuai kebutuhan
    ]);

    // Siapkan data jadwal KBM
    $jadwalKbm->rombels_id = $request->rombels_id;
    $jadwalKbm->walas_id = $request->walas_id;

    // Proses data hari (contoh: senin)
    $jadwalKbm->senin = json_encode($this->prepareScheduleData($request->input('senin')));
    $jadwalKbm->selasa = json_encode($this->prepareScheduleData($request->input('selasa')));
    $jadwalKbm->rabu = json_encode($this->prepareScheduleData($request->input('rabu')));
    $jadwalKbm->kamis = json_encode($this->prepareScheduleData($request->input('kamis')));
    $jadwalKbm->jumat = json_encode($this->prepareScheduleData($request->input('jumat')));

    // Simpan data ke database
    $jadwalKbm->save();

    // Redirect dengan pesan sukses
    return redirect()->route('jadwalkbm.index')->with('success', 'Data jadwal berhasil diperbarui.');
}


    
        private function prepareScheduleData($scheduleData)
        {
            if (!is_array($scheduleData) || empty($scheduleData)) {
                return [];
            }

            $preparedData = [];
            foreach ($scheduleData as $jam => $detail) {
                if (isset($detail['mapel']) && isset($detail['guru'])) {
                    $preparedData[] = [
                        'jam' => $jam,
                        'mapel_id' => $detail['mapel'],
                        'guru_id' => $detail['guru'],
                    ];
                }
            }
            return $preparedData;
        }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalKbm  $jadwalKbm
     * @return \Illuminate\Http\Response
     */
    public function destroy(JadwalKbm $jadwalKbm)
    {
        $jadwalKbm->delete();
        return redirect()->route('jadwalkbm.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
