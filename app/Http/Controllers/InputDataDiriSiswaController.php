<?php

namespace App\Http\Controllers;

use App\Models\BiodataSiswa;
use App\Models\Siswa;
use App\Models\Walas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InputDataDiriSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil siswa yang sedang login
        $siswa = Auth::guard('siswas')->user();

        // Periksa apakah session 'siswa_id' ada
        if (!session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data siswa berdasarkan 'siswa_id' yang ada di session
        $siswa = Siswa::with('rombel.walas', 'biodata')->find(session('siswa_id'));

        // Periksa apakah data siswa ditemukan
        if (!$siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }

         // Mengambil data dari tabel walas
        $walas = DB::table('walas')->select('id', 'nama')->get();


        $biodatas = BiodataSiswa::all();
        return view('homepagesiswa.inputdatadiri.index', compact('biodatas', 'siswa', 'walas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menggunakan guard 'siswas' untuk mendapatkan data siswa yang login
        $siswa = Auth::guard('siswas')->user();
    
        // Periksa apakah session 'siswa_id' ada
        if (!session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data siswa berdasarkan 'siswa_id' yang ada di session
        $siswa = Siswa::with('rombel.walas', 'biodata')->find(session('siswa_id'));
    
        // Periksa apakah data siswa ditemukan
        if (!$siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }
    
        $ayahPekerjaanLainnya = $request->input('pekerjaan_ayah') === 'Lainnya';
        $ibuPekerjaanLainnya = $request->input('pekerjaan_ibu') === 'Lainnya';
        if ($ayahPekerjaanLainnya) {
            $request->merge(['pekerjaan_ayah' => $request->input('pekerjaan_ayah_lainnya')]);
        }
        if ($ibuPekerjaanLainnya) {
            $request->merge(['pekerjaan_ibu' => $request->input('pekerjaan_ibu_lainnya')]);
        }

        $ayahPekerjaanRules = ['required', 'string', 'max:80'];
        if (! $ayahPekerjaanLainnya) {
            $ayahPekerjaanRules[] = Rule::in(['TNI/POLRI', 'ASN/PNS', 'Karyawan', 'Wiraswasta', 'Pengemudi', 'Buruh', 'Tani', 'Pensiunan']);
        }
        $ibuPekerjaanRules = ['required', 'string', 'max:50'];
        if (! $ibuPekerjaanLainnya) {
            $ibuPekerjaanRules[] = Rule::in(['TNI/POLRI', 'ASN/PNS', 'Karyawan', 'Wiraswasta', 'Ibu Rumah Tangga', 'Buruh', 'Tani', 'Pensiunan']);
        }

        $validatedData = $request->validate([
            'walas_id' => 'nullable|integer',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => ['required', Rule::in(['Perempuan', 'Laki-laki'])],
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'alamat' => 'required|string',
            'alamat_maps' => 'required|string',
            'fotorumah_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jalur_masuk' => 'required|string|max:100',
            'jarak_rumah' => 'required|string|max:255',
            'transportasi_sekolah' => 'required|string|max:255',
            'transportasi_rumah' => 'required|string|max:255',
            'agama' => ['required', Rule::in(['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Budha', 'Konghucu'])],
            'kewarganegaraan' => 'required|string|max:20',
            'anak_ke' => 'required|integer|min:1|max:99999',
            'jumlah_saudara' => 'required|integer|min:0|max:99999',
            'no_wa' => ['required', 'string', 'max:14', 'regex:/^[0-9+ -]+$/'],
            'email' => 'required|email|max:50',
            'nis' => 'nullable|string|max:20',
            'nisn' => ['required', 'string', 'max:20', Rule::unique('biodata_siswas', 'nisn')],
            'kelas' => 'nullable|string|max:50',
            'kompetensi' => 'nullable|string|max:100',
            'tahun_masuk' => 'required|digits:4',
            'nama_ayah' => 'required|string|max:80',
            'pekerjaan_ayah' => $ayahPekerjaanRules,
            'pekerjaan_ayah_lainnya' => 'nullable|string|max:80',
            'tempat_lahir_ayah' => 'required|string|max:50',
            'tanggal_lahir_ayah' => 'required|date|before_or_equal:today',
            'alamat_ayah' => 'required|string',
            'no_wa_ayah' => ['required', 'string', 'max:15', 'regex:/^[0-9+ -]+$/'],
            'nama_ibu' => 'required|string|max:50',
            'pekerjaan_ibu' => $ibuPekerjaanRules,
            'pekerjaan_ibu_lainnya' => 'nullable|string|max:50',
            'tempat_lahir_ibu' => 'required|string|max:50',
            'tanggal_lahir_ibu' => 'required|date|before_or_equal:today',
            'alamat_ibu' => 'required|string',
            'no_wa_ibu' => ['required', 'string', 'max:15', 'regex:/^[0-9+ -]+$/'],
            'pendapatan_ortu' => ['required', 'string', 'max:80', Rule::in([
                'Kurang dari Rp1.000.000,00',
                'Rp1.000.000,00 - Rp3.000.000,00',
                'Rp3.000.000,00 - Rp5.000.000,00',
                'Rp5.000.000,00 - Rp10.000.000,00',
                'Rp10.000.000,00 - Rp25.000.000,00',
                'Rp25.000.000,00 - Rp50.000.000,00',
                'Lebih dari Rp50.000.000,00',
            ])],
            'namasekolah_asal' => 'required|string|max:50',
            'alamat_sekolah' => 'required|string',
            'tahun_lulus' => 'required|digits:4',
            'riwayat_penyakit' => 'nullable|string|max:50',
            'alergi' => 'nullable|string|max:50',
            'prestasi_akademik' => 'nullable|string',
            'prestasi_non_akademik' => 'nullable|string',
            'pengalaman_ekskul' => 'nullable|string',
            'kepribadian' => 'nullable|string',
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
            'exists' => 'Pilihan :attribute tidak valid.',
            'in' => 'Pilihan :attribute tidak valid.',
            'email' => 'Format :attribute harus berupa alamat email yang valid.',
            'unique' => ':attribute sudah terdaftar. Periksa kembali datanya.',
            'image' => 'File :attribute harus berupa gambar.',
            'mimes' => 'Format :attribute harus JPG, JPEG, PNG, atau GIF.',
            'max' => 'Kolom :attribute melebihi batas maksimal.',
            'digits' => 'Kolom :attribute harus berisi tepat :digits angka.',
            'before_or_equal' => 'Tanggal :attribute tidak boleh melebihi hari ini.',
            'regex' => 'Kolom :attribute hanya boleh berisi angka, spasi, tanda +, atau -.',
            'integer' => 'Kolom :attribute harus berupa angka bulat.',
            'min' => 'Nilai :attribute terlalu kecil.',
        ], [
            'walas_id' => 'wali kelas',
            'nama_lengkap' => 'nama lengkap',
            'jenis_kelamin' => 'jenis kelamin',
            'tempat_lahir' => 'tempat lahir',
            'tanggal_lahir' => 'tanggal lahir',
            'alamat' => 'alamat',
            'alamat_maps' => 'alamat maps',
            'fotorumah_url' => 'foto rumah',
            'jalur_masuk' => 'jalur masuk',
            'jarak_rumah' => 'jarak rumah',
            'transportasi_sekolah' => 'transportasi ke sekolah',
            'transportasi_rumah' => 'transportasi ke rumah',
            'agama' => 'agama',
            'kewarganegaraan' => 'kewarganegaraan',
            'anak_ke' => 'anak ke',
            'jumlah_saudara' => 'jumlah saudara',
            'no_wa' => 'nomor WhatsApp siswa',
            'email' => 'email',
            'nis' => 'NIS',
            'nisn' => 'NISN',
            'kelas' => 'kelas',
            'kompetensi' => 'kompetensi',
            'tahun_masuk' => 'tahun masuk',
            'nama_ayah' => 'nama ayah',
            'pekerjaan_ayah' => 'pekerjaan ayah',
            'pekerjaan_ayah_lainnya' => 'pekerjaan ayah lainnya',
            'tempat_lahir_ayah' => 'tempat lahir ayah',
            'tanggal_lahir_ayah' => 'tanggal lahir ayah',
            'alamat_ayah' => 'alamat ayah',
            'no_wa_ayah' => 'nomor WhatsApp ayah',
            'nama_ibu' => 'nama ibu',
            'pekerjaan_ibu' => 'pekerjaan ibu',
            'pekerjaan_ibu_lainnya' => 'pekerjaan ibu lainnya',
            'tempat_lahir_ibu' => 'tempat lahir ibu',
            'tanggal_lahir_ibu' => 'tanggal lahir ibu',
            'alamat_ibu' => 'alamat ibu',
            'no_wa_ibu' => 'nomor WhatsApp ibu',
            'pendapatan_ortu' => 'rentang pendapatan orang tua',
            'namasekolah_asal' => 'nama sekolah asal',
            'alamat_sekolah' => 'alamat sekolah asal',
            'tahun_lulus' => 'tahun lulus',
        ]);

        unset($validatedData['pekerjaan_ayah_lainnya'], $validatedData['pekerjaan_ibu_lainnya']);
    
        // Menambahkan siswas_id ke request
        $validatedData['siswas_id'] = $siswa->id;

        // Wali Kelas, Kelas, dan Kompetensi otomatis dari rombel siswa
        $validatedData['walas_id'] = $siswa->rombel?->walas_id ?? ($request->input('walas_id') ?: null);
        $validatedData['kelas'] = $siswa->rombel?->tingkat ?? ($siswa->rombel?->nama_kelas ?? ($request->input('kelas') ?: 'X'));
        $validatedData['kompetensi'] = $siswa->rombel?->kompetensi ?? ($request->input('kompetensi') ?: 'SIJA');

        // NIS diisi kurikulum atau walas; jika belum ada di biodata tapi ada di daftar peserta didik, gunakan itu
        $existingNis = $siswa->biodata?->nis ?: (\App\Models\DaftarPesertaDidik::where('nama_siswa', $siswa->id)->value('nis') ?? null);
        $validatedData['nis'] = $request->input('nis') ?: $existingNis;

        // Kepemilikan rumah telah dihapus
        $validatedData['kepemilikan_rumah'] = null;

        foreach (['riwayat_penyakit', 'alergi', 'prestasi_akademik', 'prestasi_non_akademik', 'pengalaman_ekskul', 'kepribadian'] as $optionalField) {
            $validatedData[$optionalField] = ($validatedData[$optionalField] ?? null) ?: 'Tidak ada';
        }
    
        // Cek dan simpan file gambar jika ada
        if ($request->hasFile('fotorumah_url')) {
            $fileName = uniqid() . '.' . $request->file('fotorumah_url')->getClientOriginalExtension();
            $fotoRumahPath = $request->file('fotorumah_url')->storeAs('images/photos', $fileName, 'public');
            $validatedData['fotorumah_url'] = $fotoRumahPath;
        }
    
        // Simpan data ke database
        $createdBiodata = BiodataSiswa::create($validatedData);

        // Sinkronisasi ke daftar peserta didik
        \App\Models\DaftarPesertaDidik::updateOrCreate(
            ['nama_siswa' => $siswa->id],
            [
                'walas_id' => $validatedData['walas_id'] ?? 1,
                'nis' => $createdBiodata->nis,
                'nisn' => $createdBiodata->nisn ?? null,
                'jenis_kelamin' => $createdBiodata->jenis_kelamin ?? 'Laki-laki',
                'keterangan' => 'Aktif',
                'tanggal' => now()->toDateString(),
            ]
        );
    
        return redirect('/datadiripage')->with('success', 'Data Berhasil Ditambahkan!');
    }
    

    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $biodata = BiodataSiswa::findOrFail($id);
        return view('homepagesiswa.datadiri', compact('biodata'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mengambil siswa yang sedang login
        $siswa = Auth::guard('siswas')->user();

        // Periksa apakah session 'siswa_id' ada
        if (!session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data siswa berdasarkan 'siswa_id' yang ada di session beserta relasi rombel dan walas
        $siswa = Siswa::with('rombel.walas', 'biodata')->find(session('siswa_id'));

        // Periksa apakah data siswa ditemukan
        if (!$siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil biodata berdasarkan 'siswas_id'
        $biodata = BiodataSiswa::where('siswas_id', $siswa->id)->first();

        // Periksa apakah data biodata ditemukan
        if (!$biodata) {
            return redirect('/homepagesiswa')->with('error', 'Data biodata tidak ditemukan.');
        }

        // Ambil data rombel siswa
        $rombel = $siswa->rombel;

        // Ambil wali kelas dari rombel siswa atau dari biodata
        $nowalas = $rombel ? $rombel->walas : null;
        $walas_id = $rombel?->walas_id ?? $biodata->walas_id;
        $walas = $walas_id ? Walas::find($walas_id) : null;
        $no_wa_walas = $walas && !empty($walas->no_wa) ? $walas->no_wa : 'Nomor tidak tersedia';

        // Mengambil data dari tabel walas
        $walasList = DB::table('walas')->select('id', 'nama')->get();

        // Ambil biodata siswa berdasarkan ID, tetapi hanya jika milik siswa yang login
        $biodata = BiodataSiswa::where('id', $id)->where('siswas_id', $siswa->id)->first();

        // Jika biodata tidak ditemukan atau bukan milik siswa yang login, redirect dengan error
        if (!$biodata) {
            return redirect('/homepagesiswa')->with('error', 'Data tidak ditemukan.');
        }

        // Return view dengan data yang dibutuhkan
        return view('homepagesiswa.inputdatadiri.edit', compact('biodata', 'siswa', 'nowalas', 'walasList', 'no_wa_walas', 'walas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input request
        $request->validate([
            'walas_id' => 'nullable|integer',
            'siswas_id' => 'nullable|integer',
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:10',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'alamat_maps' => 'nullable|string|max:5000',
            'fotorumah_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jalur_masuk' => 'nullable|string|max:100',
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
            'nisn' => 'required|string|max:20',
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
            'pendapatan_ortu' => 'nullable|string|max:80',
            'namasekolah_asal' => 'nullable|string|max:255',
            'alamat_sekolah' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|string|max:4',
            'riwayat_penyakit' => 'nullable|string|max:255',
            'alergi' => 'nullable|string|max:255',
            'prestasi_akademik' => 'nullable|string|max:255',
            'prestasi_non_akademik' => 'nullable|string|max:255',
            'pengalaman_ekskul' => 'nullable|string|max:255',
            'kepribadian' => 'nullable|string|max:255'
        ]);

        // Periksa sesi login siswa
        if (!session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data siswa dari sesi
        $siswa = Siswa::with('rombel.walas', 'biodata')->find(session('siswa_id'));
        if (!$siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil data biodata siswa berdasarkan ID
        $biodata = BiodataSiswa::findOrFail($id);

        // Mengecek apakah pekerjaan ayah adalah "Lainnya" dan mengganti nilainya jika perlu
        if ($request->pekerjaan_ayah === 'Lainnya' && $request->has('pekerjaan_ayah_lainnya')) {
            $request->merge(['pekerjaan_ayah' => $request->pekerjaan_ayah_lainnya]);
        }

        // Mengecek apakah pekerjaan ibu adalah "Lainnya" dan mengganti nilainya jika perlu
        if ($request->pekerjaan_ibu === 'Lainnya' && $request->has('pekerjaan_ibu_lainnya')) {
            $request->merge(['pekerjaan_ibu' => $request->pekerjaan_ibu_lainnya]);
        }

        // Periksa apakah ada file baru yang diunggah
        if ($request->hasFile('fotorumah_url')) {
            // Hapus file lama jika ada
            if ($biodata->fotorumah_url && Storage::exists('public/' . $biodata->fotorumah_url)) {
                Storage::delete('public/' . $biodata->fotorumah_url);
            }
            // Simpan file baru
            $fotoRumahPath = $request->file('fotorumah_url')->store('images/photos', 'public');
        } else {
            $fotoRumahPath = $biodata->fotorumah_url; // Gunakan file lama jika tidak ada perubahan
        }


        $originalNis = $biodata->nis ?: (\App\Models\DaftarPesertaDidik::where('nama_siswa', $siswa->id)->value('nis') ?? null);

        $fieldsToUpdate = [
            'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'alamat_maps',
            'jalur_masuk', 'jarak_rumah', 'transportasi_sekolah', 'transportasi_rumah', 'agama',
            'kewarganegaraan', 'anak_ke', 'jumlah_saudara', 'no_wa', 'email', 'nisn',
            'tahun_masuk', 'nama_ayah', 'pekerjaan_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
            'alamat_ayah', 'no_wa_ayah', 'nama_ibu', 'pekerjaan_ibu', 'tempat_lahir_ibu',
            'tanggal_lahir_ibu', 'alamat_ibu', 'no_wa_ibu', 'pendapatan_ortu', 'namasekolah_asal', 'alamat_sekolah',
            'tahun_lulus', 'riwayat_penyakit', 'alergi', 'prestasi_akademik', 'prestasi_non_akademik',
            'pengalaman_ekskul', 'kepribadian'
        ];

        foreach ($fieldsToUpdate as $field) {
            // Jika sudah pernah terisi dan input dikosongkan, jangan timpa dengan data kosong
            if (in_array($field, ['pekerjaan_ayah', 'pekerjaan_ibu', 'pendapatan_ortu']) && empty($request->input($field)) && !empty($biodata->{$field})) {
                continue;
            }
            if ($request->has($field)) {
                $biodata->{$field} = $request->input($field);
            }
        }

        $biodata->siswas_id = $siswa->id;
        $biodata->fotorumah_url = $fotoRumahPath;

        // Kepemilikan rumah telah dihapus
        $biodata->kepemilikan_rumah = null;

        // NIS dilindungi dari edit oleh siswa (hanya diisi kurikulum atau walas)
        $biodata->nis = $originalNis;

        // Wali Kelas, Kelas, dan Kompetensi otomatis dari rombel
        if ($siswa->rombel) {
            $biodata->walas_id = $siswa->rombel->walas_id ?? $biodata->walas_id;
            $biodata->kelas = $siswa->rombel->tingkat ?? ($siswa->rombel->nama_kelas ?? $biodata->kelas);
            $biodata->kompetensi = $siswa->rombel->kompetensi ?? $biodata->kompetensi;
        }

        // Simpan data yang telah diubah
        $biodata->save();

        // Sinkronisasi ke daftar peserta didik
        \App\Models\DaftarPesertaDidik::updateOrCreate(
            ['nama_siswa' => $siswa->id],
            [
                'walas_id' => $biodata->walas_id ?? 1,
                'nis' => $biodata->nis,
                'nisn' => $biodata->nisn,
                'jenis_kelamin' => $biodata->jenis_kelamin ?? 'Laki-laki',
                'keterangan' => 'Aktif',
                'tanggal' => now()->toDateString(),
            ]
        );

        // Redirect ke halaman dengan pesan sukses
        return redirect('/datadiripage')->with([
            'success' => 'Data berhasil diperbarui!',
            'biodatas' => BiodataSiswa::all(),
            'siswa' => $siswa,
            'walas' => DB::table('walas')->select('id', 'nama')->get()
        ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BiodataSiswa::destroy($id);
        return redirect()->route('inputdatadiri.index')->with('success', 'Data berhasil dihapus!');
    }
}
