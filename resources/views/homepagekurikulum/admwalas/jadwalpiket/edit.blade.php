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
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
    <div class="starter-section container">
        <!-- Header dengan Title, Pencarian, dan Tombol -->
        <div class="mb-4">
            <h2 class="font-weight-bold">Jadwal Piket</h2>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">

            </div>
        </div>

        <div class="container">
    <h1 class="mb-4">Edit Jadwal Piket</h1>
    <form action="{{ route('jadwalpiket.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="walas_id">Wali Kelas</label>
            <select name="walas_id" class="form-control" id="walas_id" required>
                @foreach($walas as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->walas_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="hari1">Hari 1</label>
            <select name="hari1" class="form-control" id="hari1" required>
                <option value="senin" {{ $jadwal->hari1 == 'senin' ? 'selected' : '' }}>Senin</option>
                <option value="selasa" {{ $jadwal->hari1 == 'selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="rabu" {{ $jadwal->hari1 == 'rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="kamis" {{ $jadwal->hari1 == 'kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="jumat" {{ $jadwal->hari1 == 'jumat' ? 'selected' : '' }}>Jumat</option>
            </select>
        </div>

        <div class="form-group">
            <label for="siswa1_id">Siswa 1</label>
            <select name="siswa1_id" class="form-control" id="siswa1_id" required>
                @foreach($siswas as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->siswa1_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <label for="hari2">Hari 2</label>
            <select name="hari2" class="form-control" id="hari2" required>
                <option value="senin" {{ $jadwal->hari2 == 'senin' ? 'selected' : '' }}>Senin</option>
                <option value="selasa" {{ $jadwal->hari2 == 'selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="rabu" {{ $jadwal->hari2 == 'rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="kamis" {{ $jadwal->hari2 == 'kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="jumat" {{ $jadwal->hari2 == 'jumat' ? 'selected' : '' }}>Jumat</option>
            </select>
        </div>

        <div class="form-group">
            <label for="siswa2_id">Siswa 2</label>
            <select name="siswa2_id" class="form-control" id="siswa2_id" required>
                @foreach($siswas as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->siswa2_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="hari3">Hari 3</label>
            <select name="hari3" class="form-control" id="hari3" required>
                <option value="senin" {{ $jadwal->hari3 == 'senin' ? 'selected' : '' }}>Senin</option>
                <option value="selasa" {{ $jadwal->hari3 == 'selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="rabu" {{ $jadwal->hari3 == 'rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="kamis" {{ $jadwal->hari3 == 'kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="jumat" {{ $jadwal->hari3 == 'jumat' ? 'selected' : '' }}>Jumat</option>
            </select>
        </div>

        <div class="form-group">
            <label for="siswa3_id">Siswa 3</label>
            <select name="siswa3_id" class="form-control" id="siswa3_id" required>
                @foreach($siswas as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->siswa3_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="hari4">Hari 4</label>
            <select name="hari4" class="form-control" id="hari4" required>
                <option value="senin" {{ $jadwal->hari4 == 'senin' ? 'selected' : '' }}>Senin</option>
                <option value="selasa" {{ $jadwal->hari4 == 'selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="rabu" {{ $jadwal->hari4 == 'rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="kamis" {{ $jadwal->hari4 == 'kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="jumat" {{ $jadwal->hari4 == 'jumat' ? 'selected' : '' }}>Jumat</option>
            </select>
        </div>

        <div class="form-group">
            <label for="siswa4_id">Siswa 4</label>
            <select name="siswa4_id" class="form-control" id="siswa4_id" required>
                @foreach($siswas as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->siswa4_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="hari5">Hari 5</label>
            <select name="hari5" class="form-control" id="hari5" required>
                <option value="senin" {{ $jadwal->hari5 == 'senin' ? 'selected' : '' }}>Senin</option>
                <option value="selasa" {{ $jadwal->hari5 == 'selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="rabu" {{ $jadwal->hari5 == 'rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="kamis" {{ $jadwal->hari5 == 'kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="jumat" {{ $jadwal->hari5 == 'jumat' ? 'selected' : '' }}>Jumat</option>
            </select>
        </div>

        <div class="form-group">
            <label for="siswa5_id">Siswa 5</label>
            <select name="siswa5_id" class="form-control" id="siswa5_id" required>
                @foreach($siswas as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->siswa5_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="kurikulum_id">Kurikulum</label>
            <select name="kurikulum_id" class="form-control" id="kurikulum_id" required>
                @foreach($kurikulum as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->kurikulum_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ $jadwal->tanggal }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
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

