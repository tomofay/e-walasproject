<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong- Walas</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="images/logokampak.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

   <!-- Unicons CSS -->
   <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />


  <!-- Main CSS File -->
  <link href="assets/css/main.css?v=2" rel="stylesheet">

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

        
    </style>

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

        /* Style untuk modal */
.modal-content {
    border-radius: 15px;
    box-shadow: 0 8px 14px rgba(0, 0, 255, 0.2); /* Bayangan biru */
    padding: 20px;
}

/* Style form dalam 2 kolom */
.modal-body form {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Membagi menjadi 2 kolom */
    gap: 20px;
}

/* Mengatur elemen yang membentang penuh */
.modal-body form .mb-3 {
    grid-column: span 1;
}

.modal-body form .mb-3:last-child {
    grid-column: span 2; /* Password dan NIP membentang 2 kolom */
}

/* Style untuk tombol secara umum */
.modal-footer {
    justify-content: flex-start; /* Posisi ke kiri */
    padding-right: 100px;
}

.modal-footer button {
    width: 100px;
    border-radius: 8px;
    transition: all 0.3s ease; /* Efek transisi halus */
}

/* Tombol Tutup */
.modal-footer .btn-secondary {
    background-color: #6c757d; /* Warna default */
    border: none;
}

/* Hover Tombol Tutup */
.modal-footer .btn-secondary:hover {
    background-color: #adb5bd; /* Warna lebih muda saat hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Bayangan saat hover */
}

/* Tombol Tambah Data */
.modal-footer .btn-success {
    background-color: #0d6efd; /* Biru muda */
    border: none;
}

/* Hover Tombol Tambah Data */
.modal-footer .btn-success:hover {
    background-color: #70b0ff; /* Biru yang lebih muda saat hover */
    box-shadow: 0 8px 16px rgba(13, 110, 253, 0.4); /* Bayangan biru saat hover */
}

/* Style input dan select */
.modal-body input,
.modal-body select {
    border-radius: 5px;
    border: 1px solid #ced4da;
    padding: 8px;
}

/* Style untuk file upload */
.modal-body input[type="file"] {
    padding: 5px;
}

.modal-dialog {
    max-width: 800px; /* Lebar maksimum modal */
    width: 90%;       /* Lebar modal relatif */
}

.d-flex-container {
    display: flex;
    align-items: center;  /* Menjaga semua elemen dalam container sejajar secara vertikal */
    gap: 10px;  /* Menambah jarak antar elemen */
}

.ms-3 {
    margin-left: 1rem;
}

.me-2 {
    margin-right: 0.5rem;
}

</style>

<style>

.input-box {
  position: relative;
  height: 55px;
  max-width: 900px;
  width: 100%;
  background: #fff;
  margin: 0 20px;
  border-radius: 8px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}
.input-box i,
.input-box .button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}
.input-box i {
  left: 20px;
  font-size: 30px;
  color: #707070;
}
.input-box input {
  height: 100%;
  width: 100%;
  outline: none;
  font-size: 18px;
  font-weight: 400;
  border: none;
  padding: 0 155px 0 65px;
  background-color: transparent;
}
.input-box .button {
  right: 25px;
  font-size: 15px;
  font-weight: 300;
  color: #fff;
  border: none;
  padding: 12px 30px;
  border-radius: 6px;
  background-color:  #0d83fd;
  cursor: pointer;
}
.input-box .button:active {
  transform: translateY(-50%) scale(0.98);
}

.button {
    background-color: #007bff; /* Warna latar belakang tombol */
    color: white; /* Warna teks tombol menjadi putih */
    font-weight: bold; /* Membuat teks menjadi tebal/bold */
    border: 2px solid #007bff; /* Warna border yang sesuai dengan tombol */
    border-radius: 5px; /* Membuat sudut tombol melengkung */
    padding: 10px 20px; /* Menambahkan padding agar tombol lebih besar */
    font-size: 16px; /* Ukuran font lebih besar */
    cursor: pointer; /* Menampilkan kursor pointer ketika dihover */
    transition: background-color 0.3s ease; /* Efek transisi pada background saat hover */
}

/* Efek hover */
.button:hover {
    background-color: #0056b3; /* Mengubah warna latar belakang saat hover */
    border-color: #0056b3; /* Mengubah warna border saat hover */
}

/* Pastikan tabel bisa di-scroll pada layar kecil */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* Pastikan modal tidak terlalu besar di layar kecil */
@media (max-width: 576px) {
    .modal-dialog {
        max-width: 90%;
        margin: auto;
    }
}

/* Sesuaikan elemen input dan tombol agar responsif */
.input-box input {
    width: 100%;
}

.input-box .button {
    white-space: nowrap;
}

/* Agar tombol tetap sejajar dengan baik */
.d-flex.gap-2 {
    flex-wrap: wrap;
}

/* Responsif untuk tombol aksi */
@media (max-width: 768px) {
    .d-flex.justify-content-center.flex-wrap {
        flex-direction: column;
        align-items: center;
    }
}

.modal-body form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.modal-body .row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.modal-body .col-md-6 {
    width: 100%;
}

@media (min-width: 768px) {
    .modal-body .col-md-6 {
        width: 48%;
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

      <a href="/walaspage" class="logo d-flex align-items-center me-auto me-xl-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali ke Halaman Home">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

     <!-- Menampilkan ikon user dan informasi walas yang sedang login -->
     <div class="user-info d-flex align-items-center">
            @if(session()->has('walas_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilewalas" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Profile">
                    <span>{{ $walas->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif
            <form action="{{ route('logoutwalas') }}" method="POST" class="ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Keluar dari Akun Anda">
                @csrf
                <button type="submit" class="btn-getstarted">Logout</button>
            </form>
        </div>
    </div>
  </header>

<main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
        <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">
            
            <div class="row g-2 align-items-center">
                <!-- Header Title -->
                <div class="col-12 mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h2 class="font-weight-bold mb-0">Daftar Siswa</h2>
                        <a href="{{ route('homepagegtk.index') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>
                    <hr class="my-3">
                </div>

                <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <!-- Tombol Unggah Data & Tambah Data -->
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#uploadSiswaModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Unggah Data Melalui Excel">
                            <i class="bi bi-cloud-upload"></i> Unggah Data
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Data Manual">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>

                    <!-- Form Cari Siswa -->
                    <form action="{{ url('siswadata_search') }}" method="GET" class="d-flex align-items-center">
                        <div class="input-box d-flex align-items-center">
                            <i class="uil uil-search"></i>
                            <input type="text" name="keyword" placeholder="Cari Siswa..." value="{{ old('keyword', $keyword ?? '') }}" required />
                            <button class="button" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Jumlah Total Siswa -->
            <div class="row mt-3">
                <div class="col-12 text-center text-md-end">
                    <span class="text-muted">
                        Jumlah Total: <strong>{{ $siswa->count() }} Siswa</strong>
                    </span>
                </div>
            </div>

            <!-- Container Table dengan Scroll jika terlalu lebar -->
<div class="d-flex align-items-center justify-content-start">
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>WhatsApp</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($siswa as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->siswa_nama }}</td>
                    <td>{{ $data->nama_kelas }}</td>
                    <td>{{ $data->jenis_kelamin }}</td>
                    <td><a href="https://wa.me/{{ $data->no_wa }}" target="_blank">{{ $data->no_wa }}</a></td>
                    <td>
                        @if(!empty($data->image_url) && $data->image_url != null)
                            <img src="{{ asset('storage/'.$data->image_url) }}" alt="Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="rounded-circle d-flex justify-content-center align-items-center" 
                                style="width: 50px; height: 50px; background-color: #E86E7A; color: white; font-size: 20px;">
                                {{ strtoupper(substr($data->siswa_nama, 0, 2)) }}
                            </div>
                        @endif
                    </td>
                    <td>{{ $data->status }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                        <button type="button" class="btn btn-primary" id="btnKeterangan_{{ $data->siswa_id }}"  onclick="showSelect(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Atur Keterangan Siswa">
                            {{ $data->keterangan ?? 'Naik Kelas' }}
                        </button>
                            <select name="keterangan" id="selectKeterangan_{{ $data->siswa_id }}" class="form-control d-none" onchange="updateButton(this, {{ $data->siswa_id }})">
                                <option value="naik_kelas">Naik Kelas</option>
                                <option value="tidak_naik_kelas">Tidak Naik Kelas</option>
                                <option value="pindah_sekolah">Pindah Sekolah</option>
                            </select>

                            <button type="button" class="btn btn-success d-none" id="btnSave_{{ $data->siswa_id }}" onclick="submitForm({{ $data->siswa_id }})">Simpan</button>

                            <form action="{{ route('siswadata.simpanKeterangan', $data->siswa_id) }}" method="POST" id="formKeterangan_{{ $data->siswa_id }}" class="d-none">
                                @csrf
                                <input type="hidden" name="nama_siswa" value="{{ $data->siswa_id }}">
                                <input type="hidden" name="keterangan" id="keteranganInput_{{ $data->siswa_id }}">
                                <input type="hidden" name="nama_kelas" value="{{ $data->nama_kelas }}">
                            </form>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            <a href="{{ route('homepagegtk.biodatasiswa', $data->siswa_id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Biodata Siswa">
                                Biodata
                            </a>
                            <a href="{{ route('siswa.edit', $data->siswa_id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data Siswa">
                                Edit
                            </a>
                            <form action="{{ route('siswa.destroy', $data->siswa_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Siswa">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

        </div>


<!-- Modal Unggah Data Siswa -->
<div class="modal fade" id="uploadSiswaModal" tabindex="-1" aria-labelledby="uploadSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadSiswaModalLabel">Unggah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/siswa-import" method="post" enctype="multipart/form-data" id="uploadSiswaForm">
                @csrf
                <div class="modal-body">
                    <!-- Tombol Download Template -->
                    <div class="mb-3">
                        <a href="{{ route('siswa.download-template') }}" class="btn btn-primary btn-sm" target="_blank">Download Template Excel</a>
                    </div>

                    <!-- Form Input -->
                    <div class="mb-3">
                        <label for="fileUploadSiswa" class="form-label">Pilih File (CSV, Excel)</label>
                        <input type="file" name="file" class="form-control" id="fileUploadSiswa" accept=".csv, .xlsx" required>
                    </div>

                    <!-- Keterangan Proses Mengunggah (Awalnya Disembunyikan) -->
                    <div id="uploadingMessage" class="alert alert-info d-none">
                        <strong>⏳ Sedang mengunggah data...</strong> Mohon tunggu.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                    <!-- Button Unggah -->
                    <button type="submit" class="btn btn-primary" id="uploadSiswaButton">Unggah</button>

                    <!-- Button Mengunggah + Spinner (Awalnya Disembunyikan) -->
                    <button id="loadingSpinnerSiswa" class="btn btn-primary d-none" type="button" disabled>
                        <span>Mengunggah...</span>
                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Loading -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">⏳ <strong>Sedang mengunggah data...</strong> Mohon tunggu.</p>
            </div>
        </div>
    </div>
</div>



<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container">
                        <div class="row g-3">
                            <div class="col-md-6 col-12">
                                <label for="studentName" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="studentName" name="nama" placeholder="Masukkan Nama Siswa" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="rombelsId" class="form-label">Rombels</label>
                                <select class="form-select" id="rombelsId" name="rombels_id" required>
                                    <option selected disabled>Pilih Rombel</option>
                                    @foreach ($rombels as $rombel)
                                        <option value="{{ $rombel->id }}">{{ $rombel->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="studentWhatsApp" class="form-label">WhatsApp</label>
                                <input type="number" class="form-control" id="studentWhatsApp" name="no_wa" placeholder="Masukkan nomor WhatsApp" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="image" class="form-label">Foto Siswa</label>
                                <input type="file" class="form-control" id="image" name="image_url" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option selected disabled>Pilih Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="gender" class="form-label">Pilih Gender</label>
                                <select class="form-select" id="gender" name="jenis_kelamin" required>
                                    <option selected disabled>Pilih Gender</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between flex-wrap">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    </div>
</section>


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
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
        window.onload = function() {
            // Cek jika ada pesan error
            var errorAlert = document.getElementById('alertError');
            var successAlert = document.getElementById('alertSuccess');

            // Jika ada pesan error, sembunyikan setelah 2 detik dengan animasi
            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.animation = 'slideUp 0.5s ease-out'; // Animasi naik
                    setTimeout(function() {
                        errorAlert.style.display = 'none'; // Sembunyikan setelah animasi selesai
                    }, 500); // Durasi animasi
                }, 2000); // Tunda selama 2 detik sebelum animasi
            }

            // Jika ada pesan success, sembunyikan setelah 2 detik dengan animasi
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.animation = 'slideUp 0.5s ease-out'; // Animasi naik
                    setTimeout(function() {
                        successAlert.style.display = 'none'; // Sembunyikan setelah animasi selesai
                    }, 500); // Durasi animasi
                }, 2000); // Tunda selama 2 detik sebelum animasi
            }
        };
    </script>
  
  <script>
    function showSelect(button) {
    let select = button.nextElementSibling;
    let saveButton = select.nextElementSibling;

    button.classList.add("d-none"); // Sembunyikan tombol utama
    select.classList.remove("d-none"); // Tampilkan select
    saveButton.classList.remove("d-none"); // Tampilkan tombol simpan
}

    function updateButton(select, siswaId) {
        // Ambil nilai dari select
        var selectedValue = select.value;
        
        // Set value untuk input hidden
        document.getElementById('keteranganInput_' + siswaId).value = selectedValue;

        // Tampilkan tombol simpan
        document.getElementById('btnSave_' + siswaId).classList.remove('d-none');
    }

    function submitForm(siswaId) {
        // Submit form menggunakan JavaScript
        document.getElementById('formKeterangan_' + siswaId).submit();
    }

</script>

<script>

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("uploadSiswaForm").addEventListener("submit", function(event) {
        console.log("⏳ Form submission started..."); // Debugging

        let uploadButton = document.getElementById("uploadSiswaButton");
        let loadingSpinner = document.getElementById("loadingSpinnerSiswa");
        let uploadingMessage = document.getElementById("uploadingMessage");

        if (uploadButton && loadingSpinner && uploadingMessage) {
            uploadButton.classList.add("d-none"); // Sembunyikan tombol unggah
            loadingSpinner.classList.remove("d-none"); // Tampilkan tombol mengunggah
            uploadingMessage.classList.remove("d-none"); // Tampilkan keterangan proses
            console.log("✅ Spinner & keterangan proses muncul!"); // Debugging
        } else {
            console.log("❌ ERROR: Elemen tidak ditemukan!"); // Debugging jika ID salah
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("uploadSiswaForm").addEventListener("submit", function (event) {
        console.log("⏳ Unggah dimulai..."); // Debugging
        
        let loadingModal = new bootstrap.Modal(document.getElementById("loadingModal"));

        // Tampilkan modal loading
        loadingModal.show();
    });
});


</script>


</body>

</html>