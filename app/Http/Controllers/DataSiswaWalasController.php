<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\KeluarRombel;
use App\Imports\SiswaImport;
use App\Models\BiodataSiswa;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DataSiswaWalasController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswa = DB::table('vwsiswas')
            ->leftJoin('keluar_rombels', 'vwsiswas.siswa_id', '=', 'keluar_rombels.nama_siswa')
            ->where('vwsiswas.nama_kelas', $rombel->nama_kelas)
            ->select('vwsiswas.*', 'keluar_rombels.keterangan')
            ->get();

        $rombels = Rombel::with('walas')->get();

        return view("homepagegtk.siswadata", compact('siswa', 'rombels', 'rombel', 'walas'));
    }

    public function import(Request $request)
    {
        if (! $request->hasFile('file')) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        Excel::import(new SiswaImport, $request->file('file'));
        return redirect('/siswadata');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_siswa.xlsx');
        if (! file_exists($pathToFile)) {
            return back()->with('error', 'Template belum tersedia.');
        }
        return response()->download($pathToFile);
    }

    public function biodata($id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswa = Siswa::find($id);
        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan');
        }

        $biodatas = BiodataSiswa::where('siswas_id', $siswa->id)->get();
        if ($biodatas->isEmpty()) {
            return back()->with('error', 'Data Biodata Siswa Tidak Ditemukan');
        }

        foreach ($biodatas as $item) {
            $item->fotorumah_base64 = $this->convertToBase64($item->fotorumah_url);
        }

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $biodatas = BiodataSiswa::where('siswas_id', $siswa->id)->first();
            $biodatas->fotorumah_base64 = $this->convertToBase64($biodatas->fotorumah_url);
            $pdf = Pdf::loadView('pdf.pdfbiodatasiswa', compact('siswa', 'biodatas', 'walas', 'rombel'));
            return $pdf->stream('Biodata_Siswa.pdf');
        }

        return view('homepagegtk.biodatasiswa', compact('siswa', 'biodatas', 'walas', 'rombel'));
    }

    private function convertToBase64($path)
    {
        $fullPath = storage_path("app/public/" . $path);
        if (file_exists($fullPath)) {
            $imageData = file_get_contents($fullPath);
            $mimeType = mime_content_type($fullPath);
            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        }
        return null;
    }

    public function editbiodata($id)
    {
        $walas = $this->getAuthenticatedWalas();

        $biodata = BiodataSiswa::find($id);
        if (! $biodata) {
            return redirect('/siswadata')->with('error', 'Biodata siswa tidak ditemukan.');
        }

        $siswa = Siswa::find($biodata->siswas_id);
        if (! $siswa) {
            return redirect('/siswadata')->with('error', 'Data siswa tidak ditemukan.');
        }

        $nowalas = $siswa->rombel ? $siswa->rombel->walas : null;
        $walasList = Walas::select('id', 'nama')->get();
        $walasData = \App\Models\Walas::find($biodata->walas_id);
        $no_wa_walas = $walasData->no_wa ?? 'Nomor tidak tersedia';

        return view('homepagegtk.editbiodata', compact('biodata', 'siswa', 'nowalas', 'walasList', 'no_wa_walas', 'walas'));
    }

    public function updatebiodata(Request $request, $id)
    {
        $walas = $this->getAuthenticatedWalas();
        $biodata = BiodataSiswa::findOrFail($id);

        $request->validate([
            'walas_id' => 'nullable|integer',
            'siswas_id' => 'nullable|integer',
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:10',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'alamat_maps' => 'nullable|string|max:5000',
            'fotorumah_url' => 'nullable',
            'jalur_masuk' => 'nullable|string|max:50',
            'jarak_rumah' => 'nullable|string|max:50',
            'transportasi_sekolah' => 'nullable|string|max:50',
            'transportasi_rumah' => 'nullable|string|max:50',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'no_wa' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'nis' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'kelas' => 'nullable|string|max:50',
            'kompetensi' => 'nullable|string|max:100',
            'tahun_masuk' => 'nullable|string|max:4',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'tempat_lahir_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'alamat_ayah' => 'nullable|string|max:255',
            'no_wa_ayah' => 'nullable|string|max:15',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'tempat_lahir_ibu' => 'nullable|string|max:255',
            'tanggal_lahir_ibu' => 'nullable|date',
            'alamat_ibu' => 'nullable|string|max:255',
            'no_wa_ibu' => 'nullable|string|max:15',
            'namasekolah_asal' => 'nullable|string|max:255',
            'alamat_sekolah' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|string|max:4',
            'riwayat_penyakit' => 'nullable|string|max:255',
            'alergi' => 'nullable|string|max:255',
            'prestasi_akademik' => 'nullable|string|max:255',
            'prestasi_non_akademik' => 'nullable|string|max:255',
            'pengalaman_ekskul' => 'nullable|string|max:255',
            'kepribadian' => 'nullable|string|max:255',
        ]);

        if ($request->pekerjaan_ayah === 'Lainnya' && $request->has('pekerjaan_ayah_lainnya')) {
            $request->merge(['pekerjaan_ayah' => $request->pekerjaan_ayah_lainnya]);
        }
        if ($request->pekerjaan_ibu === 'Lainnya' && $request->has('pekerjaan_ibu_lainnya')) {
            $request->merge(['pekerjaan_ibu' => $request->pekerjaan_ibu_lainnya]);
        }

        if ($request->hasFile('fotorumah_url')) {
            if ($biodata->fotorumah_url && Storage::exists('public/' . $biodata->fotorumah_url)) {
                Storage::delete('public/' . $biodata->fotorumah_url);
            }
            $fotoRumahPath = $request->file('fotorumah_url')->store('images/photos', 'public');
        } else {
            $fotoRumahPath = $biodata->fotorumah_url;
        }

        $biodata->fill($request->except(['fotorumah_url']));
        $biodata->fotorumah_url = $fotoRumahPath;
        $biodata->save();

        return redirect('/siswadata')->with('success', 'Data Diri Siswa berhasil diperbarui!');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'rombels_id' => 'required',
            'jenis_kelamin' => 'required',
            'no_wa' => 'required|numeric',
            'image_url' => 'nullable|image|max:5000',
            'password' => 'required|string|min:2',
            'status' => 'required',
        ]);

        $imagePath = $request->file('image_url')->store('siswafoto/Photos', 'public');

        Siswa::create([
            'nama' => $request->nama,
            'rombels_id' => $request->rombels_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_wa' => $request->no_wa,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'image_url' => $imagePath,
        ]);

        return redirect()->back()->with(['success' => 'Data Siswa berhasil ditambahkan!']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $siswa = DB::table('vwsiswas')->where('siswa_id', $id)->first();
        $rombels = Rombel::with('walas')->get();
        return view('homepagegtk.editsiswa', compact('siswa', 'rombels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'rombels_id' => 'required',
            'jenis_kelamin' => 'required',
            'no_wa' => 'required|numeric',
            'image_url' => 'nullable|image|max:5000',
            'password' => 'required|string|min:2',
            'status' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);

        if ($request->hasFile('image_url')) {
            if ($siswa->image_url) {
                Storage::delete('public/' . $siswa->image_url);
            }
            $siswa->image_url = $request->file('image_url')->store('siswafoto/Photos', 'public');
        }

        $siswa->fill($request->except(['image_url', 'password']));
        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }
        $siswa->save();

        return redirect('/siswadata')->with('success', 'Data siswa Berhasil di Edit');
    }

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
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $keywords = explode(' ', $request->keyword);

        $siswa = DB::table('vwsiswas')
            ->where('id', $rombel->id)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where('siswa_nama', 'LIKE', '%' . $keyword . '%');
                }
            })
            ->get();

        $rombels = Rombel::with('walas')->get();

        return view('homepagegtk.siswadata', compact('walas', 'rombels', 'rombel', 'siswa'));
    }

    public function saveKeterangan(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'keterangan' => 'required|in:naik_kelas,tidak_naik_kelas,pindah_sekolah',
        ]);

        $siswa = Siswa::find($request->siswa_id);

        $keluarRombel = KeluarRombel::create([
            'nama_siswa' => $siswa->id,
            'keterangan' => $request->keterangan,
            'rombels_id' => $rombel->id,
        ]);

        return response()->json(['success' => 'Data berhasil disimpan!', 'keluarRombel' => $keluarRombel]);
    }
}
