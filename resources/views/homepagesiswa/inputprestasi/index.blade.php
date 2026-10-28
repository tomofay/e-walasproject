<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Siswa</title>
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

  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"rel="stylesheet"/>

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

        .table th,
        .table td {
            text-align: center; /* Menyelaraskan teks ke tengah */
            vertical-align: middle; /* Menyelaraskan secara vertikal */
        }

        .table th {
            background-color: #f8f9fa; /* Memberikan latar belakang ringan pada th */
            font-weight: bold; /* Membuat font di th menjadi bold */
        }

        .table td {
            padding: 12px; /* Memberikan jarak pada sel */
        }

        .table td img {
            border-radius: 50%; /* Membuat gambar berbentuk lingkaran */
            object-fit: cover; /* Menyesuaikan gambar agar tidak terdistorsi */
        }

        /* Menambahkan sedikit ruang antara baris */
        .table tbody tr {
            border-bottom: 1px solid #e4e7ea; /* Menambahkan garis pemisah antar baris */
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

      <a href="/siswapage" class="logo d-flex align-items-center me-auto me-xl-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Home Page Siswa">
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
            @if(session()->has('siswa_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilewalas" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Profile Siswa">
                    <span>{{ $siswa->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif
            <form action="{{ route('logoutsiswa') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn-getstarted" data-bs-toggle="tooltip" data-bs-placement="top" title="Keluar dari Akun Siswa">Logout</button>
            </form>
        </div>

    </div>
  </header>

<main class="main">

       <!-- Hero Section -->
       <section id="hero" class="hero section">
    <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">
        <!-- Header dengan Title, Pencarian, dan Tombol -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h2 class="font-weight-bold mb-0">Prestasi Siswa</h2>
                <a href="{{ route('homepagesiswa.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda Siswa
                </a>
            </div>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">
                <!-- Form Cari Administrasi -->
                
                <!-- Tombol Tambah Data -->
                <!-- Membungkus tombol dan search box dengan div untuk pengaturan jarak -->
                <div class="d-flex-container">
                <a href="/prestasisiswainputcreate" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah data Prestasi Siswa">
                    <i class="bi bi-plus"></i> Tambah
                </a>
            </div>
        </div>
        <br><br>
        <div class="container mt-4">
    <h4>Prestasi Siswa</h4>

    <!-- Pesan jika data tidak ditemukan -->
    @if(isset($message))
        <div class="alert alert-warning text-center">
            {{ $message }}
        </div>
    @endif

    @if($prestasisiswa->isNotEmpty())
    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis & Prestasi</th>
                <th>Tingkat & Lokasi</th>
                <th>Pembimbing</th>
                <th>Tanggal</th>
                <th>Sertifikat</th>
                <th>Foto Dokumentasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($prestasisiswa ?? [] as $idx => $data)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>
                        <span class="badge {{ $data->jenis_prestasi == 'Akademik' ? 'bg-primary' : 'bg-success' }} mb-1">{{ $data->jenis_prestasi }}</span>
                        <div class="fw-bold">{{ $data->nama_prestasi }}</div>
                        @if($data->mata_lomba)
                            <small class="text-muted d-block"><i class="bi bi-tag"></i> {{ $data->mata_lomba }}</small>
                        @endif
                    </td>
                    <td>
                        @if($data->tingkat)
                            <span class="badge bg-info text-dark mb-1">{{ $data->tingkat }}</span>
                        @endif
                        @if($data->lokasi)
                            <small class="text-muted d-block"><i class="bi bi-geo-alt"></i> {{ $data->lokasi }}</small>
                        @endif
                        @if(!$data->tingkat && !$data->lokasi)
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        {{ $data->nama_pembimbing ?? '-' }}
                    </td>
                    <td>
                        {{ $data->tanggal ? \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td class="text-center">
                        @if($data->sertifikat_url)
                            @php
                                $fileExtension = strtolower(pathinfo($data->sertifikat_url, PATHINFO_EXTENSION));
                            @endphp
                            @if(in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif', 'webp']))
                                <a href="{{ asset('storage/'.$data->sertifikat_url) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$data->sertifikat_url) }}" style="width: 55px; height: 55px; object-fit: cover; border-radius: 4px; border: 1px solid #ced4da;" title="Lihat Sertifikat">
                                </a>
                            @else
                                <a href="{{ asset('storage/'.$data->sertifikat_url) }}" target="_blank" class="btn btn-file-bukti">
                                    <i class="bi bi-file-earmark-text"></i> Sertifikat
                                </a>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $docs = is_array($data->dokumentasi_url) 
                                ? $data->dokumentasi_url 
                                : ($data->dokumentasi_url ? [$data->dokumentasi_url] : []);
                        @endphp
                        @if(!empty($docs))
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                @foreach($docs as $doc)
                                    <a href="{{ asset('storage/'.$doc) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$doc) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ced4da;" title="Buka foto">
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <!-- Tombol Edit -->
                            <a href="{{ route('prestasisiswainput.edit', $data->id) }}" class="btn btn-primary btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data">Edit</a>
                            <!-- Tombol Delete -->
                            <form action="{{ route('prestasisiswainput.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data Prestasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    <br>
@endif

</div>

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

</body>

</html>