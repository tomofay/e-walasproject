<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong- Kepala Sekolah</title>
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

    <!-- Style Tambahan -->
<style>
/* Search Box */
.searchBox {
    position: relative;
}

.searchInput {
    border: 1px solid #ccc;
    border-radius: 20px;
    padding: 5px 35px 5px 15px;
    outline: none;
}

.searchButton {
    position: absolute;
    top: 50%;
    right: 5px;
    transform: translateY(-50%);
    border: none;
    background: none;
    cursor: pointer;
    color: #777;
}

/* Table Link Hover */
.table-link-hover:hover {
    color: #0056b3;
    text-decoration: underline;
}

/* Table */
.table-container {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.table th, .table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.9em;
    padding: 5px 10px;
}

/* Button Hover */
.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.btn-outline-secondary:hover {
    color: white;
    background-color: #6c757d;
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

      <a href="/kepsekpage" class="logo d-flex align-items-center me-auto me-xl-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Halaman Home Page Kepala Sekolah">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        <li><a href="/kepsekta" class="active" data-bs-toggle="tooltip" data-bs-placement="top" title="Tahun Akademik">Tahun Akademik</a></li>
          <li><a href="/alumnidatakepsek" data-bs-toggle="tooltip" data-bs-placement="top" title="Alumni Data">Alumni</a></li>
          <li class="dropdown"><a href="#"><span>Tahun Akademik</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Tahun Ajaran {{ $activeAcademicYear }} - Aktif</a></li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="user-info d-flex align-items-center">
            @if(session()->has('kepsek_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilekepsek" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Profile">
                    <span>{{ $kepsek->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif
            <form action="{{ route('logoutkepsek') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn-getstarted" data-bs-toggle="tooltip" data-bs-placement="top" title="Keluar dari Akun Anda">Logout</button>
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
            <h2 class="font-weight-bold">Daftar Tahun Akademik</h2>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">
            </div>
        </div>


        <!-- Table Tahun Akademik -->
        <div class="table-container">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Tahun Akademik</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>
                        <a href="/kepsekrombel" class="text-decoration-none fw-bold text-primary table-link-hover">
                            {{ $tahunAjaran }} - {{ $status }}
                        </a>
                    </td>
                        <td>
                            <span class="badge bg-success">AKTIF</span>
                        </td>
                        <td>
                            <!-- Aksi -->
                            <div class="d-inline-flex gap-2">
                                <a href="/kepsekrombel" class="btn btn-sm btn-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Tahun Akademik">
                                    <i class="bi bi-info-circle text-white"></i> Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Keluar Rombel -->
        <div class="table-container">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-danger">
                    <tr>
                        <th scope="col">Data Siswa Keluar Rombel</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keluarRombelPeriods as $period)
                        <tr>
                            <td>{{ $period->academic_year }} - {{ $period->semester }}</td>
                            <td>
                                <a href="{{ route('keluarrombeldatakepsek.index', ['academic_year' => $period->academic_year, 'semester' => $period->semester]) }}"
                                   class="btn btn-sm btn-primary text-white">Detail ({{ $period->record_count }})</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-muted">Belum ada data keluar rombel.</td></tr>
                    @endforelse
                </tbody>
            </table>
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

</body>

</html>