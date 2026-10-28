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

/* Hero Section */
#hero {
    padding: 50px 0;
    background-color: #f7f9fc;
}

.starter-section {
    max-width: 1200px;
    margin: 0 auto;
}

/* Card Styling */
.card {
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    transition: all 0.3s ease; /* Tambahkan transisi untuk efek hover */
}

.card-header {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    padding: 15px;
    background-color: #007bff;
    color: white;
}

.card-body {
    padding: 15px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-size: 14px;
    font-weight: bold;
    display: block; /* Pastikan label berada di atas select */
}

.form-group select {
    font-size: 14px;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
    width: 100%;
}

/* Hover effect untuk card */
.card:hover {
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

.card-header.bg-white {
    border-bottom: 1px solid #ddd; /* Menambahkan garis bawah */
}

.text-white{
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card {
        margin-bottom: 15px;
    }

    .card-header h5 {
        font-size: 16px;
    }

    .form-group select {
        font-size: 14px;
    }

    .card-header.bg-custom-blue {
    background-color: #007bff; /* Ganti dengan warna biru yang diinginkan */
    color: white;
}

}
</style>

<!-- Custom CSS -->
<style>
    .starter-section {
        padding: 50px 0;
    }

    .card {
        background-color: #f9f9f9; /* Latar belakang cerah untuk kartu */
        border-radius: 8px;
    }

    .form-control {
        border-radius: 5px;
    }

    .btn {
        border-radius: 5px;
    }

    .shadow-lg {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 36px;
        color: #333;
    }

    .card-header {
        font-size: 18px;
    }

    /* Styling tambahan untuk tombol */
    .btn {
        padding: 10px 20px;
        font-size: 16px;
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

      <a href="/kepsekpage" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
        <li><a href="/denahkerjakelompok" >Denah Kelompok</a></li>
          <li><a href="/createkelompok" class="active">Buat Data Kelompok</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
       <!-- Menampilkan ikon user dan informasi walas yang sedang login -->
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
      

    </div>
  </header>

  <main class="main">

<!-- Hero Section -->
<!-- Hero Section -->
<section id="hero" class="hero section">
    <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">
        <div class="text-center mb-4">
            <br><br><br><br>
            <h2 class="font-weight-bold">Kelompok Siswa</h2>
            <hr class="my-3">
        </div>

        <form action="{{ route('kelompoksiswa.store') }}" method="POST">
            @csrf

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h5>Form Buat Kelompok</h5>
                        </div>
                        <div class="card-body">
                            <!-- Nama Kelompok -->
                            <div class="form-group">
                                <label for="nama_kelompok">Nama Kelompok</label>
                                <select name="nama_kelompok" id="nama_kelompok" class="form-control">
                                    <option value="" disabled selected>Pilih Kelompok</option>
                                    <option value="Kelompok 1">Kelompok 1</option>
                                    <option value="Kelompok 2">Kelompok 2</option>
                                    <option value="Kelompok 3">Kelompok 3</option>
                                    <option value="Kelompok 4">Kelompok 4</option>
                                    <option value="Kelompok 5">Kelompok 5</option>
                                    <option value="Kelompok 6">Kelompok 6</option>
                                </select>
                            </div>

                            <!-- Nama Walas -->
                            <div class="form-group">
                                <label for="walas_id">Nama Walas</label>
                                <input type="hidden" name="walas_id" id="walas_id" class="form-control" value="{{ $walas->id }}" readonly>
                            </div>

                            <!-- Siswa -->
                            @for ($i = 0; $i < 6; $i++)
                                <div class="form-group">
                                    <label for="siswa_{{ $i }}">Pilih Siswa {{ $i + 1 }}</label>
                                    <select name="siswas_id[]" id="siswa_{{ $i }}" class="form-control">
                                        <option value="" disabled selected>Pilih Siswa</option>
                                        @foreach ($siswas as $s)
                                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Simpan -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>

    </div>
</section>



</main>

<!-- Footer Section -->
<footer>
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
