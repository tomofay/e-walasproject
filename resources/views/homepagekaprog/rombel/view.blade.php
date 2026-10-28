<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Admin</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../../images/logokampak.png" rel="icon">
  <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="/../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

   <!-- Unicons CSS -->
   <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />


  <!-- Main CSS File -->
  <link href="/../../assets/css/main.css?v=2" rel="stylesheet">

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

/* Css Biar table navigation nempel dengan table utama */

.nav-tabs {
    margin-bottom: 0; /* Hilangkan margin bawah */
    border-bottom: 1px solid #dee2e6; /* Tambahkan border untuk memisahkan tab dengan konten */
}

.nav-tabs .nav-link {
    border: 1px solid #dee2e6; /* Tambahkan border di sekitar tombol */
    border-bottom: none; /* Hilangkan border bawah pada semua tombol */
}

.nav-tabs .nav-link.active {
    background-color: #fff; /* Warna background untuk tab aktif */
    color: #495057; /* Warna teks tab aktif */
    border-color: #dee2e6 #dee2e6 #fff; /* Pastikan border terlihat menyatu */
}

.tab-content {
    border: 1px solid #dee2e6; /* Tambahkan border di sekitar konten */
    border-top: none; /* Hilangkan border atas agar menyatu dengan tab navigation */
    background-color: #fff; /* Pastikan latar belakang putih */
    padding: 15px; /* Tambahkan padding untuk konten */
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

      <a href="/homepagekaprog" class="logo d-flex align-items-center me-auto me-xl-0">
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
            <form action="{{ route('logoutkakom') }}" method="POST" class="ms-3">
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
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h2 class="font-weight-bold mb-0">Daftar Siswa Kelas : {{ $rombel->nama_kelas }}</h2>
                <a href="{{ route('kakomrombel.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Rombel
                </a>
            </div>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">
                
            </div>
        </div>
           <!-- Jumlah Total Siswa -->
           <div class="text-end mb-4">
            <span class="text-muted">
                Jumlah Total: <strong>{{ $siswas->count() }} Siswa</strong>
            </span>
        </div>

        <div class="container mt-4">
   <!-- Tab Navigation -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="anggota-tab" data-bs-toggle="tab" data-bs-target="#anggota" type="button" role="tab" aria-controls="anggota" aria-selected="true">
            Anggota Kelas
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="walas-tab" data-bs-toggle="tab" data-bs-target="#walas" type="button" role="tab" aria-controls="walas" aria-selected="false">
            Wali Kelas
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="myTabContent">
    <!-- Tab 1: Data Anggota Kelas -->
    <div class="tab-pane fade show active" id="anggota" role="tabpanel" aria-labelledby="anggota-tab">
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->rombel ? $data->rombel->nama_kelas : 'Tidak ada rombel' }}</td>
                                <td>{{ $data->jenis_kelamin }}</td>
                                <td>
                                    <a href="https://wa.me/{{ $data->no_wa }}" target="_blank">
                                        <i class="bi bi-whatsapp" style="font-size: 20px; color: green;"></i>
                                    </a>
                                </td>
                                <td>
                                    @if(!empty($data->image_url) && $data->image_url != null)
                                        <img src="{{ asset('storage/'.$data->image_url) }}" alt="Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle d-flex justify-content-center align-items-center" 
                                            style="width: 50px; height: 50px; background-color: #E86E7A; color: white; font-size: 20px;">
                                            {{ strtoupper(substr($data->nama, 0, 2)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $data->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 2: Data Wali Kelas -->
        <div class="tab-pane fade" id="walas" role="tabpanel" aria-labelledby="walas-tab">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Wali Kelas</th>
                            <th>No WhatsApp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($walas)
                            <tr>
                                <td>1</td>
                                <td>{{ $walas->nama ?? 'Tidak ada wali kelas' }}</td>
                                <td>
                                    @if ($walas->no_wa)
                                        <a href="https://wa.me/{{ $walas->no_wa }}" target="_blank">
                                            <i class="bi bi-whatsapp" style="font-size: 20px; color: green;"></i>
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data wali kelas.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Unggah Data -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel" style="color: white;">Unggah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tombol Download Template -->
                <div class="mb-3">
                    <a href="{{ route('siswa.download-template') }}" class="btn btn-primary btn-sm" target="_blank">Download Template Excel</a>
                </div>

                <!-- Form Unggah Data -->
                <form action="/siswa-import" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="fileUpload" class="form-label">Pilih File (CSV, Excel)</label>
                        <input type="file" name="file" class="form-control" id="fileUpload" accept=".csv, .xlsx">
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Unggah</button>
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
                <h5 class="modal-title" id="addModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="teacherName" placeholder="Masukan Nama Siswa" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="rombelsId" class="form-label">Rombels</label>
                        <select class="form-select" id="rombelsId" name="rombels_id" required>
                            <option selected disabled>Pilih Rombel</option>
                            @foreach ($rombels as $rombel)
                                <option value="{{ $rombel->id }}">{{ $rombel->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="studentWhatsApp" class="form-label">WhatsApp</label>
                        <input type="number" class="form-control" id="studentWhatsApp" placeholder="Masukkan nomor WhatsApp" name="no_wa" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="passwowrd" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Siswa</label>
                        <input type="file" class="form-control" id="teacherPhoto" name="image_url" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" aria-label="Pilih Gender" name="status" required>
                            <option selected disabled>Pilih Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="teacherGender" class="form-label">Pilih Gender</label>
                        <select class="form-select" id="teacherGender" aria-label="Pilih Gender" name="jenis_kelamin" required>
                            <option selected disabled>Pilih Gender</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
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
  <script src="/../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/../../assets/vendor/php-email-form/validate.js"></script>
  <script src="/../../assets/vendor/aos/aos.js"></script>
  <script src="/../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/../../assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="/../../assets/js/main.js"></script>

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