<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Walas</title>
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

      <a href="/adminwalas" class="logo d-flex align-items-center me-auto me-xl-0">
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

      <!-- Edit Form Catatan Kasus Siswa -->
    <section id="hero" class="hero section">
        <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">
            <!-- Header dengan Title -->
            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h2 class="font-weight-bold mb-0">Edit Catatan Kasus Siswa</h2>
                <a href="{{ route('catatankasus.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
                <hr class="my-3">
            </div>

            <!-- Formulir Edit Catatan Kasus dalam Card -->
            <div class="container mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Catatan Kasus</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('catatankasus.update', $catatan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Gunakan metode PUT untuk update -->

                            <!-- Wali Kelas -->
                            <div class="mb-3">
                                <label for="walas_id" class="form-label">Wali Kelas:</label>
                                <input type="text" class="form-control" value="{{ $walas->nama }}" disabled>
                                <input type="hidden" name="walas_id" value="{{ $walas->id }}">
                            </div>

                            <!-- Siswa -->
                            <div class="mb-3">
                                <label for="siswas_id" class="form-label">Pilih Siswa:</label>
                                <select name="siswas_id" id="siswas_id" class="form-control" required>
                                    @foreach ($siswas as $s)
                                        <option value="{{ $s->id }}" 
                                            {{ old('siswas_id', $catatan->siswas_id) == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tanggal & Waktu -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tanggal" class="form-label">Tanggal Kejadian / Catatan:</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                        value="{{ old('tanggal', $catatan->tanggal ? \Carbon\Carbon::parse($catatan->tanggal)->format('Y-m-d') : date('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="waktu" class="form-label">Waktu Kejadian:</label>
                                    <input type="time" name="waktu" id="waktu" class="form-control" 
                                        value="{{ old('waktu', $catatan->waktu ? \Carbon\Carbon::parse($catatan->waktu)->format('H:i') : date('H:i')) }}" required>
                                </div>
                            </div>

                            <!-- Kasus -->
                            <div class="mb-3">
                                <label for="kasus" class="form-label">Kasus Siswa:</label>
                                <input type="text" name="kasus" id="kasus" class="form-control" 
                                    value="{{ old('kasus', $catatan->kasus) }}" required>
                            </div>

                            <!-- Tindak Lanjut / Sanksi -->
                            <div class="mb-3">
                                <label for="tindak_lanjut" class="form-label">Tindak Lanjut / Sanksi:</label>
                                <input type="text" name="tindak_lanjut" id="tindak_lanjut" class="form-control" 
                                    placeholder="Contoh: Pemanggilan orang tua / Pembinaan khusus / Surat peringatan"
                                    value="{{ old('tindak_lanjut', $catatan->tindak_lanjut) }}" required>
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan:</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $catatan->keterangan) }}</textarea>
                            </div>

                            <!-- Upload File / Bukti -->
                            <div class="mb-3">
                                <label class="form-label">File / Foto Bukti Kasus Saat Ini:</label>
                                @php
                                    $existingFiles = is_array($catatan->file_kasus) ? $catatan->file_kasus : ($catatan->file_kasus ? [$catatan->file_kasus] : []);
                                @endphp
                                @if(!empty($existingFiles))
                                    <input type="hidden" name="form_has_files" value="1">
                                    <div class="mb-3">
                                            @php
                                                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                            @endphp
                                            <div class="mb-2 p-2 bg-light border rounded d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="checkbox" name="keep_files[]" value="{{ $filePath }}" id="keep_file_{{ $idxFile }}" checked class="form-check-input me-1">
                                                    @if(in_array($ext, ['jpeg', 'png', 'jpg', 'gif', 'webp']))
                                                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                                            <img src="{{ asset('storage/' . $filePath) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ced4da;">
                                                        </a>
                                                    @else
                                                        <i class="bi bi-file-earmark-text fs-3 text-primary"></i>
                                                    @endif
                                                    <label for="keep_file_{{ $idxFile }}" class="form-check-label small mb-0">
                                                        <strong>{{ basename($filePath) }}</strong>
                                                        <br><span class="text-muted small">Hapus centang untuk menghapus file ini</span>
                                                    </label>
                                                </div>
                                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="btn btn-file-bukti">
                                                    <i class="bi bi-box-arrow-up-right me-1"></i> Lihat File
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted small fst-italic mb-2">Belum ada file/foto bukti yang diunggah.</p>
                                @endif

                                <label for="file_kasus" class="form-label">Tambah Foto / File Bukti Baru (Bisa pilih banyak):</label>
                                <input type="file" name="file_kasus[]" id="file_kasus" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <small class="text-muted">Bisa memilih lebih dari satu foto/file sekaligus. Format: JPG, JPEG, PNG, PDF, DOC, DOCX (Maks 10MB per file).</small>
                            </div>

                            <!-- Tombol Simpan -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
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