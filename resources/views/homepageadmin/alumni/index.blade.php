<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong- Admin</title>
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" 
  rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


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


/* Responsive */
@media screen and (max-width: 500px) {
  .input-box {
    height: 66px;
    margin: 0 8px;
  }
  .input-box i {
    left: 12px;
    font-size: 25px;
  }
  .input-box input {
    padding: 0 112px 0 50px;
  }
  .input-box .button {
    right: 12px;
    font-size: 14px;
    padding: 8px 18px;
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

      <a href="/adminpage" class="logo d-flex align-items-center me-auto me-xl-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali Kehalaman Home Page">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        <li><a href="/tahunajaran" data-bs-toggle="tooltip" data-bs-placement="top" title="Tahun Akademik Data">Tahun Akademik</a></li>
          <li><a href="/alumni" class="active" data-bs-toggle="tooltip" data-bs-placement="top" title="Alumni Data">Alumni</a></li>
          <li class="dropdown"><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Tahun Akademik Aktif"><span>Tahun Akademik</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Tahun Ajaran {{ $activeAcademicYear }} - Aktif</a></li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <form action="{{ route('logoutadmin') }}" method="POST" data-bs-toggle="tooltip" data-bs-placement="top" title="Keluar Akun">
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
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h2 class="font-weight-bold mb-0">Alumni Data</h2>
                <a href="{{ route('homepageadmin.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda Admin
                </a>
            </div>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">

            </div>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>Nomor WhatsApp</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumni as $idx => $data)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>
                                <a href="https://wa.me/{{ $data->no_wa }}" target="_blank" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Hubungi Alumni">
                                    <i class="fa-brands fa-whatsapp"></i> Chat Alumni
                                </a>
                            </td>
                            <td>{{ $data->rombel->kompetensi ?? 'Tidak ada data' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Unggah Data -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

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

        document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Mengambil data dari atribut data-*
            const id = button.getAttribute('data-id');
            const tingkat = button.getAttribute('data-tingkat');
            const kompetensi = button.getAttribute('data-kompetensi');
            const nama_kelas = button.getAttribute('data-nama_kelas');
            const walas_id = button.getAttribute('data-walas_id');

            // Mengisi data ke dalam modal
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-tingkat').value = tingkat;
            document.getElementById('edit-kompetensi').value = kompetensi;
            document.getElementById('edit-nama_kelas').value = nama_kelas;
            document.getElementById('edit-walas_id').value = walas_id;
        });
    });
});

    </script>

</body>

</html>