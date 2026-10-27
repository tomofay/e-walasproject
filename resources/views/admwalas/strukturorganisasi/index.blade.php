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

  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"rel="stylesheet"/>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: iLanding
  * Template URL: https://bootstrapmade.com/ilanding-bootstrap-landing-page-template/
  * Updated: Nov 12 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
.container {
    padding: 15px;
    max-width: 100%;
}

.tree {
    overflow-x: auto;
    white-space: nowrap;
}

.tree ul {
    position: relative;
    padding: 1em 0;
    white-space: nowrap;
    text-align: center;
}
.tree ul:before {
    content: '';
    display: block;
    width: 0;
    height: 20px;
    border-left: 1px solid #ccc;
    position: absolute;
    top: 0;
    left: 50%;
}
.tree li {
    display: inline-block;
    vertical-align: top;
    text-align: center;
    margin: 0 1em;
}
.tree li:before, .tree li:after {
    content: '';
    position: absolute;
    top: 0;
    width: 50%;
    height: 20px;
    border-top: 1px solid #ccc;
}
.tree li:after {
    left: 50%;
    border-left: 1px solid #ccc;
}
.tree li:before {
    right: 50%;
    border-right: 1px solid #ccc;
}
.node {
    display: inline-block;
    padding: 8px 12px;
    text-decoration: none;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.hero.section {
    overflow: visible;
    height: auto;
}

.starter-section {
    margin: 0 auto;
    padding: 20px;
}

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

      <a href="/adminwalas" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="user-info d-flex align-items-center">
            @if(session()->has('walas_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilewalas" class="text-decoration-none">
                    <span>{{ $walaslogin->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif
            <form action="{{ route('logoutwalas') }}" method="POST" class="ms-3">
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
        <!-- Header dengan Title, Pencarian, dan Tombol -->
        <div class="mb-4">
            <h2 class="font-weight-bold">Struktur Organisasi Kelas</h2>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex flex-wrap align-items-center justify-content-start">
                <!-- Tombol Tambah Data -->
                <a href="{{ route('strukturorganisasi.create') }}" class="btn btn-primary me-2 mb-2">
                <i class="bi bi-plus"></i> Tambah Data
            </a>
            @foreach ($struktur as $data)
                <a href="{{ route('strukturorganisasi.edit', $data->id) }}" class="btn btn-warning me-2 mb-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            @endforeach
                <!-- Tombol Unduh PDF -->
                

                <a href="{{ route('strukturorganisasi.index') }}?export=pdf" class="btn btn-outline-secondary me-2 mb-2">
                <i class="bi bi-download"></i> Unduh
            </a>
            </div>
        </div>
    </div>

        <div class="container mt-5">
    <h2 class="text-center mb-4">Struktur Organisasi Kelas</h2>

    @if ($struktur->isEmpty())
        <p class="text-center">Tidak ada data struktur organisasi.</p>
    @else
        <div class="tree">
            @foreach ($struktur as $data)
                <ul>
                    <!-- Kepala Sekolah -->
                    <li>
                        <a href="#" class="node">Kepala Sekolah<br>{{ $data->kepala_sekolah ?? 'Belum diisi' }}</a>
                        <ul>
                            <!-- Wali Kelas -->
                            <li>
                                <a href="#" class="node">Wali Kelas<br>{{ $data->wali_kelas ?? 'Belum diisi' }}</a>
                                <ul>
                                    <!-- Ketua Kelas -->
                                    <li>
                                        <a href="#" class="node">Ketua Kelas<br>{{ $data->ketua_kelas ?? 'Belum diisi' }}</a>
                                        <ul>
                                            <!-- Wakil Ketua Kelas -->
                                            <li>
                                                <a href="#" class="node">Wakil Ketua Kelas<br>{{ $data->wakil_ketua_kelas ?? 'Belum diisi' }}</a>
                                                <ul>
                                                    <!-- Bendahara & Sekretaris -->
                                                    <li>
                                                        <a href="#" class="node">Bendahara<br>{{ $data->bendahara ?? 'Belum diisi' }}</a>
                                                        <ul>
                                                            <li>
                                                                <a href="#" class="node">Seksi Kebersihan<br>{{ $data->seksi_kebersihan ?? 'Belum diisi' }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="node">Seksi Perlengkapan<br>{{ $data->seksi_perlengkapan ?? 'Belum diisi' }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="node">Sekretaris<br>{{ $data->sekretaris ?? 'Belum diisi' }}</a>
                                                        <ul>
                                                            <li>
                                                                <a href="#" class="node">Seksi Keamanan<br>{{ $data->seksi_keamanan ?? 'Belum diisi' }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="node">Seksi Kerohanian<br>{{ $data->seksi_kerohanian ?? 'Belum diisi' }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endforeach
        </div>
    @endif
</div>  
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