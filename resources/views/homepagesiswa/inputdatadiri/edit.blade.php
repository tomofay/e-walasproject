<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Siswa</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('images/logokampak.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css?v=2') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: iLanding
  * Template URL: https://bootstrapmade.com/ilanding-bootstrap-landing-page-template/
  * Updated: Nov 12 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
        /* Kotak pesan */
        .alert {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            z-index: 9999;
            text-align: center;
            font-size: 16px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.5s ease-out;
            box-sizing: border-box;
            max-height: 60px; /* Menentukan tinggi kotak pesan agar tidak terlalu panjang */
            overflow: hidden;
            
            /* Flexbox untuk menyejajarkan teks di tengah */
            display: flex;
            justify-content: center; /* Mengatur teks ke tengah secara horizontal */
            align-items: center; /* Mengatur teks ke tengah secara vertikal */
        }

        .alert-danger {
            background-color: #e74c3c; /* Merah */
        }

        .alert-success {
            background-color: #2ecc71; /* Hijau */
        }

        /* Animasi slide down */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        /* Animasi slide up untuk saat pesan hilang */
        @keyframes slideUp {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-100%);
            }
        }

        /* Styling untuk tabel */
.table {
  width: 300%;
  border-collapse: collapse;
}

.table th, .table td {
  padding: 8px;
  text-align: left;
}

.table .btn {
  margin-right: 5px;
}

    </style>

<style>
 table {
    width: 310%;
    border-collapse: collapse; /* Menghilangkan ruang antara sel */
    border-radius: 8px; /* Sudut melengkung untuk tabel */
    overflow: hidden; /* Untuk memastikan konten tidak melampaui sudut melengkung */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan di sekitar tabel */
  }
  th, td {
    text-align: center; /* Menyelaraskan teks ke tengah */
    padding: 12px; /* Memberikan ruang dalam sel tabel */
    border: 1px solid #ddd; /* Menambahkan border di sekitar sel */
  }
  th {
    background-color: #f4f4f4; /* Warna latar belakang untuk header tabel */
    font-weight: bold; /* Membuat teks header lebih tebal */
  }
  td {
    background-color: #fff; /* Warna latar belakang untuk baris data */
  }
  tr:nth-child(even) td {
    background-color: #f9f9f9; /* Warna latar belakang untuk baris genap */
  }
  button {
    border-radius: 5px; /* Menambahkan sudut melengkung pada tombol */
  }

  .btn {
    border-radius: 10px; /* Membuat tombol melengkung */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan */
    transition: all 0.3s ease; /* Transisi halus untuk efek hover */
}

.btn-primary {
    background-color: #007bff; /* Warna biru untuk tombol utama */
    color: #fff;
}

.btn-primary:hover {
    background-color: #3399ff; /* Biru muda saat hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar saat hover */
}

.btn-danger {
    background-color: #dc3545; /* Warna merah untuk tombol batal */
    color: #fff;
}

.btn-danger:hover {
    background-color: #ff6666; /* Merah muda saat hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar saat hover */
}


.custom-btn {
        background-color: rgba(128, 128, 128, 0.5); /* Abu-abu transparan */
        color: white; /* Warna teks putih */
        border: none;
        padding: 10px 16px;
        font-size: 16px;
        border-radius: 10px; /* Kotak dengan lengkungan sedikit */
        cursor: pointer;
        transition: background 0.3s ease-in-out;
}

.custom-btn:hover {
        background-color: #50D6DA; /* Warna biru saat hover */
        box-shadow: 0px 6px 12px rgb(206, 206, 206);
}

/* Mengatur tampilan grid agar lebih rapi */
#pendapatan_ortu {
    padding: 0;
    margin: 0;
}

/* Styling untuk setiap item dalam list */
#pendapatan_ortu li {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 15px;
    padding: 8px;
    border-radius: 8px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

/* Efek hover untuk item */
#pendapatan_ortu li:hover {
    background-color: #f0f8ff;
    transform: scale(1.05);
}

/* Menambahkan icon atau gambar checkbox kecil di sebelah label untuk tampilan lebih menarik */
#pendapatan_ortu input[type="radio"] {
    margin-right: 10px;
    accent-color: #007bff;
}

/* Styling label supaya lebih jelas dan terpisah dengan baik */
#pendapatan_ortu label {
    font-size: 16px;
    font-weight: 500;
    color: #333;
}

/* Responsif untuk layar kecil */
@media (max-width: 767px) {
    #pendapatan_ortu li {
        flex: 0 0 50%; /* 2 kolom di layar kecil */
    }
}

</style>
  @include('partials.btn_back_style')
</head>

<body class="index-page">
     <!-- Tampilkan pesan error -->
     @if (session('error'))
        <div class="alert alert-danger" id="alertError">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Tampilkan pesan success -->
    @if (session('success'))
        <div class="alert alert-success" id="alertSuccess">
            <p>{{ session('success') }}</p>
        </div>
    @endif

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/siswapage" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        <li><a href="/datadiri" >Beranda</a></li>
        <li><a href="/datadiripage" >Data Diri</a></li>
          <li><a href="/inputdatadiri">Input Data Diri</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="user-info d-flex align-items-center">
            @if(session()->has('siswa_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilesiswa" class="text-decoration-none">
                    <span>{{ $siswa->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif

            <form action="{{ route('logoutsiswa') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn-getstarted">Logout</button>
            </form>
        </div>
      

    </div>
  </header>

  <main class="main">
    

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            
             <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <div class="company-badge mb-4">
                <i class="bi bi-gear-fill me-2"></i>
                    Edit Biodata Diri
              </div>
                <a href="{{ route('datadiripage.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Data Diri
                </a>
            </div> 

              <!-- <h1 class="mb-4">
               Kelola Data Diri Siswa <br>
                <span class="accent-text">SMK Negeri 1 Cibinong</span>
              </h1> -->

              <!-- <div class="hero-buttons">
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn btn-link tutorial-btn mt-2 mt-sm-0 glightbox">
                    <i class="bi bi-play-circle me-1"></i>
                    Tutorial Penggunaan Website
                </a> 
            </div> -->
            </div>
          </div>

          <div class="col-lg-6">
            <!-- <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
              <img src="assets/img/illustration-1.webp" alt="Hero Image" class="img-fluid">
            </div> -->
          </div>
        </div>

        <div class="row stats-row gy-100 mt-9 justify-content-start align-items-start" data-aos="fade-up" data-aos-delay="500">
        <div class="col-lg-12">
    <br>
    <div class="col-lg-12">
    <br>
    <h1 class="mb-4 text-center">
        Edit Biodata Diri <br>
        <span class="accent-text"></span>
    </h1>
    <br>
    <form action="{{ route('biodatasiswa.update', $biodata->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
            <h4 class="text-bold">Data Pribadi</h4>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $biodata->nama_lengkap ?? '') }}" required>
                </div>
            </div>  
            <div class="row mb-3">
                <div class="col-12">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control w-100" required>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Wali Kelas</label>
                    <input type="text" class="form-control bg-light" value="{{ $siswa->rombel?->walas?->nama ?? ($biodata->walas?->nama ?? 'Belum ditentukan') }}" readonly tabindex="-1">
                    <input type="hidden" name="walas_id" value="{{ $siswa->rombel?->walas_id ?? $biodata->walas_id }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control w-100" value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control w-100" value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control w-100" rows="3" required>{{ old('alamat', $biodata->alamat ?? '') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="alamat_maps" class="form-label">Alamat Maps</label>
                    <textarea name="alamat_maps" id="alamat_maps" class="form-control w-100" rows="3" required>{{ old('alamat_maps', $biodata->alamat_maps ?? '') }}</textarea>
                </div>
            </div>

            <!-- Foto Rumah (Gambar) -->
            <div class="mb-3">
                <label for="fotorumah_url" class="form-label">Unggah Foto Depan Rumah (Gambar):</label>
                <input type="file" name="fotorumah_url" id="fotorumah_url" class="form-control" accept="image/*">
                <small>Jika tidak ingin mengubah gambar, biarkan kosong.</small>
                <small id="fileWarning" class="text-danger d-none">Ukuran file tidak boleh lebih dari 2 MB!</small>
                @if($biodata->fotorumah_url)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $biodata->fotorumah_url) }}" alt="Foto Rumah" class="img-thumbnail" width="100">
                    </div>
                @endif
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="jalur_masuk" class="form-label">Jalur Masuk / SPMB</label>
                    <input type="text" name="jalur_masuk" id="jalur_masuk" class="form-control w-100" placeholder="Contoh: Rapor / Zonasi / SPMB Bersama / Prestasi" list="jalur_masuk_list" value="{{ old('jalur_masuk', $biodata->jalur_masuk ?? '') }}" required>
                    <datalist id="jalur_masuk_list">
                        <option value="Rapor">
                        <option value="Zonasi">
                        <option value="SPMB Bersama">
                        <option value="Prestasi">
                        <option value="Afirmasi">
                        <option value="Anak Guru">
                        <option value="Perpindahan Orang Tua">
                    </datalist>
                    <small class="text-muted"><i class="bi bi-pencil-square me-1"></i>Input manual sesuai jalur masuk / SPMB Anda.</small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jarak_rumah" class="form-label">Jarak Rumah (KM)</label>
                    <input type="text" placeholder="dalam Kilometer (cth. 3 km)" name="jarak_rumah" id="jarak_rumah" class="form-control" value="{{ old('jarak_rumah', $biodata->jarak_rumah ?? '') }}" maxlength="255" required>
                </div>
                <div class="col-md-6">
                    <label for="transportasi_sekolah" class="form-label">Transportasi ke Sekolah</label>
                    <input type="text" name="transportasi_sekolah" id="transportasi_sekolah" class="form-control" value="{{ old('transportasi_sekolah', $biodata->transportasi_sekolah ?? '') }}" maxlength="255" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="transportasi_rumah" class="form-label">Transportasi ke Rumah</label>
                    <input type="text" name="transportasi_rumah" id="transportasi_rumah" class="form-control" value="{{ old('transportasi_rumah', $biodata->transportasi_rumah ?? '') }}" maxlength="255" required>
                </div>
                <div class="col-md-6">
                    <label for="agama" class="form-label">Agama</label>
                    <select name="agama" id="agama" class="form-control" required>
                        <option value="Islam" {{ old('agama', $biodata->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen Protestan" {{ old('agama', $biodata->agama ?? '') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                        <option value="Kristen Katolik" {{ old('agama', $biodata->agama ?? '') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                        <option value="Hindu" {{ old('agama', $biodata->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ old('agama', $biodata->agama ?? '') == 'Budha' ? 'selected' : '' }}>Budha</option>
                        <option value="Konghucu" {{ old('agama', $biodata->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                    <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $biodata->kewarganegaraan ?? '') }}" maxlength="20" required>
                </div>
                <div class="col-md-3">
                    <label for="anak_ke" class="form-label">Anak Ke</label>
                    <input type="number" name="anak_ke" id="anak_ke" class="form-control" value="{{ old('anak_ke', $biodata->anak_ke ?? '') }}" maxlength="5" required>
                </div>
                <div class="col-md-3">
                    <label for="jumlah_saudara" class="form-label">Jumlah Saudara</label>
                    <input type="number" name="jumlah_saudara" id="jumlah_saudara" class="form-control" value="{{ old('jumlah_saudara', $biodata->jumlah_saudara ?? '') }}" maxlength="5" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" id="no_wa" class="form-control" value="{{ old('no_wa', $biodata->no_wa ?? '') }}" maxlength="15" placeholder="Contoh: 081234567890" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $biodata->email ?? '') }}" maxlength="50" placeholder="Contoh: email@example.com" required>
                </div>
            </div>

            <div class="row mb-3">
                @php
                    $resolvedNis = old('nis', $biodata->nis ?: (\App\Models\DaftarPesertaDidik::where('nama_siswa', $biodata->siswas_id ?? ($siswa->id ?? null))->value('nis') ?? ''));
                @endphp
                <div class="col-md-6">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" name="nis" id="nis" class="form-control bg-light" value="{{ $resolvedNis }}" placeholder="{{ $resolvedNis ? 'NIS' : 'Belum diisi oleh Walas / Kurikulum' }}" readonly tabindex="-1">
                    @if($resolvedNis)
                        <small class="text-success"><i class="bi bi-check-circle-fill"></i> NIS sudah diisi oleh Walas / Kurikulum</small>
                    @else
                        <small class="text-muted"><i class="bi bi-info-circle"></i> NIS akan diisi oleh Walas atau Kurikulum</small>
                    @endif
                </div>
                <div class="col-md-6">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="form-control" value="{{ old('nisn', $biodata->nisn ?: (\App\Models\DaftarPesertaDidik::where('nama_siswa', $biodata->siswas_id ?? ($siswa->id ?? null))->value('nisn') ?? '')) }}" maxlength="20" placeholder="Masukkan NISN Anda" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kelas</label>
                    <input type="text" class="form-control bg-light" value="{{ $siswa->rombel?->tingkat ?? ($siswa->rombel?->nama_kelas ?? ($biodata->kelas ?? 'Belum ditentukan')) }}" readonly tabindex="-1">
                    <input type="hidden" name="kelas" value="{{ $siswa->rombel?->tingkat ?? ($siswa->rombel?->nama_kelas ?? ($biodata->kelas ?? 'X')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kompetensi</label>
                    <input type="text" class="form-control bg-light" value="{{ $siswa->rombel?->kompetensi ?? ($biodata->kompetensi ?? 'Belum ditentukan') }}" readonly tabindex="-1">
                    <input type="hidden" name="kompetensi" value="{{ $siswa->rombel?->kompetensi ?? ($biodata->kompetensi ?? 'SIJA') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                    <input type="text" name="tahun_masuk" id="tahun_masuk" class="form-control" value="{{ old('tahun_masuk', $biodata->tahun_masuk ?? '') }}" required>
                </div>
            </div>  
                <br><br>
                <h4 class="text-bold">Data Orang Tua atau Wali</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" value="{{ old('nama_ayah', $biodata->nama_ayah ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        @php
                            $stdPekerjaanAyah = ['TNI/POLRI', 'ASN/PNS', 'Karyawan', 'Wiraswasta', 'Pengemudi', 'Buruh', 'Tani', 'Pensiunan'];
                            $curPekerjaanAyah = old('pekerjaan_ayah', $biodata->pekerjaan_ayah ?? '');
                            $hasAyahJob = !empty($curPekerjaanAyah);
                            $isOtherAyah = $hasAyahJob && !in_array($curPekerjaanAyah, $stdPekerjaanAyah);
                        @endphp
                        <label for="pekerjaan_ayah" class="form-label">
                            Pekerjaan Ayah
                            @if(!$hasAyahJob)<span class="text-danger">*</span>@endif
                        </label>
                        @if($hasAyahJob)
                            <div class="mb-2">
                                <span class="badge bg-success-subtle text-success border border-success p-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Sudah terisi: <strong>{{ $curPekerjaanAyah }}</strong> (Tidak perlu memilih lagi jika tidak ada perubahan)
                                </span>
                            </div>
                        @endif
                        <ul id="pekerjaan_ayah" class="list-unstyled d-flex flex-wrap">
                            @foreach($stdPekerjaanAyah as $job)
                                <li class="col-md-6">
                                    <input type="radio" name="pekerjaan_ayah" value="{{ $job }}" id="ayah_{{ Str::slug($job, '_') }}" onchange="togglePekerjaanInput()" {{ $curPekerjaanAyah === $job ? 'checked' : '' }} {{ $hasAyahJob ? '' : 'required' }}> 
                                    <label for="ayah_{{ Str::slug($job, '_') }}">{{ $job }}</label>
                                </li>
                            @endforeach
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Lainnya" id="ayah_lainnya" onchange="togglePekerjaanInput()" {{ $isOtherAyah ? 'checked' : '' }} {{ $hasAyahJob ? '' : 'required' }}> 
                                <label for="ayah_lainnya">Lainnya</label>
                            </li>
                        </ul>
                        <input type="text" name="pekerjaan_ayah_lainnya" id="pekerjaan_ayah_lainnya" class="form-control mt-2" placeholder="Masukkan pekerjaan lain..." value="{{ $isOtherAyah ? $curPekerjaanAyah : old('pekerjaan_ayah_lainnya', '') }}" style="display: {{ $isOtherAyah ? 'block' : 'none' }};">
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah</label>
                        <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" class="form-control" maxlength="50" placeholder="Contoh: Jakarta" value="{{ old('tempat_lahir_ayah', $biodata->tempat_lahir_ayah ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah</label>
                        <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" class="form-control" value="{{ old('tanggal_lahir_ayah', $biodata->tanggal_lahir_ayah ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alamat_ayah" class="form-label">Alamat Ayah</label>
                        <textarea name="alamat_ayah" id="alamat_ayah" class="form-control" rows="3" placeholder="Contoh: Jl. Mawar No. 123, Jakarta" required>{{ old('alamat_ayah', $biodata->alamat_ayah ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="no_wa_ayah" class="form-label">Nomor WhatsApp Ayah</label>
                        <input type="text" name="no_wa_ayah" id="no_wa_ayah" class="form-control" maxlength="15" placeholder="Contoh: 081234567890" value="{{ old('no_wa_ayah', $biodata->no_wa_ayah ?? '') }}" required readonly>
                        <button type="button" class="custom-btn mt-2" data-bs-toggle="modal" data-bs-target="#errorModal">Kesalahan data?</button>
                    </div>

                    <!-- Modal untuk Perubahan Nomor Ayah -->
                    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="errorModalLabel">Kesalahan Data Nomor WhatsApp Ayah?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p>Silakan hubungi Walas untuk merubah data.</p>
                                    <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>

                                    <!-- Input Manual Nama Siswa & Nomor Telepon Baru -->
                                    <input type="text" id="studentNameAyah" class="form-control mb-2" placeholder="Masukkan Nama Siswa">
                                    <input type="text" id="newPhoneNumberAyah" class="form-control mb-2" placeholder="Masukkan Nomor Baru (Contoh : 6248109804234)">

                                    @if($walas && $walas->no_wa)
                                        <button onclick="sendWhatsAppMessageAyah()" class="btn btn-success mt-3">
                                            <i class="fab fa-whatsapp"></i> Kirim ke Walas
                                        </button>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ old('nama_ibu', $biodata->nama_ibu ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        @php
                            $stdPekerjaanIbu = ['TNI/POLRI', 'ASN/PNS', 'Karyawan', 'Wiraswasta', 'Ibu Rumah Tangga', 'Buruh', 'Tani', 'Pensiunan'];
                            $curPekerjaanIbu = old('pekerjaan_ibu', $biodata->pekerjaan_ibu ?? '');
                            $hasIbuJob = !empty($curPekerjaanIbu);
                            $isOtherIbu = $hasIbuJob && !in_array($curPekerjaanIbu, $stdPekerjaanIbu);
                        @endphp
                        <label for="pekerjaan_ibu" class="form-label">
                            Pekerjaan Ibu
                            @if(!$hasIbuJob)<span class="text-danger">*</span>@endif
                        </label>
                        @if($hasIbuJob)
                            <div class="mb-2">
                                <span class="badge bg-success-subtle text-success border border-success p-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Sudah terisi: <strong>{{ $curPekerjaanIbu }}</strong> (Tidak perlu memilih lagi jika tidak ada perubahan)
                                </span>
                            </div>
                        @endif
                        <ul id="pekerjaan_ibu" class="list-unstyled d-flex flex-wrap">
                            @foreach($stdPekerjaanIbu as $job)
                                <li class="col-md-6">
                                    <input type="radio" name="pekerjaan_ibu" value="{{ $job }}" id="ibu_{{ Str::slug($job, '_') }}" onchange="togglePekerjaanInput()" {{ $curPekerjaanIbu === $job ? 'checked' : '' }} {{ $hasIbuJob ? '' : 'required' }}> 
                                    <label for="ibu_{{ Str::slug($job, '_') }}">{{ $job }}</label>
                                </li>
                            @endforeach
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Lainnya" id="ibu_lainnya" onchange="togglePekerjaanInput()" {{ $isOtherIbu ? 'checked' : '' }} {{ $hasIbuJob ? '' : 'required' }}> 
                                <label for="ibu_lainnya">Lainnya</label>
                            </li>
                        </ul>
                        <input type="text" name="pekerjaan_ibu_lainnya" id="pekerjaan_ibu_lainnya" class="form-control mt-2" placeholder="Masukkan pekerjaan lain..." value="{{ $isOtherIbu ? $curPekerjaanIbu : old('pekerjaan_ibu_lainnya', '') }}" style="display: {{ $isOtherIbu ? 'block' : 'none' }};">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu</label>
                        <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" class="form-control" maxlength="50" placeholder="Contoh: Jakarta" value="{{ old('tempat_lahir_ibu', $biodata->tempat_lahir_ibu ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu</label>
                        <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" class="form-control" value="{{ old('tanggal_lahir_ibu', $biodata->tanggal_lahir_ibu ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alamat_ibu" class="form-label">Alamat Ibu</label>
                        <textarea name="alamat_ibu" id="alamat_ibu" class="form-control" rows="3" placeholder="Contoh: Jl. Mawar No. 123, Jakarta" required>{{ old('alamat_ibu', $biodata->alamat_ibu ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="no_wa_ibu" class="form-label">Nomor WhatsApp Ibu</label>
                        <input type="text" name="no_wa_ibu" id="no_wa_ibu" class="form-control" maxlength="15" placeholder="Contoh: 6281234567890" value="{{ old('no_wa_ibu', $biodata->no_wa_ibu ?? '') }}" required>
                        <button type="button" class="custom-btn mt-2" data-bs-toggle="modal" data-bs-target="#errorModal2">Kesalahan data?</button>
                    </div>

                    <!-- Modal untuk Perubahan Nomor Ibu -->
                        <div class="modal fade" id="errorModal2" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="errorModalLabel">Kesalahan Data Nomor WhatsApp Ibu?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <p>Silakan hubungi Walas dengan mengisi data untuk merubah data.</p>
                                        <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                                        
                                        <input type="text" id="studentNameIbu" class="form-control mb-2" placeholder="Masukkan Nama Siswa">
                                        <input type="text" id="newPhoneNumberIbu" class="form-control mb-2" placeholder="Masukkan Nomor Baru (Contoh : 62412384091)">
                                        
                                        @if($walas && $walas->no_wa)
                                            <button onclick="sendWhatsAppMessageIbu()" class="btn btn-secondary mt-3">
                                                <i class="fab fa-whatsapp"></i> Kirim ke Walas
                                            </button>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <br><br>
                <h4 class="text-bold">Rentang Pendapatan Kedua Orangtua</h4>
                    @php
                        $stdPendapatan = [
                            'Kurang dari Rp1.000.000,00',
                            'Rp1.000.000,00 - Rp3.000.000,00',
                            'Rp3.000.000,00 - Rp5.000.000,00',
                            'Rp5.000.000,00 - Rp10.000.000,00',
                            'Rp10.000.000,00 - Rp25.000.000,00',
                            'Rp25.000.000,00 - Rp50.000.000,00',
                            'Lebih dari Rp50.000.000,00',
                        ];
                        $curPendapatan = old('pendapatan_ortu', $biodata->pendapatan_ortu ?? '');
                        $hasPendapatan = !empty($curPendapatan);
                    @endphp
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="pendapatan_ortu" class="form-label">Pendapatan Ayah dan Ibu</label>
                            @if($hasPendapatan)
                                <div class="mb-2">
                                    <span class="badge bg-success-subtle text-success border border-success p-2">
                                        <i class="bi bi-check-circle-fill me-1"></i> Sudah terisi: <strong>{{ $curPendapatan }}</strong> (Tidak perlu memilih lagi jika tidak ada perubahan)
                                    </span>
                                </div>
                            @endif
                            <ul id="pendapatan_ortu" class="list-unstyled d-flex flex-wrap">
                                @foreach($stdPendapatan as $idx => $pendapatan)
                                    <li class="col-md-3 col-sm-6">
                                        <input type="radio" name="pendapatan_ortu" value="{{ $pendapatan }}" id="pendapatan_{{ $idx }}" {{ $curPendapatan === $pendapatan ? 'checked' : '' }}>
                                        <label for="pendapatan_{{ $idx }}">{{ $pendapatan }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                
                <h4>Data Pendidikan Sebelumnya</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="namasekolah_asal" class="form-label">Nama Sekolah Asal</label>
                        <input type="text" name="namasekolah_asal" id="namasekolah_asal" class="form-control" maxlength="50" placeholder="Contoh: SMP 1 Cibinong" value="{{ old('namasekolah_asal', $biodata->namasekolah_asal ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control" maxlength="4" placeholder="Contoh: 2024" value="{{ old('tahun_lulus', $biodata->tahun_lulus ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="alamat_sekolah" class="form-label">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" id="alamat_sekolah" class="form-control" rows="3" placeholder="Contoh: Jl. Raya Bogor KM 46, Cibinong, Bogor" required>{{ old('alamat_sekolah', $biodata->alamat_sekolah ?? '') }}</textarea>
                    </div>
                </div>
                <br>
                <h4>Riwayat Penyakit</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                        <input type="text" name="riwayat_penyakit" id="riwayat_penyakit" class="form-control" value="{{ old('riwayat_penyakit', $biodata->riwayat_penyakit ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="alergi" class="form-label">Alergi</label>
                        <input type="text" name="alergi" id="alergi" class="form-control" value="{{ old('alergi', $biodata->alergi ?? '') }}">
                    </div>
                </div>
                <br>
                <h4>Prestasi dan Pengalaman</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="prestasi_akademik" class="form-label">Prestasi Akademik</label>
                        <textarea name="prestasi_akademik" id="prestasi_akademik" class="form-control" rows="3">{{ old('prestasi_akademik', $biodata->prestasi_akademik ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="prestasi_non_akademik" class="form-label">Prestasi Non-Akademik</label>
                        <textarea name="prestasi_non_akademik" id="prestasi_non_akademik" class="form-control" rows="3">{{ old('prestasi_non_akademik', $biodata->prestasi_non_akademik ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pengalaman_ekskul" class="form-label">Pengalaman Ekskul</label>
                        <textarea name="pengalaman_ekskul" id="pengalaman_ekskul" class="form-control" rows="3">{{ old('pengalaman_ekskul', $biodata->pengalaman_ekskul ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="kepribadian" class="form-label">Kepribadian</label>
                        <textarea name="kepribadian" id="kepribadian" class="form-control" rows="3">{{ old('kepribadian', $biodata->kepribadian ?? '') }}</textarea>
                    </div>
                </div>
            <div class="d-flex justify-content-end">
                
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</section><!-- /Hero Section -->

</main>
  
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SIJA SMKN 1 Cibinong</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
  function togglePekerjaanInput() {
    var ayahChecked = document.querySelector('input[name="pekerjaan_ayah"]:checked');
    var ayahInput = document.getElementById("pekerjaan_ayah_lainnya");
    if (ayahInput) {
        if (ayahChecked && ayahChecked.value === "Lainnya") {
            ayahInput.style.display = "block";
        } else {
            ayahInput.style.display = "none";
        }
    }

    var ibuChecked = document.querySelector('input[name="pekerjaan_ibu"]:checked');
    var ibuInput = document.getElementById("pekerjaan_ibu_lainnya");
    if (ibuInput) {
        if (ibuChecked && ibuChecked.value === "Lainnya") {
            ibuInput.style.display = "block";
        } else {
            ibuInput.style.display = "none";
        }
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    togglePekerjaanInput();

    document.querySelectorAll('input[name="pekerjaan_ayah"]').forEach(function (radio) {
        radio.addEventListener("change", togglePekerjaanInput);
    });

    document.querySelectorAll('input[name="pekerjaan_ibu"]').forEach(function (radio) {
        radio.addEventListener("change", togglePekerjaanInput);
    });
  });
  </script>

<script>
function sendWhatsAppMessageAyah() {
    var studentName = document.getElementById("studentNameAyah").value.trim();
    var phoneNumber = document.getElementById("newPhoneNumberAyah").value.trim();
    
    if (studentName === "" || phoneNumber === "" || isNaN(phoneNumber)) {
        alert("Masukkan nama dan nomor telepon yang valid!");
        return;
    }

    var walasPhoneNumber = "{{ $walas->no_wa ?? '' }}"; // Ambil nomor WA Walas

    if (walasPhoneNumber === "") {
        alert("Nomor WhatsApp Walas tidak tersedia.");
        return;
    }

    var message = encodeURIComponent(
        "Mengubah Nomor Telepon Orang Tua\n\n" +
        "Nama Siswa: " + studentName + "\n" +
        "No Telp yang dirubah: Ayah\n" +
        "No Telp Baru: " + phoneNumber
    );

    var waUrl = "https://wa.me/" + walasPhoneNumber + "?text=" + message;
    window.open(waUrl, "_blank");
}
</script>


<script>
function sendWhatsAppMessageIbu() {
    var studentName = document.getElementById("studentNameIbu").value.trim();
    var phoneNumber = document.getElementById("newPhoneNumberIbu").value.trim();
    
    if (studentName === "" || phoneNumber === "" || isNaN(phoneNumber)) {
        alert("Masukkan nama dan nomor telepon yang valid!");
        return;
    }

    var walasPhoneNumber = "{{ $walas->no_wa ?? '' }}"; // Ambil nomor WA Walas

    if (walasPhoneNumber === "") {
        alert("Nomor WhatsApp Walas tidak tersedia.");
        return;
    }

    var message = encodeURIComponent(
        "Mengubah Nomor Telepon Orang Tua\n\n" +
        "Nama Siswa: " + studentName + "\n" +
        "No Telp yang dirubah: Ibu\n" +
        "No Telp Baru: " + phoneNumber
    );

    var waUrl = "https://wa.me/" + walasPhoneNumber + "?text=" + message;
    window.open(waUrl, "_blank");
}
</script>

<script>
    document.getElementById("fotorumah_url").addEventListener("change", function () {
        let file = this.files[0]; 
        let warning = document.getElementById("fileWarning");

        if (file && file.size > 2 * 1024 * 1024) { // 2 MB dalam bytes
            warning.classList.remove("d-none"); // Munculkan peringatan
        } else {
            warning.classList.add("d-none"); // Sembunyikan peringatan
        }
    });
</script>

</body>

</html>