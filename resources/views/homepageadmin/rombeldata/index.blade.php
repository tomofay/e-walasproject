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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Unicons CSS -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />


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

      <a href="/adminpage" class="logo d-flex align-items-center me-auto me-xl-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Halaman Home Page Admin">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        <li><a href="/tahunajaran" data-bs-toggle="tooltip" data-bs-placement="top" title="Beranda">Beranda</a></li>
          <li><a href="/rombel" class="active" data-bs-toggle="tooltip" data-bs-placement="top" title="Rombel Data">Rombel</a></li>
          <li><a href="/datamapel" data-bs-toggle="tooltip" data-bs-placement="top" title="Data Mata Pelajaran">Mata Pelajaran</a></li>
          <li class="dropdown"><a href="#"><span>Tahun Akademik</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Tahun Ajaran 2025/2026 - Aktif</a></li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <form action="{{ route('logoutadmin') }}" method="POST" data-bs-toggle="tooltip" data-bs-placement="top" title="Keluar dari Akun Anda">
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
            <h2 class="font-weight-bold">Rombel Data</h2>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#uploadModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Unggah Rombel Menggunakan Template">
                        <i class="bi bi-cloud-upload"></i> Unggah
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Rombel Manual">
                        <i class="bi bi-plus"></i> Tambah
                    </button>
                </div>
                
                    <div class="d-flex-container">
                    <form action="{{ url('rombel_search') }}" method="GET">
                        <div class="input-box">
                            <i class="uil uil-search"></i>
                                <input type="text" name="keyword" placeholder="Cari Rombel..." value="{{ old('keyword', $keyword ?? '') }}" required />
                                <button class="button" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
            <table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th>Tingkat</th>
            <th>Kompetensi</th>
            <th>Nama Kelas</th>
            <th>Wali Kelas</th>
            <th>No WhatsApp</th>
            <th>Informasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vwrombels as $idx => $data)
            <tr>
                <td>
                    <div class="d-flex px-2 py-1">
                        {{ $idx + 1 . '. ' }}
                    </div>
                </td>
                <td>{{ $data->tingkat }}</td>
                <td>{{ $data->kompetensi }}</td>
                <td>{{ $data->nama_kelas }}</td>
                <td>{{ $data->walas_nama }}</td>
                <td>{{ $data->no_wa }}</td> <!-- This can be updated to show name if needed -->
                <td>
                    <!-- Aksi -->
                    <div class="d-inline-flex gap-2">
                    <a href="{{ route('detail.kelas', ['rombel_id' => $data->rombel_id]) }}" class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Siswa">
                            <i class="bi bi-info-circle text-white"></i> Detail Kelas
                    </a>
                    </div>
                </td>
                <td class="text-center align-middle">
                    <!-- Tombol Edit -->
                    <a href="{{ route('rombels.edit', $data->rombel_id) }}" class="btn rounded-circle shadow-sm edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Rombel">
                        <i class="bi bi-pencil" style="font-size: 20px; color: #6c757d;"></i>
                    </a>
                    <!-- Tombol Delete -->
                    <form action="{{ route('rombel.destroy', $data->rombel_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn rounded-circle shadow-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Rombel" style="background-color: #f8fbff; border: none; width: 50px; height: 50px;">
                            <i class="bi bi-trash" style="font-size: 20px; color: #6c757d;"></i>
                        </button>
                    </form>
                </td>
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
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Unggah Data Rombel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tombol Download Template -->
                <div class="mb-3">
                    <a href="{{ route('rombel.download-template') }}" class="btn btn-primary btn-sm" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Download template Excel">Download Template Excel</a>
                </div>
                <!-- Form Unggah Data -->
                <form action="/rombel-import" method="post" enctype="multipart/form-data" id="uploadForm" >
                    @csrf
                    <div class="mb-3">
                        <label for="fileUpload" class="form-label">Pilih File (CSV, Excel)</label>
                        <input type="file" name="file" class="form-control" id="fileUpload" accept=".csv, .xlsx">
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="uploadButton">Unggah</button>

                <!-- Spinner Loading -->
                <div id="loadingSpinner" class="d-none">
                    <button class="btn btn-primary px-4 py-2 d-flex align-items-center justify-content-center w-100" type="button" disabled>
                        <span>Mengunggah</span>
                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Rombel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('rombels.store') }}">
                    @csrf <!-- Token keamanan -->
                    <div class="mb-3">
                        <label for="gradeLevel" class="form-label">Pilih Tingkat</label>
                        <select class="form-select" id="gradeLevel" aria-label="Pilih Tingkat" name="tingkat" required>
                            <option selected disabled>Pilih Tingkat</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                            <option value="XIII">XIII</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Pilih Jurusan</label>
                        <select class="form-select" id="jurusan" aria-label="Pilih Jurusan" name="kompetensi" required>
                            <option selected disabled>Pilih Jurusan</option>
                            <option value="SIJA">SIJA</option>
                            <option value="TKJ">TKJ</option>
                            <option value="RPL">RPL</option>
                            <option value="DKV">DKV</option>
                            <option value="DPIB">DPIB</option>
                            <option value="TKP">TKP</option>
                            <option value="TP">TP</option>
                            <option value="TFLM">TFLM</option>
                            <option value="TOI">TOI</option>
                            <option value="TKR">TKR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="kode" placeholder="Contoh : Kode 1 Untuk X JURUSAN 1" name="nama_kelas" required>
                    </div>
                    <div class="mb-3">
                        <label for="walas" class="form-label">Wali Kelas</label>
                        <select class="form-select" id="walas" name="walas_id" required>
                            <option selected disabled>Pilih Wali Kelas</option>
                            @foreach ($walas as $wali)
                                <option value="{{ $wali->id }}">{{ $wali->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
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

        document.getElementById("uploadForm").addEventListener("submit", function(event) {
            // Sembunyikan tombol unggah, tampilkan spinner
            document.getElementById("uploadButton").classList.add("d-none");
            document.getElementById("loadingSpinner").classList.remove("d-none");
        });

    </script>

</body>

</html>