<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong- Walas</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../../../images/logokampak.png" rel="icon">
  <link href="../../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"rel="stylesheet"/>

  <!-- Main CSS File -->
  <link href="../../../assets/css/main.css?v=2" rel="stylesheet">

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
      <form action="{{ route('logoutwalas') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-getstarted">Logout</button>
                                </form>
      

    </div>
  </header>

<main class="main">

       <!-- Hero Section -->
       <section id="hero" class="hero section">
    <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">
        <!-- Header dengan Title, Pencarian, dan Tombol -->
        <div class="mb-4">
            <h1 class="font-weight-bold">Rencana Kegiatan Walas - {{ ucfirst($semester) }}</h1>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">
                
            </div>
        </div>

        <div class="container">
        <form action="{{ route('rencana_kegiatan_walas.update', ['semester' => $semester, 'id' => $rencana_kegiatan->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
    <label for="walas_id" class="form-label">Wali Kelas:</label>
    <select name="walas_id" id="walas_id" class="form-select" required>
        <option value="" disabled selected>Pilih Wali Kelas</option>
        @foreach($walas as $walas_item)
            <option value="{{ $walas_item->id }}" 
                @if(old('walas_id', $rencana_kegiatan->walas_id) == $walas_item->id) selected @endif>
                {{ $walas_item->nama }}
            </option>
        @endforeach
    </select>
</div>


        <!-- Semester -->
        <div class="form-group">
            <label for="semester">Semester</label>
            <input type="text" name="semester" class="form-control" value="{{ old('semester', $semester) }}" readonly>
        </div>

        <!-- Minggu Ke -->
        <div class="form-group">
            <label for="minggu_ke">Minggu ke-</label>
            <select name="minggu_ke" class="form-control" id="minggu_ke" required>
                @for ($i = 1; $i <= 18; $i++)
                    <option value="{{ $i }}" 
                        @if(old('minggu_ke', 1) == $i) selected @endif>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- Kegiatan dan Bukti -->
        <div class="form-group">
            <label for="kegiatan_bukti">Kegiatan dan Bukti</label>
            <select name="kegiatan_bukti" class="form-control" id="kegiatan_bukti" required>
                @foreach([
                    "Menyusun program / mengisi adm wali kelas - Adm Wali kelas",
                    "Menyusun struktur organisasi kelas - Organigram",
                    "Sosialisasi sistem pemelajaran Kurikulum 2013 atau Kurikulum Merdeka - Absensi",
                    "Menata tempat duduk di kelas - Denah kelas",
                    "Membagi biodata peserta didik - Ada bio data",
                    "Mengisi data peserta - Ada data peserta",
                    "Membimbing peserta didik - Ada daftar bimbingan",
                    "Mengecek kehadiran peserta didik - Ada rekap",
                    "Menindaklanjuti hasil pengecekan absensi - Pemang. / homevisit",
                    "Membenahi keadaan kelas - Kelas tertata / lengkap",
                    "Mengontrol kemajuan hasil pemelajaran - Rekaman kegiatan",
                    "Visit Class - Surat tugas",
                    "Home Visit - Rekaman kegiatan",
                    "Rekapitulasi nilai kompetensi - Rekap nilai",
                    "Membimbing remedial peserta didik - Daftar Remedial",
                    "Mengisi Leger - Ada Leger",
                    "Mengisi Buku Laporan - Ada buku Laporan",
                    "Membagi dokumen hasil pembelajaran - Daftar serah terima raport"
                ] as $option)
                    <option value="{{ $option }}" 
                        @if(old('kegiatan_bukti') == $option) selected @endif>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Keterangan -->
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <select name="keterangan" class="form-control" required>
                <option value="true" @if(old('keterangan') == 'true') selected @endif>Ada</option>
                <option value="false" @if(old('keterangan') == 'false') selected @endif>Tidak Ada</option>
            </select>
        </div>

        <!-- Tanggal -->
        <div class="form-group">
            <label for="tanggalttd">Tanggal</label>
            <input type="date" name="tanggalttd" class="form-control" value="{{ old('tanggalttd') }}">
        </div>

        <!-- TTD Walas URL -->
        <div class="form-group">
            <label for="ttdwalas_url">Tanda Tangan Walas URL</label>
            <input type="text" name="ttdwalas_url" class="form-control" value="{{ old('ttdwalas_url') }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
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
  <script src="../../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../../assets/vendor/php-email-form/validate.js"></script>
  <script src="../../../assets/vendor/aos/aos.js"></script>
  <script src="../../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../../assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="../../../assets/js/main.js"></script>

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