<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Siswa</title>
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

        /* Styling untuk tabel */
.table {
  width: 300%;
  border-collapse: collapse;
}

.table th, .table td {
  padding: 8px;
  text-align: left;
}

.table .btn {
  margin-right: 5px;
}

    </style>

<style>
 table {
    width: 310%;
    border-collapse: collapse; /* Menghilangkan ruang antara sel */
    border-radius: 8px; /* Sudut melengkung untuk tabel */
    overflow: hidden; /* Untuk memastikan konten tidak melampaui sudut melengkung */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan di sekitar tabel */
  }
  th, td {
    text-align: center; /* Menyelaraskan teks ke tengah */
    padding: 12px; /* Memberikan ruang dalam sel tabel */
    border: 1px solid #ddd; /* Menambahkan border di sekitar sel */
  }
  th {
    background-color: #f4f4f4; /* Warna latar belakang untuk header tabel */
    font-weight: bold; /* Membuat teks header lebih tebal */
  }
  td {
    background-color: #fff; /* Warna latar belakang untuk baris data */
  }
  tr:nth-child(even) td {
    background-color: #f9f9f9; /* Warna latar belakang untuk baris genap */
  }
  button {
    border-radius: 5px; /* Menambahkan sudut melengkung pada tombol */
  }

  .btn {
    border-radius: 10px; /* Membuat tombol melengkung */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan */
    transition: all 0.3s ease; /* Transisi halus untuk efek hover */
}

.btn-primary {
    background-color: #007bff; /* Warna biru untuk tombol utama */
    color: #fff;
}

.btn-primary:hover {
    background-color: #3399ff; /* Biru muda saat hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar saat hover */
}

.btn-danger {
    background-color: #dc3545; /* Warna merah untuk tombol batal */
    color: #fff;
}

.btn-danger:hover {
    background-color: #ff6666; /* Merah muda saat hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar saat hover */
}

</style>

<!-- Tambahkan link font Roboto dari Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Roboto', sans-serif; /* Menggunakan font Roboto */
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .container {
        padding: 20px;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background-color: #007bff;
        color: #ffffff;
        padding: 10px 15px;
        border-radius: 10px 10px 0 0;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px; /* Memberikan jarak antar elemen */
    }

    .form-group label {
        font-weight: 500; /* Bold sedang */
        margin-bottom: 5px;
        display: block; /* Mengatur label berada di atas input */
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%; /* Input field akan memenuhi lebar container */
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Efek fokus */
    }

    .card-footer {
        background-color: #f1f1f1;
        border-top: 1px solid #ddd;
        padding: 10px;
        border-radius: 0 0 10px 10px;
        text-align: right;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #333;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
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

      <a href="/siswapage" class="logo d-flex align-items-center me-auto me-xl-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Home Page Siswa">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        <li><a href="/datadiri" data-bs-toggle="tooltip" data-bs-placement="top" title="Beranda" >Beranda</a></li>
        <li><a href="/datadiripage" class="active" data-bs-toggle="tooltip" data-bs-placement="top" title="Data Diri" >Data Diri</a></li>
          <li><a href="/inputdatadiri" data-bs-toggle="tooltip" data-bs-placement="top" title="Input Data Diri">Input Data Diri</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
<form action="{{ route('logoutsiswa') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-getstarted" data-bs-toggle="tooltip" data-bs-placement="top" title="Keluar dari Akun Anda">Logout</button>
                                </form>
      

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            
             <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <div class="company-badge mb-4">
                <i class="bi bi-gear-fill me-2"></i>
                     Data Diri
              </div> 
            </div>
          </div>

          <div class="col-lg-6">
          </div>
        </div>

        <div class="row stats-row gy-100 mt-9 justify-content-start align-items-start" data-aos="fade-up" data-aos-delay="500">
        <div class="col-lg-12">
    <br>
    <h1 class="mb-4 text-center">
        Biodata Diri <br>
        <span class="accent-text"></span>
    </h1>
    <br>
    <div class="container">
        @if($biodatas->isEmpty())
            <!-- Jika data kosong -->
            <h5>Data Tidak Ditemukan</h5>
        @else
            <!-- Jika data ditemukan -->
            @foreach($biodatas as $biodata)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ $biodata->nama_lengkap }}</h5>
                    </div>
                    <div class="card-body">
                          <div class="row">
                              <!-- Kolom Pertama -->
                              <div class="col-md-6">
                                  <p><strong>Jenis Kelamin:</strong> {{ $biodata->jenis_kelamin }}</p>
                                  <p><strong>Tempat, Tanggal Lahir:</strong> {{ $biodata->tempat_lahir }}, {{ $biodata->tanggal_lahir }}</p>
                                  <p><strong>Alamat:</strong> {{ $biodata->alamat }}</p>
                                  <p><strong>Jalur Masuk:</strong> {{ $biodata->jalur_masuk }}</p>
                                  <p><strong>Jarak Rumah:</strong> {{ $biodata->jarak_rumah }}</p>
                                  <p><strong>Transportasi Sekolah:</strong> {{ $biodata->transportasi_sekolah }}</p>
                                  <p><strong>Transportasi Rumah:</strong> {{ $biodata->transportasi_rumah }}</p>
                                  <p><strong>Agama:</strong> {{ $biodata->agama }}</p>
                                  <p><strong>Kewarganaan:</strong> {{ $biodata->kewarganegaraan }}</p>
                              </div>

                              <!-- Kolom Kedua -->
                              <div class="col-md-6">
                                  <p><strong>Anak Ke:</strong> {{ $biodata->anak_ke }}</p>
                                  <p><strong>Jumlah Saudara:</strong> {{ $biodata->jumlah_saudara }}</p>
                                  <p><strong>No WA:</strong> {{ $biodata->no_wa }}</p>
                                  <p><strong>Email:</strong> {{ $biodata->email }}</p>
                                  <p><strong>NIS:</strong> {{ $biodata->nis }}</p>
                                  <p><strong>NISN:</strong> {{ $biodata->nisn }}</p>
                                  <p><strong>Kelas:</strong> {{ $biodata->kelas }}</p>
                                  <p><strong>Kompetensi:</strong> {{ $biodata->kompetensi }}</p>
                                  <p><strong>Tahun Masuk:</strong> {{ $biodata->tahun_masuk }}</p>
                              </div>
                          </div>
                         @php
                             $mapUrl = trim((string) ($biodata->alamat_maps ?? ''));
                             $mapEmbedUrl = \App\Support\GoogleMapsUrl::embedUrl($mapUrl);
                             $isGoogleMapsUrl = \App\Support\GoogleMapsUrl::isGoogleMapsUrl($mapUrl);
                         @endphp

                         <div class="mt-4">
                             <h5>Lokasi Alamat</h5>
                             @if($mapEmbedUrl)
                                 <iframe
                                     src="{{ $mapEmbedUrl }}"
                                     width="100%"
                                     height="300"
                                     style="border:0;"
                                     allowfullscreen=""
                                     loading="lazy"
                                     referrerpolicy="no-referrer-when-downgrade">
                                 </iframe>
                             @elseif($isGoogleMapsUrl)
                                 <p class="text-muted">Link singkat Google Maps tidak bisa ditampilkan langsung di sini.</p>
                                 <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary">
                                     Buka di Google Maps
                                 </a>
                             @else
                                 <p class="text-muted mb-0">Lokasi tidak tersedia.</p>
                             @endif
                         </div>
                          <td>
                                <div class="mt-4 text-center">
                                    <h5>Foto Tampak Depan Rumah</h5>
                                    @if($biodata->fotorumah_url)
                                        <img src="{{ asset('storage/'.$biodata->fotorumah_url) }}" 
                                            class="img-fluid rounded" 
                                            style="max-width: 100%; height: auto; object-fit: cover;">
                                    @else
                                        <p>No image</p>
                                    @endif
                                </div>
                            </td>
                            <br>
                            <p><strong>Kepemilikan Rumah:</strong> {{ $biodata->kepemilikan_rumah }}</p>
                          <!-- Google Maps - Tampak Depan -->
                          <!-- <div class="mt-4">
                              <h5>Tampak Depan</h5>
                              <iframe>
                                  src="https://www.google.com/maps/embed?pb={{ $biodata->alamat_maps }}&output=svembed"
                                  width="100%"
                                  height="300"
                                  style="border:0;"
                                  allowfullscreen=""
                                  loading="lazy">
                              </iframe>
                          </div> -->
                    <div class="card-header">
                        <h5>Data Orang Tua</h5>
                    </div>
                    <div class="card-body">
                      <h5>Data Ayah</h5>
                        <p><strong>Nama Ayah:</strong> {{ $biodata->nama_ayah }}</p>
                        <p><strong>Pekerjaan Ayah:</strong> {{ $biodata->pekerjaan_ayah }}</p>
                        <p><strong>Tempat, Tanggal Lahir:</strong> {{ $biodata->tempat_lahir_ayah }}, {{ $biodata->tanggal_lahir_ayah }}</p>
                        <p><strong>Alamat Ayah :</strong> {{ $biodata->alamat_ayah }}</p>
                        <p><strong>No WA Ayah:</strong> {{ $biodata->no_wa_ayah }}</p>
                        <br>
                      <h5>Data Ibu</h5>
                        <p><strong>Nama ibu:</strong> {{ $biodata->nama_ibu }}</p>
                        <p><strong>Pekerjaan ibu:</strong> {{ $biodata->pekerjaan_ibu }}</p>
                        <p><strong>Tempat, Tanggal Lahir:</strong> {{ $biodata->tempat_lahir_ibu }}, {{ $biodata->tanggal_lahir_ibu }}</p>
                        <p><strong>Alamat ibu :</strong> {{ $biodata->alamat_ibu }}</p>
                        <p><strong>No WA ibu:</strong> {{ $biodata->no_wa_ibu }}</p>
                    </div>

                    <div class="card-header">
                        <h5>Data Pendapatan Orang Tua</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Pendapatan Kedua Orangtua:</strong> {{ $biodata->pendapatan_ortu }}</p>
                    </div>
  
                    <div class="card-header">
                        <h5>Data Pelengkap</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama Sekolah Asal:</strong> {{ $biodata->namasekolah_asal }}</p>
                        <p><strong>Alamat Sekolah:</strong> {{ $biodata->alamat_sekolah }}</p>
                        <p><strong>Tahun Lulus:</strong> {{ $biodata->tahun_lulus }}</p>
                        <p><strong>Riwayat Penyakit:</strong> {{ $biodata->riwayat_penyakit }}</p>
                        <p><strong>Alergi:</strong> {{ $biodata->alergi }}</p>
                        <p><strong>Prestasi Akademik:</strong> {{ $biodata->prestasi_akademik }}</p>
                        <p><strong>Prestasi Non Akademik:</strong> {{ $biodata->prestasi_non_akademik }}</p>
                        <p><strong>Pengalaman Eskul:</strong> {{ $biodata->pengalaman_eskul }}</p>
                        <p><strong>Kepribadian:</strong> {{ $biodata->kepribadian }}</p>
                       
                    <div class="card-footer text-end">
                        <a href="{{ route('datadiri.edit', $biodata->id) }}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Biodata">Edit</a>
                    </div>
                </div>
            @endforeach
        @endif
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