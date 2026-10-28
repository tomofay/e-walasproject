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
      <div class="user-info d-flex align-items-center">
            @if(session()->has('walas_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilewalas" class="text-decoration-none">
                    <span>{{ $walaslogin->nama }}</span>  <!-- Nama Walas yang sedang login -->
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
                <h2 class="font-weight-bold mb-0">Buku Tamu Orangtua\Wali Murid</h2>
                <a href="{{ route('bukutamuortu.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <hr class="my-3"> <!-- Garis horizontal di bawah judul -->
            <div class="d-flex align-items-center justify-content-start">

        <!-- Formulir Home Visit dalam Card -->
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h3>Formulir Buku Tamu Orangtua Data</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('bukutamuortu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Wali Kelas -->
                        <div class="mb-3">
                            <label for="walas_id" class="form-label">Wali Kelas:</label>
                            <select name="walas_id" id="walas_id" class="form-select" required>
                                @foreach($walas as $walas_item)
                                    <option value="{{ $walas_item->id }}">{{ $walas_item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal:</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>

                         <!-- Siswa -->
                         <div class="mb-3">
                            <label for="nama_peserta_didik" class="form-label">Pilih Siswa:</label>
                            <select name="nama_peserta_didik" id="nama_peserta_didik" class="form-control" required>
                                <option value="" disabled selected>Pilih Siswa</option>
                                @foreach ($siswas as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama ortu -->
                        <div class="mb-3">
                            <label for="nama_orang_tua" class="form-label">Nama Orang tua/Wali murid:</label>
                            <input name="nama_orang_tua" id="nama_orang_tua" class="form-control" rows="3" required></input>
                        </div>

                        <!-- Kasus -->
                        <div class="mb-3">
                            <label for="kasus" class="form-label">Keperluan:</label>
                            <textarea name="kasus" id="kasus" class="form-control" rows="3" required></textarea>
                        </div>

                        <!-- Kasus -->
                        <div class="mb-3">
                        <label for="solusi" class="form-label">Solusi:</label>
                            <textarea name="solusi" id="solusi" class="form-control" rows="3" required></textarea>
                        </div>

                         <!-- Kasus -->
                        <div class="mb-3">
                        <label for="tindak_lanjut" class="form-label">Tindak Lanjut:</label>
                            <textarea name="tindak_lanjut" id="tindak_lanjut" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Unggah Dokumentasi (Gambar):</label>
                            
                            <!-- Tombol untuk membuka kamera -->
                            <button type="button" id="openCamera" class="btn btn-secondary">Buka Kamera</button>

                            <!-- Video stream dari kamera -->
                            <div id="cameraContainer" class="d-none">
                                <video id="video" autoplay class="w-100"></video>
                                <button type="button" id="captureImage" class="btn btn-primary mt-2">Ambil Gambar</button>
                            </div>

                            <!-- Canvas untuk menangkap gambar -->
                            <canvas id="canvas" class="d-none"></canvas>

                            <!-- Preview gambar -->
                            <img id="previewDokumentasi" class="img-thumbnail d-none mt-2" width="200">

                            <!-- Input file (bisa pakai kamera atau upload manual) -->
                            <input type="file" name="dokumentasi_url" id="dokumentasi_url" accept="image/*" class="form-control mt-2">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
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
  <script>
        document.addEventListener("DOMContentLoaded", function() {
    const openCameraBtn = document.getElementById("openCamera");
    const captureImageBtn = document.getElementById("captureImage");
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const previewImg = document.getElementById("previewDokumentasi");
    const fileInput = document.getElementById("dokumentasi_url");
    const cameraContainer = document.getElementById("cameraContainer");

    let stream = null;

    // Buka kamera saat tombol diklik
    openCameraBtn.addEventListener("click", async function() {
        cameraContainer.classList.remove("d-none");
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        } catch (error) {
            alert("Kamera tidak bisa diakses. Coba izinkan akses kamera.");
            console.error(error);
        }
    });

    // Tangkap gambar dari kamera dan kecilkan ukuran
    captureImageBtn.addEventListener("click", function() {
        const maxWidth = 640;  // Lebar maksimum (bisa diubah)
        const maxHeight = 480; // Tinggi maksimum (bisa diubah)
        
        const aspectRatio = video.videoWidth / video.videoHeight;

        let newWidth = maxWidth;
        let newHeight = maxWidth / aspectRatio;

        if (newHeight > maxHeight) {
            newHeight = maxHeight;
            newWidth = maxHeight * aspectRatio;
        }

        // Atur ukuran canvas agar lebih kecil
        canvas.width = newWidth;
        canvas.height = newHeight;
        canvas.getContext("2d").drawImage(video, 0, 0, newWidth, newHeight);

        // Konversi ke blob dengan kualitas rendah (JPEG 0.7)
        canvas.toBlob(blob => {
            const file = new File([blob], "dokumentasi.jpg", { type: "image/jpeg" });

            // Masukkan file ke dalam input file
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;

            // Tampilkan preview
            previewImg.src = URL.createObjectURL(blob);
            previewImg.classList.remove("d-none");

            // Matikan kamera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            cameraContainer.classList.add("d-none");
        }, "image/jpeg", 0.7); // Kualitas 0.7 (bisa diubah, makin kecil makin ringan)
    });
});
       </script>

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
    document.getElementById("dokumentasi_url").addEventListener("change", function () {
        let file = this.files[0]; 
        let warning = document.getElementById("fileWarning");

        if (file && file.size > 1 * 1024 * 1024) { // 1 MB dalam bytes
            warning.classList.remove("d-none"); // Munculkan peringatan
        } else {
            warning.classList.add("d-none"); // Sembunyikan peringatan
        }
    });
</script>


</body>

</html>