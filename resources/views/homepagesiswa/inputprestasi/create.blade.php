<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Siswa</title>
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

      <a href="/siswapage" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="user-info d-flex align-items-center">
            @if(session()->has('walas_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprxofile -->
                <a href="/profilewalas" class="text-decoration-none">
                    <span>{{ $siswa->nama }}</span>  <!-- Nama Walas yang sedang login -->
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
    <div class="starter-section container" data-aos="fade-up" data-aos-delay="100">
        <!-- Header dengan Title, Pencarian, dan Tombol -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h2 class="font-weight-bold mb-0">Form Input Prestasi Siswa</h2>
                <a href="{{ route('prestasisiswainput.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Prestasi
                </a>
            </div>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">

                <div class="container mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Formulir Input Prestasi Siswa</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('prestasisiswainput.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Informasi Siswa & Kelas (Otomatis) -->
                                <div class="row mb-3 p-3 bg-light border rounded">
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="form-label text-muted small mb-1"><i class="bi bi-person-fill text-primary"></i> Nama Siswa:</label>
                                        <div class="fw-bold fs-6">{{ $siswa->nama }}</div>
                                        <input type="hidden" name="siswas_id" value="{{ $siswa->id }}">
                                    </div>
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="form-label text-muted small mb-1"><i class="bi bi-mortarboard-fill text-success"></i> Kelas / Rombel:</label>
                                        <div class="fw-bold fs-6">{{ $siswa->rombel->nama_kelas ?? 'Belum ditentukan' }}</div>
                                        <input type="hidden" name="rombels_id" value="{{ $siswa->rombels_id }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label text-muted small mb-1"><i class="bi bi-person-badge-fill text-info"></i> Wali Kelas:</label>
                                        <div class="fw-bold fs-6">{{ $siswa->rombel->walas->nama ?? 'Belum ditentukan' }}</div>
                                        <input type="hidden" name="walas_id" value="{{ $siswa->rombel->walas_id ?? '' }}">
                                    </div>
                                </div>

                                <!-- Jenis Prestasi -->
                                <div class="mb-3">
                                    <label for="jenis_prestasi" class="form-label">Jenis Prestasi <span class="text-danger">*</span>:</label>
                                    <select name="jenis_prestasi" id="jenis_prestasi" class="form-select" required>
                                        <option value="" disabled selected>Pilih Jenis Prestasi</option>
                                        <option value="Akademik" {{ old('jenis_prestasi') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="Non-akademik" {{ old('jenis_prestasi') == 'Non-akademik' ? 'selected' : '' }}>Non-akademik</option>
                                    </select>
                                </div>

                                <div class="row mb-3">
                                    <!-- Nama Prestasi (Capaian) -->
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="nama_prestasi" class="form-label">Capaian / Nama Prestasi <span class="text-danger">*</span>:</label>
                                        <input type="text" name="nama_prestasi" id="nama_prestasi" class="form-control" placeholder="Contoh: Juara 1 / Medali Emas / Harapan 2" value="{{ old('nama_prestasi') }}" required>
                                    </div>
                                    <!-- Mata Lomba -->
                                    <div class="col-md-6">
                                        <label for="mata_lomba" class="form-label">Nama Mata Lomba / Bidang:</label>
                                        <input type="text" name="mata_lomba" id="mata_lomba" class="form-control" placeholder="Contoh: LKS Web Technologies / FLS2N Vokal Solo" value="{{ old('mata_lomba') }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- Jenjang Tingkat -->
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="tingkat" class="form-label">Jenjang / Tingkat Perlombaan:</label>
                                        <input type="text" name="tingkat" id="tingkat" list="tingkatList" class="form-control" placeholder="Pilih dari opsi atau ketik sendiri (Sekolah, Kabupaten, dll)" value="{{ old('tingkat') }}">
                                        <datalist id="tingkatList">
                                            <option value="Tingkat Sekolah">
                                            <option value="Tingkat Kecamatan">
                                            <option value="Tingkat Kabupaten/Kota">
                                            <option value="Tingkat Provinsi">
                                            <option value="Tingkat Nasional">
                                            <option value="Tingkat Internasional">
                                        </datalist>
                                        <small class="text-muted">Bisa memilih rekomendasi jenjang atau langsung mengetik sendiri.</small>
                                    </div>
                                    <!-- Nama Pembimbing -->
                                    <div class="col-md-6">
                                        <label for="nama_pembimbing" class="form-label">Nama Guru Pembimbing / Pendamping:</label>
                                        <input type="text" name="nama_pembimbing" id="nama_pembimbing" class="form-control" placeholder="Contoh: Bpk. Ahmad, S.Pd." value="{{ old('nama_pembimbing') }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- Tanggal Prestasi -->
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="tanggal" class="form-label">Tanggal Pelaksanaan / Prestasi <span class="text-danger">*</span>:</label>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    </div>
                                    <!-- Lokasi -->
                                    <div class="col-md-6">
                                        <label for="lokasi" class="form-label">Lokasi / Tempat Pelaksanaan:</label>
                                        <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Contoh: SMKN 1 Cibinong / Jakarta Convention Center" value="{{ old('lokasi') }}">
                                    </div>
                                </div>

                                <!-- Sertifikat (Gambar / Dokumen) -->
                                <div class="mb-3">
                                    <label for="sertifikat_url" class="form-label">Unggah Sertifikat / Piagam (Opsional):</label>
                                    <input type="file" name="sertifikat_url" id="sertifikat_url" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.docx">
                                    <small class="text-muted">Format: JPG, PNG, PDF, DOCX (Maks 10MB)</small>
                                </div>

                                <!-- Dokumentasi (Bisa lebih dari 1 foto) -->
                                <div class="mb-3">
                                    <label for="dokumentasi_url" class="form-label">Unggah Foto Dokumentasi (Bisa lebih dari 1 foto):</label>
                                    <input type="file" name="dokumentasi_url[]" id="dokumentasi_url" class="form-control" accept="image/*" multiple>
                                    <small class="text-muted">Bisa memilih lebih dari 1 foto sekaligus. Format: JPG, JPEG, PNG, GIF (Maks 10MB per foto)</small>
                                </div>

                                <!-- Tombol Simpan -->
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Prestasi</button>
                            </form>
                        </div>
                    </div>
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
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const namaSiswaSelect = document.getElementById('nama_siswa');
        const nisInput = document.getElementById('nis');
        const nisnInput = document.getElementById('nisn');

        namaSiswaSelect.addEventListener('change', function () {
            // Ambil data-nis dan data-nisn dari option yang dipilih
            const selectedOption = this.options[this.selectedIndex];
            const nis = selectedOption.getAttribute('data-nis');
            const nisn = selectedOption.getAttribute('data-nisn');

            // Set nilai input NIS dan NISN
            nisInput.value = nis || '';
            nisnInput.value = nisn || '';
        });
    });
</script>
</script>

<script>
// Event listener untuk memilih siswa
document.getElementById('nama_siswa').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var nis = selectedOption.getAttribute('data-nis');
    var nisn = selectedOption.getAttribute('data-nisn');

    // Update field NIS dan NISN secara otomatis
    document.getElementById('nis').value = nis;
    document.getElementById('nisn').value = nisn;
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#nama_siswa').change(function () {
            let siswaId = $(this).val(); // Ambil ID siswa yang dipilih
            if (siswaId) {
                // Kirim AJAX request untuk mengambil data siswa
                $.ajax({
                    url: '/get-siswa/' + siswaId,
                    type: 'GET',
                    success: function (data) {
                        if (data) {
                            // Isi field NIS dan NISN
                            $('#nis').val(data.nis);
                            $('#nisn').val(data.nisn);
                        } else {
                            alert('Data siswa tidak ditemukan.');
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat mengambil data.');
                    }
                });
            }
        });
    });
</script>

<script>
    document.getElementById("sertifikat_url").addEventListener("change", function () {
        let file = this.files[0]; 
        let warning = document.getElementById("fileWarning1");

        if (file && file.size > 2 * 1024 * 1024) { // 2 MB dalam bytes
            warning.classList.remove("d-none"); // Munculkan peringatan
        } else {
            warning.classList.add("d-none"); // Sembunyikan peringatan
        }
    });
</script>

<script>
    document.getElementById("dokumentasi_url").addEventListener("change", function () {
        let file = this.files[0]; 
        let warning = document.getElementById("fileWarning2");

        if (file && file.size > 1 * 1024 * 1024) { // 1 MB dalam bytes
            warning.classList.remove("d-none"); // Munculkan peringatan
        } else {
            warning.classList.add("d-none"); // Sembunyikan peringatan
        }
    });
</script>



</body>

</html>