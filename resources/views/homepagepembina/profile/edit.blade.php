<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Edit Profil Pembina Siswa</title>
  <meta name="description" content="Edit Profil Pembina Siswa SMKN 1 Cibinong">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('images/logokampak.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css?v=2') }}" rel="stylesheet">

  <style>
    /* Alert box */
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

    /* Animasi slide down */
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

    /* Form styles */
    .form-container {
      max-width: 800px;
      margin: 2rem auto;
      padding: 2rem;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      font-weight: bold;
    }

    .form-select, .form-control {
      padding: 0.75rem;
      border-radius: 4px;
      border: 1px solid #ddd;
      width: 100%;
    }

    .btn-getstarted, .btn-success {
      padding: 0.75rem 2rem;
      border-radius: 4px;
      border: none;
      background-color: #1EB5BA;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-getstarted:hover, .btn-success:hover {
      background-color: #1EB5BA;
    }

    .logo h1 {
      font-size: 1.5rem;
      font-weight: bold;
      margin: 0;
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

  <br><br><br><br>

  <div class="container mt-5">
    <div class="form-container">
      <div class="d-flex align-items-center justify-content-between mb-3">
          <h3 class="mb-0">Form Edit Pembina Siswa</h3>
          <a href="{{ route('pembina.profile') }}" class="btn btn-back">
              <i class="bi bi-arrow-left"></i> Kembali ke Profil
          </a>
      </div>
      <br>

      @if ($errors->any())
        <div class="alert alert-danger mb-4 position-static" style="max-height: none;">
          <ul class="mb-0 text-start">
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Form Edit Data Pembina Siswa -->
      <form action="{{ route('pembina.profile.update', $pembina->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
              <label for="teacherName" class="form-label">Nama Pembina Siswa</label>
              <input type="text" class="form-control" id="teacherName" name="nama" value="{{ old('nama', $pembina->nama) }}" required>
          </div>

          <div class="mb-3">
              <label for="teacherGender" class="form-label">Jenis Kelamin</label>
              <select class="form-select" id="teacherGender" name="jenis_kelamin" required>
                  <option value="Laki-laki" {{ old('jenis_kelamin', $pembina->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="Perempuan" {{ old('jenis_kelamin', $pembina->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
          </div>

          <div class="mb-3">
              <label for="teacherPhoto" class="form-label">Foto Pembina Siswa</label>
              <input type="file" class="form-control" id="teacherPhoto" name="image_url">
              @if($pembina->image_url && file_exists(storage_path('app/public/' . $pembina->image_url)))
                  <div class="mt-2">
                      <img src="{{ asset('storage/' . $pembina->image_url) }}" alt="Foto Pembina Siswa" class="img-thumbnail" style="width: 150px;">
                  </div>
              @endif
          </div>

          <div class="mb-3">
              <label for="teacherWhatsApp" class="form-label">WhatsApp</label>
              <input type="text" class="form-control" id="teacherWhatsApp" name="no_wa" value="{{ old('no_wa', $pembina->no_wa) }}" placeholder="Contoh: 081234567890" required>
          </div>

          <div class="mb-3">
              <label for="teacherPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="teacherPassword" placeholder="Masukkan Password (Kosongkan jika tidak ingin diubah)" name="password">
          </div>

          <div class="mb-3">
              <label for="teacherNip" class="form-label">NIP</label>
              <input type="text" class="form-control" id="teacherNip" name="nip" value="{{ old('nip', $pembina->nip) }}" required>
          </div>

          <div class="mb-3 d-flex align-items-center">
              <button type="submit" class="btn btn-success">Update Data</button>
          </div>
      </form>

    </div>
  </div>

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
