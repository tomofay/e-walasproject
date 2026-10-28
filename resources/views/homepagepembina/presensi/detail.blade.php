<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Detail Presensi {{ $presensi->kelas }}</title>
  <meta name="description" content="Detail Presensi Siswa SMKN 1 Cibinong">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('images/logokampak.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css?v=2') }}" rel="stylesheet">

  <style>
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

    .stat-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        text-align: center;
        border: 1px solid #dee2e6;
    }

    .table thead th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        vertical-align: middle;
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
      <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">

        <!-- Header dengan Title dan Tombol -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h2 class="font-weight-bold mb-1">Detail Presensi: {{ $presensi->kelas }}</h2>
                    <p class="text-muted mb-0">
                        Tanggal: <strong>{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('l, d F Y') }}</strong> | Wali Kelas: <strong>{{ $presensi->walas->nama ?? '-' }}</strong>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('pembina.presensi.index') }}" class="btn btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Hadir
                    </a>
                </div>
            </div>
            <hr class="my-3">
        </div>

        <!-- Attendance Stats Counters -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card border-top border-4 border-success">
                    <span class="text-muted small text-uppercase fw-semibold">Hadir</span>
                    <h3 class="fw-bold text-success mb-0 mt-1">{{ $summary['hadir'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-top border-4 border-warning">
                    <span class="text-muted small text-uppercase fw-semibold">Sakit</span>
                    <h3 class="fw-bold text-warning mb-0 mt-1">{{ $summary['sakit'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-top border-4 border-info">
                    <span class="text-muted small text-uppercase fw-semibold">Izin</span>
                    <h3 class="fw-bold text-info mb-0 mt-1">{{ $summary['izin'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card border-top border-4 border-danger">
                    <span class="text-muted small text-uppercase fw-semibold">Alfa</span>
                    <h3 class="fw-bold text-danger mb-0 mt-1">{{ $summary['alfa'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Student Attendance Table -->
        <div class="container mt-2 px-0">
            <h4 class="mb-3">Daftar Kehadiran Siswa</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th class="text-center" style="width: 140px;">Status</th>
                            <th>Keterangan Tambahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($presensi->detailPresensis as $idx => $detail)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td><strong>{{ $detail->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</strong></td>
                                <td>{{ $detail->siswa->nis ?? '-' }}</td>
                                <td class="text-center">
                                    @if($detail->status == 'hadir')
                                        <span class="badge bg-success px-3 py-2">Hadir</span>
                                    @elseif($detail->status == 'sakit')
                                        <span class="badge bg-warning text-dark px-3 py-2">Sakit</span>
                                    @elseif($detail->status == 'izin')
                                        <span class="badge bg-info text-dark px-3 py-2">Izin</span>
                                    @elseif($detail->status == 'alfa')
                                        <span class="badge bg-danger px-3 py-2">Alfa</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">{{ ucfirst($detail->status ?? '-') }}</span>
                                    @endif
                                </td>
                                <td>{{ $detail->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Tidak ada data detail presensi siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

      </div>
    </section>

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
