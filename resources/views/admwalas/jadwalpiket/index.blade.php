<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Walas</title>
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <!-- Import Bootstrap CSS (jika belum) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Import Bootstrap JS (jika belum) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



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

        .card-header h5 {
            color: white;
        }

        .alert-danger {
            background-color: #e74c3c; /* Merah */
        }

        .alert-success {
            background-color: #2ecc71; /* Hijau */
        }

        .list-group-item {
            position: relative;
            padding-right: 50px;
        }

        .list-group-item:hover .action-icons {
            display: inline;
        }

        .action-icons {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #f0f0f0; /* Warna abu-abu background */
            color: #6c757d; /* Warna abu-abu ikon */
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            border: 1px solid #d6d6d6; /* Border abu-abu */
        }

        .icon-circle:hover {
            background-color: #e0e0e0; /* Warna abu-abu lebih gelap saat hover */
            color: #495057; /* Warna abu-abu lebih gelap untuk ikon */
            border-color: #c0c0c0;
        }

        .icon-circle i {
            pointer-events: none; /* Mencegah klik pada ikon langsung */
        }

        .modal-dialog.modal-sm {
            max-width: 400px; /* Sesuaikan dengan ukuran yang diinginkan */
        }

        /* Menyesuaikan tampilannya agar dropdown tampil lebih rapi */
        .form-group {
            margin-bottom: 15px;
        }

        select.form-control {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-sizing: border-box;
        }

        /* Styling tambahan untuk button Pilih Siswa */
        button[type="submit"] {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        /* Pastikan form muncul di tengah halaman */
        .edit-siswa-form {
            display: none; /* Sembunyikan form awalnya */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px; /* Menentukan lebar form */
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }

        .edit-siswa-form.show {
            display: block; /* Tampilkan form saat diaktifkan */
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
    .meja-guru-box-style {
        width: 200px; /* Lebar persegi panjang */
        height: 100px; /* Tinggi persegi panjang */
        background-color: #CECECE; /* Warna latar belakang */
        border-radius: 20px; /* Sudut membulat */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .meja-guru-box h4 {
        font-size: 20px; /* Ukuran font judul */
        color: #333; /* Warna teks */
        margin: 0; /* Menghapus margin default */
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
        <li><a href="/jadwalpiket" class="active">Jadwal Piket</a></li>
          <li><a href="/createpiket" >Buat Piket</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
       <!-- Menampilkan ikon user dan informasi walas yang sedang login -->
<div class="user-info d-flex align-items-center">
      <div class="user-info d-flex align-items-center">
            @if(session()->has('walas_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilewalas" class="text-decoration-none">
                    <span>{{ $walas->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif
    <form action="{{ route('logoutwalas') }}" method="POST" class="ms-3">
        @csrf
        <button type="submit" class="btn-getstarted">Logout</button>
    </form>
</div>
  </header>

  <main class="main">

  <!-- Hero Section -->
<section id="hero" class="hero section">
    <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">
        <div class="mb-4">
            <h2 class="font-weight-bold">Jadwal Piket Siswa</h2>
            <a href="/createpiket" class="btn btn-primary btn-sm mt-2">+ Buat Piket Baru</a>
            <hr class="my-3">
        </div>
        <br>

        <div>
        <a href="{{ route('jadwalpiket.index', ['export' => 'pdf']) }}" class="btn btn-outline-secondary"   style="font-size: 20px; padding: 5px 5px; width: auto; max-width: 150px;">
    <i class="bi bi-download"></i> Unduh PDF
</a>
</div>
        @foreach (array_chunk($data, 3) as $row)
        <div class="row mt-4">
            @foreach ($row as $piket)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>{{ $piket['nama_hari'] }}</h5>
                    </div>
                    <div class="card-body">
                       <ul class="list-group">
                            @if ($piket['siswas']->isEmpty())
                                <li class="list-group-item">Tidak ada data</li>
                            @else
                                @foreach ($piket['siswas'] as $siswa)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $siswa->nama }}
                                        <div class="action-icons">
                                            <a href="/hapussiswapiket/{{$siswa->id}}" 
                                                class="icon-circle text-secondary" 
                                                title="Hapus Siswa"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{$siswa->id}}').submit();">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>

                                                <!-- Form penghapusan, tetap tersembunyi -->
                                                <form id="delete-form-{{$siswa->id}}" action="/hapussiswapiket/{{$siswa->id}}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                        </div>
                                    </li>
                                @endforeach
                            @endif
                       </ul>

                        <!-- Tombol tambah siswa dengan ikon + -->
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-success" onclick="toggleSelectSiswa({{ $piket['id'] }})">
                                <i class="fas fa-plus"></i> Tambah Siswa
                            </button>
                        </div>

                        <!-- Form pemilihan siswa -->
                        <div id="selectSiswaContainer_{{ $piket['id'] }}" class="mt-3" style="display: none;">
                            <form action="{{ route('jadwalpiket.simpan') }}" method="POST">
                                @csrf
                                <!-- Hidden input untuk kelompok_id -->
                                <input type="hidden" name="jadwalpikets_id" value="{{ $piket['id'] }}">

                                <div class="form-group">
                                    <label for="siswa_select_{{ $piket['id'] }}">Pilih Siswa</label>
                                    <select name="siswas_id" id="siswa_select_{{ $piket['id'] }}" class="form-control">
                                        <option value="" disabled selected>Pilih Siswa</option>
                                        @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}">
                                            {{ $siswa->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary btn-sm d-block mx-auto">
                                    Tambah Siswa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach


</section>


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
 <!-- Tambahkan Font Awesome untuk ikon + -->
 <script>
    // Fungsi untuk toggle visibilitas form pemilihan siswa
    function toggleSelectSiswa(kelompokId) {
        const container = document.getElementById(`selectSiswaContainer_${kelompokId}`);
        if (container.style.display === 'none') {
            container.style.display = 'block'; // Tampilkan form
        } else {
            container.style.display = 'none'; // Sembunyikan form
        }
    }
</script>

<script>
    function toggleEditSiswaForm(kelompokId, siswaId) {
        var formContainer = document.getElementById("editSiswaContainer_" + kelompokId);
        // Menyembunyikan atau menampilkan form ketika tombol edit diklik
        if (formContainer.style.display === "none") {
            formContainer.style.display = "block";
        } else {
            formContainer.style.display = "none";
        }

        // Mengarahkan form ke ID siswa yang dipilih
        document.getElementById("siswa_select_" + kelompokId).value = siswaId;
    }
</script>

<script>
    function openEditForm(kelompokId, siswaId) {
        var form = document.getElementById('editSiswaForm_' + kelompokId);
        form.classList.add('show'); // Menambahkan kelas 'show' untuk menampilkan form
    }
</script>


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