<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Catatan Kasus Siswa</title>
  <meta name="description" content="Kelola Catatan Kasus Siswa SMKN 1 Cibinong">
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

    .card-filter {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 18px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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

        <!-- Header dengan Title, Pencarian, dan Tombol -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h2 class="font-weight-bold mb-0">Catatan Kasus Siswa</h2>
                <a href="{{ route('pembina.dashboard') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
            <hr class="my-3">
            <div class="d-flex align-items-center justify-content-start flex-wrap gap-2">
                <a href="{{ route('pembina.catatankasus.create') }}" class="btn btn-primary me-2 mb-2">
                    <i class="bi bi-plus"></i> Tambah
                </a>
                <a href="{{ route('pembina.catatankasus.index', array_merge(request()->query(), ['export' => 'pdf'])) }}" class="btn btn-outline-secondary me-2 mb-2" target="_blank">
                    <i class="bi bi-download"></i> Unduh PDF
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card-filter">
          <form method="GET" action="{{ route('pembina.catatankasus.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Cari Nama Siswa / Kasus:</label>
              <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Ketik kata kunci pencarian...">
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold">Filter Kelas / Rombel:</label>
              <select name="rombel_id" class="form-select">
                <option value="">Semua Rombel</option>
                @foreach($rombels as $r)
                  <option value="{{ $r->id }}" {{ request('rombel_id') == $r->id ? 'selected' : '' }}>
                    {{ $r->nama_kelas }} ({{ $r->kompetensi }})
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold">Filter Tanggal:</label>
              <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
            </div>

            <div class="col-md-2 d-flex gap-2">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-filter"></i> Filter
              </button>
              @if(request()->hasAny(['keyword', 'rombel_id', 'tanggal']))
                <a href="{{ route('pembina.catatankasus.index') }}" class="btn btn-outline-secondary" title="Reset">
                  <i class="bi bi-arrow-counterclockwise"></i>
                </a>
              @endif
            </div>
          </form>
        </div>

        <div class="container mt-2 px-0">
          <h4 class="mb-3">Daftar Catatan Kasus Siswa</h4>

          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">No</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Tanggal & Waktu</th>
                  <th>Kasus</th>
                  <th>Tindak Lanjut / Sanksi</th>
                  <th>Keterangan</th>
                  <th class="text-center">Foto Dokumentasi</th>
                  <th class="text-center" style="width: 140px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($catatankasus as $idx => $data)
                  <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>
                      <strong>{{ $data->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</strong>
                      @if($data->siswa && $data->siswa->nis)
                        <br><small class="text-muted">NIS: {{ $data->siswa->nis }}</small>
                      @endif
                    </td>
                    <td>
                      <span class="badge bg-secondary">{{ $data->siswa->rombel->nama_kelas ?? '-' }}</span>
                    </td>
                    <td>
                      @if($data->tanggal)
                        <strong>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</strong>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                      @if($data->waktu)
                        <br><small class="text-muted"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($data->waktu)->format('H:i') }} WIB</small>
                      @endif
                    </td>
                    <td>{{ $data->kasus }}</td>
                    <td><span class="badge bg-warning text-dark">{{ $data->tindak_lanjut }}</span></td>
                    <td>{{ $data->keterangan }}</td>
                    <td class="text-center">
                      @php
                        $files = is_array($data->file_kasus) ? $data->file_kasus : ($data->file_kasus ? [$data->file_kasus] : []);
                      @endphp
                      @if(!empty($files))
                        <div class="d-flex flex-wrap gap-1 justify-content-center">
                          @foreach($files as $file)
                            @php
                              $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            @endphp
                            @if(in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif', 'webp']))
                              <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                <img src="{{ asset('storage/' . $file) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ced4da;" title="Lihat Foto">
                              </a>
                            @else
                              <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="{{ basename($file) }}">
                                <i class="bi bi-file-earmark-text"></i> File
                              </a>
                            @endif
                          @endforeach
                        </div>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-1">
                        <a href="{{ route('pembina.catatankasus.edit', $data->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('pembina.catatankasus.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan kasus ini?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                      Tidak ada catatan kasus siswa ditemukan.
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
