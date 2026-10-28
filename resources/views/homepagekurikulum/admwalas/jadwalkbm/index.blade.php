<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Kurikulum</title>
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

    .table-bordered {
        border: 1px solid #000;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #000;
    }
    .text-center {
        text-align: center;
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

      <a href="/kurikulumpage" class="logo d-flex align-items-center me-auto me-xl-0">
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
            @if(session()->has('kurikulum_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilekurikulum" class="text-decoration-none">
                    <span>{{ $kurikulum->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif
            <form action="{{ route('logoutkurikulum') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn-getstarted">Logout</button>
            </form>
        </div>
    </div>
  </header>

<main class="main">
    <section id="hero" class="hero section">
        <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">
            <!-- Header dengan Title, Pencarian, dan Tombol -->
            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h2 class="font-weight-bold mb-0">Jadwal KBM</h2>
                @if(request('walas_id') || !empty($walasIdSelected))
                    <a href="{{ url('/admwalasviewkurikulum/' . (request('walas_id') ?? $walasIdSelected)) }}" class="btn btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali ke Administrasi Walas
                    </a>
                @else
                    <a href="{{ route('homepagekurikulum.index') }}" class="btn btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                @endif
            </div>
                <hr class="my-3">
                <div class="d-flex align-items-center justify-content-start gap-2">
                    <a href="{{ route('jadwalkbm.index', ['export' => 'pdf']) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-download"></i> Unduh
                    </a>
                    
                </div>
            </div>
            
            @if ($jadwalKbms->isEmpty())
                <div class="alert alert-info">Data jadwal belum tersedia.</div>
            @else
                <table>
                    <tr>
                        <td>Kelas</td>
                        <td>: {{ $rombel->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <td>Tahun Pelajaran</td>
                        <td>: {{ date('Y') }}</td>
                    </tr>
                    <tr>
                    @foreach ($jadwalKbms as $jadwal)
                    <h5>Nama Wali Kelas : {{ $jadwal->walas->nama }}</h5>
                    @endforeach
                    </tr>
                </table>
                <br>

                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th></th>
                            <th colspan="2">Senin</th>
                            <th colspan="2">Selasa</th>
                            <th colspan="2">Rabu</th>
                            <th colspan="2">Kamis</th>
                            <th colspan="2">Jumat</th>
                        </tr>
                        <tr>
                            <th>Jam Ke</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($jam = 1; $jam <= 12; $jam++)
                            <tr>
                                <td>{{ $jam }}</td>
                                @foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $hari)
                                    @php
                                        $rawSchedule = $jadwal->$hari ?? null;
                                        $scheduleData = is_string($rawSchedule) ? json_decode($rawSchedule, true) : (is_array($rawSchedule) ? $rawSchedule : []);
                                        $jadwalHari = $scheduleData ? collect($scheduleData)->firstWhere('jam', $jam) : null;
                                        $mapelNama = $jadwalHari && isset($jadwalHari['mapel_id']) && isset($mapels[$jadwalHari['mapel_id']]) ? ($mapels[$jadwalHari['mapel_id']]->nama_mapel ?? '-') : '-';
                                        $guruNama = $jadwalHari && isset($jadwalHari['guru_id']) && isset($gurus[$jadwalHari['guru_id']]) ? ($gurus[$jadwalHari['guru_id']]->nama ?? '-') : '-';
                                    @endphp
                                    <td>{{ $mapelNama }}</td>
                                    <td>{{ $guruNama }}</td>
                                @endforeach
                            </tr>
                        @endfor
                    </tbody>
                </table>
            @endif
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
        // Menampilkan pesan selama 2 detik dan kemudian menghilangkannya
        setTimeout(function() {
            var messageElement = document.getElementById('message');
            if (messageElement) {
                messageElement.style.display = 'none';
            }
        }, 2000); // 2000 ms = 2 detik
    </script>

</body>

</html>