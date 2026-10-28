<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Profile Pembina Siswa</title>
  <meta name="description" content="Profile Pembina Siswa SMKN 1 Cibinong">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('images/logokampak.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css?v=2') }}" rel="stylesheet">

  <style>
    /* Kontainer utama */
    .walas-info-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 30px;
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    /* Styling foto */
    .walas-photo-container {
        position: relative;
        max-width: 200px;
        text-align: center;
    }

    .walas-photo {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .walas-photo:hover {
        transform: scale(1.05);
    }

    /* Styling ikon edit */
    .edit-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 6px 10px;
        border-radius: 50%;
        display: none;
        cursor: pointer;
        text-decoration: none;
    }

    .walas-photo-container:hover .edit-icon {
        display: block;
    }

    /* Styling untuk informasi profile */
    .profile-info-container {
        background-color: white;
        padding: 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        min-width: 320px;
        max-width: 450px;
        flex: 1;
        text-align: left;
    }

    .profile-info-container p {
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 8px;
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
        max-height: 60px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .alert-danger {
        background-color: #e74c3c;
    }

    .alert-success {
        background-color: #2ecc71;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }
        to {
            transform: translateY(0);
        }
    }

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

    h1 .accent-text {
        font-size: 18px;
        color: black;
        display: block;
        margin-top: 10px;
        font-weight: 500;
    }

    /* Styling untuk tombol Edit */
    .edit-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .edit-button:hover {
        background-color: #0056b3;
        color: white;
    }

    @media (max-width: 768px) {
        .walas-info-container {
            flex-direction: column;
            text-align: center;
        }

        .profile-info-container {
            max-width: 100%;
        }
    }
  </style>
  @include('partials.btn_back_style')
</head>

<body class="index-page">

  <!-- Tampilkan pesan error -->
  @if (session('error'))
      <div class="alert alert-danger" id="alertError">
          <p class="mb-0">{{ session('error') }}</p>
      </div>
  @endif

  <!-- Tampilkan pesan success -->
  @if (session('success'))
      <div class="alert alert-success" id="alertSuccess">
          <p class="mb-0">{{ session('success') }}</p>
      </div>
  @endif

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('pembina.dashboard') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">E - Walas</h1>
      </a>

      <!-- Menampilkan ikon user dan informasi pembina yang sedang login -->
      <div class="user-info d-flex align-items-center">
          <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>
          <a href="{{ route('pembina.profile') }}" class="text-decoration-none">
              <span>{{ $pembina->nama }}</span>
          </a>
          <form action="{{ route('pembina.logout') }}" method="POST" class="ms-3">
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
            Profile Pembina Siswa <br>
            <span class="accent-text">Berikut adalah Profile dari Pembina Siswa</span>
        </h1>

        <div class="walas-info-container">
            <!-- Foto Besar dan Icon Edit -->
            <div class="walas-photo-container position-relative">
                @if($pembina->image_url && file_exists(storage_path('app/public/' . $pembina->image_url)))
                    <img src="{{ asset('storage/' . $pembina->image_url) }}" alt="Foto {{ $pembina->nama }}" class="walas-photo">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pembina->nama) }}&size=200&background=0d6efd&color=fff" alt="Foto {{ $pembina->nama }}" class="walas-photo" onerror="this.onerror=null;this.src='{{ asset('assets/img/avatar-1.webp') }}';">
                @endif
                <a href="{{ route('pembina.profile.edit', $pembina->id) }}" class="edit-icon" title="Edit Data">
                    <i class="bi bi-pencil"></i>
                </a>
            </div>

            <!-- Informasi Profile -->
            <div class="profile-info-container">
                <p><strong>Name:</strong> {{ $pembina->nama }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $pembina->jenis_kelamin ?? 'Laki-laki' }}</p>
                <p><strong>Phone:</strong> {{ $pembina->no_wa ?? '-' }}</p>
                <p><strong>NIP:</strong> {{ $pembina->nip ?? '-' }}</p>
                <p><strong>Password:</strong> ••••••••</p>
                <br>
                <!-- Tombol Edit & Kembali -->
                <a href="{{ route('pembina.profile.edit', $pembina->id) }}" class="edit-button" style="margin-right: 10px;">Edit Data</a>
                <a href="{{ route('pembina.dashboard') }}" class="btn btn-back"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
            </div>
        </div>

    </section><!-- /Hero Section -->

  </main>

  <footer id="footer" class="footer position-relative light-background">
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SIJA SMKN 1 Cibinong</strong> <span>All Rights Reserved</span></p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
        window.onload = function() {
            var errorAlert = document.getElementById('alertError');
            var successAlert = document.getElementById('alertSuccess');

            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.animation = 'slideUp 0.5s ease-out';
                    setTimeout(function() {
                        errorAlert.style.display = 'none';
                    }, 500);
                }, 2500);
            }

            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.animation = 'slideUp 0.5s ease-out';
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 500);
                }, 2500);
            }
        };
  </script>

</body>

</html>
