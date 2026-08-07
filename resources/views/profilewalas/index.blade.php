<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong- Profile Walas</title>
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

    /* Kontainer utama */
.walas-info-container {
    display: flex;
    align-items: center;
    gap: 30px; /* Ruang antara foto dan informasi */
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

/* Styling foto */
.walas-photo-container {
    position: relative;
}

.walas-photo {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 50%;
    transition: transform 0.3s ease;
}

.walas-photo:hover {
    transform: scale(1.1); /* Membesarkan foto saat di-hover */
}

/* Styling ikon edit */
.edit-icon {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 8px;
    border-radius: 50%;
    display: none;
    cursor: pointer;
}

.walas-photo-container:hover .edit-icon {
    display: block;
}

/* Styling untuk informasi profile */
.profile-info-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px; /* Sudut sedikit melengkung */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    flex: 1;
}

.profile-info-container p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 10px;
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

         /* Styling untuk judul */
h1 {
    font-size: 36px;
    color: #333;
    margin-bottom: 20px;
}

/* Styling untuk teks deskripsi yang lebih kecil */
h1 .accent-text {
    font-size: 18px; /* Ukuran font lebih kecil */
    color: black; /* Warna biru untuk memberi aksen */
    display: block; /* Agar teks berada di baris baru */
    margin-top: 10px;
    font-weight: 500;
}  

/* Styling untuk tombol Edit */
.edit-button {
    background-color: #00bcd4; /* Biru muda */
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 20px; /* Memberikan jarak di atas tombol */
}

.edit-button:hover {
    background-color: #95E8F0; /* Warna biru lebih gelap saat hover */
}

.kembali-button {
    background-color: #8E8989; /* Biru muda */
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 20px; /* Memberikan jarak di atas tombol */
}

.kembali-button:hover {
    background-color: #E7DDFF; /* Warna biru lebih gelap saat hover */
}

/* Container utama */
.walas-info-container {
    display: flex;
    flex-wrap: wrap; /* Agar fleksibel di layar kecil */
    justify-content: center;
    align-items: center;
    gap: 20px;
    padding: 20px;
}

/* Container untuk foto siswa */
.walas-photo-container {
    position: relative;
    max-width: 200px;
    text-align: center;
}

.walas-photo {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.edit-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 5px;
    border-radius: 50%;
    cursor: pointer;
}

/* Container informasi */
.profile-info-container {
    max-width: 400px;
    text-align: left;
}

/* Tombol */
.edit-button, .kembali-button {
    display: inline-block;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    text-align: center;
}

.edit-button {
    background-color: #007bff;
    color: white;
}

.kembali-button {
    background-color: #6c757d;
    color: white;
}

/* Media Queries untuk HP */
@media (max-width: 768px) {
    .walas-info-container {
        flex-direction: column;
        text-align: center;
    }

    .profile-info-container {
        max-width: 100%;
    }

    .edit-button, .kembali-button {
        width: 100%;
        margin-top: 10px;
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

      <a href="/walaspage" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

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
    <section id="hero" class="hero section">
        <h1 class="mb-4 text-center">
            Profile Wali Kelas <br>
            <span class="accent-text">Berikut adalah Profile dari Wali kelas</span>
        </h1>

        <div class="walas-info-container">
    <!-- Foto Besar dan Icon Edit -->
    <div class="walas-photo-container position-relative">
        <img src="{{ asset('storage/'.$walas->image_url) }}" alt="Image" class="walas-photo">
        <div class="edit-icon">
            <i class="bi bi-pencil"></i>
        </div>
    </div>

   <!-- Informasi Profile -->
    <div class="profile-info-container">
        <p><strong>Name:</strong> {{ $walas->nama }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $walas->jenis_kelamin }}</p>
        <p><strong>Phone:</strong> {{ $walas->no_wa }}</p>
        <p><strong>NIP </strong> {{ $walas->nip }}</p>
        <p><strong>Password:</strong> ••••••••</p>
        <br>
        <!-- Tombol Edit -->
        <a href="{{ route('profilewalas.edit', $walas->id) }}" class="edit-button" style="margin-right: 10px;">Edit Data</a>
         <a href="/walaspage" class="kembali-button">Kembali</a>
    </div>

</div>

        </div>

    </section><!-- /Hero Section -->

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