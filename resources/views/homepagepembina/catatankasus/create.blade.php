<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Tambah Catatan Kasus</title>
  <meta name="description" content="Tambah Catatan Kasus Siswa SMKN 1 Cibinong">
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

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .form-label {
        font-weight: 600;
        color: #333;
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
                <h2 class="font-weight-bold mb-0">Catatan Kasus Siswa</h2>
                <a href="{{ route('pembina.catatankasus.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Catatan Kasus
                </a>
            </div>
            <hr class="my-3">
        </div>

        <!-- Formulir dalam Card -->
        <div class="container mt-4 px-0">
          <div class="card">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold">Formulir Catatan Kasus Siswa</h4>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                  <div class="alert alert-danger mb-4 position-static" style="max-height: none;">
                    <ul class="mb-0 text-start">
                      @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <form action="{{ route('pembina.catatankasus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Filter Kelas & Siswa -->
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="filter_rombel" class="form-label">Filter Kelas Siswa:</label>
                            <select id="filter_rombel" class="form-select" onchange="filterStudentsByRombel()">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($rombels as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_kelas }} ({{ $r->kompetensi }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih kelas untuk menyaring daftar pilihan siswa di sebelah kanan.</small>
                        </div>
                        <div class="col-md-7">
                            <label for="siswas_id" class="form-label">Pilih Siswa: <span class="text-danger">*</span></label>
                            <select name="siswas_id" id="siswas_id" class="form-select" required>
                                <option value="" disabled selected>Pilih Siswa</option>
                                @foreach ($siswas as $s)
                                    <option value="{{ $s->id }}" data-rombel="{{ $s->rombels_id }}" {{ old('siswas_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama }} ({{ $s->rombel->nama_kelas ?? 'Tanpa Kelas' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal & Waktu -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal Kejadian / Catatan: <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="waktu" class="form-label">Waktu Kejadian: <span class="text-danger">*</span></label>
                            <input type="time" name="waktu" id="waktu" class="form-control" value="{{ old('waktu', date('H:i')) }}" required>
                        </div>
                    </div>

                    <!-- Kasus -->
                    <div class="mb-3">
                        <label for="kasus" class="form-label">Kasus Siswa: <span class="text-danger">*</span></label>
                        <input type="text" name="kasus" id="kasus" class="form-control" placeholder="Masukkan perihal kasus siswa" value="{{ old('kasus') }}" required>
                    </div>

                    <!-- Tindak Lanjut / Sanksi -->
                    <div class="mb-3">
                        <label for="tindak_lanjut" class="form-label">Tindak Lanjut / Sanksi: <span class="text-danger">*</span></label>
                        <input type="text" name="tindak_lanjut" id="tindak_lanjut" class="form-control" placeholder="Contoh: Pemanggilan orang tua / Pembinaan khusus / Surat peringatan" value="{{ old('tindak_lanjut') }}" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan: <span class="text-danger">*</span></label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan mengenai kasus..." required>{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Upload File / Bukti -->
                    <div class="mb-4">
                        <label for="file_kasus" class="form-label">Upload File / Foto Bukti Kasus (Bisa pilih banyak foto):</label>
                        <input type="file" name="file_kasus[]" id="file_kasus" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Bisa memilih lebih dari satu foto/dokumen sekaligus. Format: JPG, JPEG, PNG, WEBP, PDF, DOC, DOCX (Maks 10MB per file).</small>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        <a href="{{ route('pembina.catatankasus.index') }}" class="btn btn-secondary px-3">Batal</a>
                    </div>
                </form>
            </div>
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
    function filterStudentsByRombel() {
        const selectedRombel = document.getElementById('filter_rombel').value;
        const studentSelect = document.getElementById('siswas_id');
        const options = studentSelect.options;

        let visibleCount = 0;
        for (let i = 1; i < options.length; i++) {
            const opt = options[i];
            const rombelId = opt.getAttribute('data-rombel');
            if (!selectedRombel || rombelId === selectedRombel) {
                opt.style.display = '';
                visibleCount++;
            } else {
                opt.style.display = 'none';
            }
        }

        const currentSelected = studentSelect.selectedOptions[0];
        if (currentSelected && currentSelected.style.display === 'none') {
            studentSelect.value = '';
        }
    }

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
