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

        #server-validation-errors,
        #client-validation-errors {
            position: static;
            display: block;
            max-height: none;
            overflow: visible;
            color: #842029;
            text-align: left;
            animation: none;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
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

/* Mengatur tampilan grid agar lebih rapi */
#pendapatan_ortu {
    padding: 0;
    margin: 0;
}

/* Styling untuk setiap item dalam list */
#pendapatan_ortu li {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 15px;
    padding: 8px;
    border-radius: 8px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

/* Efek hover untuk item */
#pendapatan_ortu li:hover {
    background-color: #f0f8ff;
    transform: scale(1.05);
}

/* Menambahkan icon atau gambar checkbox kecil di sebelah label untuk tampilan lebih menarik */
#pendapatan_ortu input[type="radio"] {
    margin-right: 10px;
    accent-color: #007bff;
}

/* Styling label supaya lebih jelas dan terpisah dengan baik */
#pendapatan_ortu label {
    font-size: 16px;
    font-weight: 500;
    color: #333;
}

/* Responsif untuk layar kecil */
@media (max-width: 767px) {
    #pendapatan_ortu li {
        flex: 0 0 50%; /* 2 kolom di layar kecil */
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

      <a href="/siswapage" class="logo d-flex align-items-center me-auto me-xl-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Halaman Home Page Siswa">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        <li><a href="/datadiri" data-bs-toggle="tooltip" data-bs-placement="top" title="Beranda">Beranda</a></li>
        <li><a href="/datadiripage" data-bs-toggle="tooltip" data-bs-placement="top" title="Data Diri" >Data Diri</a></li>
          <li><a href="/inputdatadiri" class="active"data-bs-toggle="tooltip" data-bs-placement="top" title="Input Data Diri" >Input Data Diri</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="user-info d-flex align-items-center">
            @if(session()->has('siswa_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilesiswa" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Profile">
                    <span>{{ $siswa->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif

            <form action="{{ route('logoutsiswa') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn-getstarted" data-bs-toggle="tooltip" data-bs-placement="top" title="Keluar dari Akun Anda">Logout</button>
            </form>
        </div>
      

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
                    Input Data Diri
              </div> 

              <!-- <h1 class="mb-4">
               Kelola Data Diri Siswa <br>
                <span class="accent-text">SMK Negeri 1 Cibinong</span>
              </h1> -->

              <!-- <div class="hero-buttons">
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn btn-link tutorial-btn mt-2 mt-sm-0 glightbox">
                    <i class="bi bi-play-circle me-1"></i>
                    Tutorial Penggunaan Website
                </a> 
            </div> -->
            </div>
          </div>

          <div class="col-lg-6">
            <!-- <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
              <img src="assets/img/illustration-1.webp" alt="Hero Image" class="img-fluid">
            </div> -->
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
            <form id="biodata-form" action="{{ route('biodatasiswa.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert" tabindex="-1" id="server-validation-errors">
                        <strong>Data belum dapat dikirim. Perbaiki bagian berikut:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="client-validation-errors" class="alert alert-danger d-none" role="alert" tabindex="-1">
                    <strong>Data belum lengkap atau tidak valid:</strong>
                    <ul class="mb-0 mt-2"></ul>
                </div>
        <h4 class="text-bold">Data Pribadi</h4>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                    </div>
                </div>  
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control w-100" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                        <label for="walas" class="form-label">Wali Kelas</label>
                        <select class="form-select" id="walas" name="walas_id" required>
                            <option value="" selected disabled>Pilih Wali Kelas</option>
                            @foreach ($walas as $wali)
                                <option value="{{ $wali->id }}">{{ $wali->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control w-100" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control w-100" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control w-100" rows="3" required></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="alamat_maps" class="form-label">Alamat Maps</label>
                        <textarea name="alamat_maps" id="alamat_maps" class="form-control w-100" rows="3" required></textarea>
                    </div>
                </div>

                  <!-- Dokumentasi (Gambar) -->
                  <div class="row mb-3">
                        <label for="fotorumah_url" class="form-label">Unggah Foto Tampak Depan Rumah (Gambar):</label>
                        <input type="file" name="fotorumah_url" id="fotorumah_url" class="form-control" accept=".jpg,.jpeg,.png,.gif" required>
                        <small id="fileWarning" class="text-danger d-none">Ukuran file tidak boleh lebih dari 2 MB!</small>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="kepemilikan_rumah" class="form-label">Kepemilikan Rumah</label>
                        <select name="kepemilikan_rumah" id="kepemilikan_rumah" class="form-control w-100" required>
                            <option value="Lunas">Lunas</option>
                            <option value="Sewa">Sewa</option>
                            <option value="KPR/Kredit">KPR/Kredit</option>
                            <option value="Kontrak">Kontrak</option>
                            <option value="Inden">Inden</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="jalur_masuk" class="form-label">Jalur Masuk</label>
                        <select name="jalur_masuk" id="jalur_masuk" class="form-control w-100" required>
                            <option value="Afirmasi">Afirmasi</option>
                            <option value="Zonasi">Zonasi</option>
                            <option value="Rapor">Rapor</option>
                            <option value="Prestasi">Prestasi</option>
                            <option value="Anak Guru">Anak Guru</option>
                            <option value="Perpindahan Orang Tua">Perpindahan Orang Tua</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jarak_rumah" class="form-label">Jarak Rumah (KM)</label>
                        <input type="text" placeholder="dalam Kilometer (cth. 3 km)" name="jarak_rumah" id="jarak_rumah" class="form-control" maxlength="255" required>
                    </div>
                    <div class="col-md-6">
                        <label for="transportasi_sekolah" class="form-label">Transportasi ke Sekolah</label>
                        <input type="text" name="transportasi_sekolah" id="transportasi_sekolah" class="form-control" maxlength="255" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="transportasi_rumah" class="form-label">Transportasi ke Rumah</label>
                        <input type="text" name="transportasi_rumah" id="transportasi_rumah" class="form-control" maxlength="255" required>
                    </div>
                    <div class="col-md-6">
                        <label for="agama" class="form-label">Agama</label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Kristen Katolik">Kristen Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" maxlength="20" required>
                    </div>
                    <div class="col-md-3">
                        <label for="anak_ke" class="form-label">Anak Ke</label>
                        <input type="number" name="anak_ke" id="anak_ke" class="form-control" min="1" max="99999" required>
                    </div>
                    <div class="col-md-3">
                        <label for="jumlah_saudara" class="form-label">Jumlah Saudara</label>
                        <input type="number" name="jumlah_saudara" id="jumlah_saudara" class="form-control" min="0" max="99999" required>
                    </div>
                </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" id="no_wa" class="form-control" maxlength="14" pattern="[0-9+ -]+" placeholder="Contoh: 081234567890" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" maxlength="50" placeholder="Contoh: email@example.com" required>
                </div>
            </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control" maxlength="20" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" name="nisn" id="nisn" class="form-control" maxlength="20" required>
                    </div>
                </div>
                <div class="row mb-3">
                      <div class="col-md-6">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control" required>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                            <option value="XIII">XIII</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="kompetensi" class="form-label">Kompetensi</label>
                        <select name="kompetensi" id="kompetensi" class="form-control" required>
                            <option value="SIJA">SIJA</option>
                            <option value="TKJ">TKJ</option>
                            <option value="RPL">RPL</option>
                            <option value="DKV">DKV</option>
                            <option value="DPIB">DPIB</option>
                            <option value="TKP">TKP</option>
                            <option value="TP">TP</option>
                            <option value="TFLM">TFLM</option>
                            <option value="TKR">TKR</option>
                            <option value="TOI">TOI</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                        <input type="text" name="tahun_masuk" id="tahun_masuk" class="form-control" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" required>
                    </div>
                </div>  
                <br>
                <h4 class="text-bold">Data Orang Tua atau Wali</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" maxlength="80" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                        <ul id="pekerjaan_ayah" class="list-unstyled d-flex flex-wrap">
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="TNI/POLRI" id="ayah_tni_polri" required>
                                <label for="TNI_POLRI">TNI/POLRI</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="ASN/PNS" id="ASN_PNS" onchange="togglePekerjaanInput()"> 
                                <label for="ASN_PNS">ASN/PNS</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Karyawan" id="Karyawan" onchange="togglePekerjaanInput()"> 
                                <label for="Karyawan">Karyawan</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Wiraswasta" id="Wiraswasta" onchange="togglePekerjaanInput()"> 
                                <label for="Wiraswasta">Wiraswasta</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Pengemudi" id="Pengemudi" onchange="togglePekerjaanInput()"> 
                                <label for="Pengemudi">Pengemudi</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Buruh" id="Buruh" onchange="togglePekerjaanInput()"> 
                                <label for="Buruh">Buruh</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Tani" id="Tani" onchange="togglePekerjaanInput()"> 
                                <label for="Tani">Tani</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Pensiunan" id="Pensiunan" onchange="togglePekerjaanInput()"> 
                                <label for="Pensiunan">Pensiunan</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Lainnya" id="Lainnya" onchange="togglePekerjaanInput()"> 
                                <label for="Lainnya">Lainnya</label>
                            </li>
                        </ul>
                        <input type="text" name="pekerjaan_ayah_lainnya" id="pekerjaan_ayah_lainnya" class="form-control mt-2" placeholder="Masukkan pekerjaan lain..." style="display: none;">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah</label>
                        <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" class="form-control" maxlength="50" placeholder="Contoh: Jakarta" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah</label>
                        <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alamat_ayah" class="form-label">Alamat Ayah</label>
                        <textarea name="alamat_ayah" id="alamat_ayah" class="form-control" rows="3" placeholder="Contoh: Jl. Mawar No. 123, Jakarta" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="no_wa_ayah" class="form-label">Nomor WhatsApp Ayah</label>
                        <input type="text" name="no_wa_ayah" id="no_wa_ayah" class="form-control" maxlength="15" pattern="[0-9+ -]+" placeholder="Contoh: 62895672349221 (Masukkan No Telp Aktif dan Valid)" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" maxlength="50" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                        <ul id="pekerjaan_ibu" class="list-unstyled d-flex flex-wrap">
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="TNI/POLRI" id="ibu_tni_polri" required>
                                <label for="TNI_POLRI">TNI/POLRI</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="ASN/PNS" id="ASN_PNS" onchange="togglePekerjaanInput()"> 
                                <label for="ASN_PNS">ASN/PNS</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Karyawan" id="Karyawan" onchange="togglePekerjaanInput()"> 
                                <label for="Karyawan">Karyawan</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Wiraswasta" id="Wiraswasta" onchange="togglePekerjaanInput()"> 
                                <label for="Wiraswasta">Wiraswasta</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Ibu Rumah Tangga" id="Pengemudi" onchange="togglePekerjaanInput()"> 
                                <label for="Ibu Rumah Tangga">Ibu Rumah Tangga</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Buruh" id="Buruh" onchange="togglePekerjaanInput()"> 
                                <label for="Buruh">Buruh</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Tani" id="Tani" onchange="togglePekerjaanInput()"> 
                                <label for="Tani">Tani</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Pensiunan" id="Pensiunan" onchange="togglePekerjaanInput()"> 
                                <label for="Pensiunan">Pensiunan</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Lainnya" id="Lainnya" onchange="togglePekerjaanInput()"> 
                                <label for="Lainnya">Lainnya</label>
                            </li>
                        </ul>
                        <input type="text" name="pekerjaan_ibu_lainnya" id="pekerjaan_ibu_lainnya" class="form-control mt-2" placeholder="Masukkan pekerjaan lain..." style="display: none;">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu</label>
                        <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" class="form-control" maxlength="50" placeholder="Contoh: Jakarta" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu</label>
                        <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alamat_ibu" class="form-label">Alamat Ibu</label>
                        <textarea name="alamat_ibu" id="alamat_ibu" class="form-control" rows="3" placeholder="Contoh: Jl. Mawar No. 123, Jakarta" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="no_wa_ibu" class="form-label">Nomor WhatsApp Ibu</label>
                        <input type="text" name="no_wa_ibu" id="no_wa_ibu" class="form-control" maxlength="15" pattern="[0-9+ -]+" placeholder="Contoh: 6289623472983721 (Masukkan No Telp Aktif dan Valid)" required>
                    </div>
                </div>
                <br>
                <h4 class="text-bold">Rentang Pendapatan Kedua Orangtua</h4>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="pendapatan_ortu" class="form-label">Pendapatan Ayah dan Ibu</label>
                            <ul id="pendapatan_ortu" class="list-unstyled d-flex flex-wrap">
                                <li class="col-md-3 col-sm-6">
                                    <input type="radio" name="pendapatan_ortu" value="Kurang dari Rp1.000.000,00" id="Kurang_dari_Rp1_000_000_00" required>
                                    <label for="Kurang_dari_Rp1_000_000_00">Kurang dari Rp1.000.000,00</label>
                                </li>
                                <li class="col-md-3 col-sm-6">
                                    <input type="radio" name="pendapatan_ortu" value="Rp1.000.000,00 - Rp3.000.000,00" id="Rp1_000_000_00_-_Rp3_000_000_00" onchange="togglePekerjaanInput()">
                                    <label for="Rp1_000_000_00_-_Rp3_000_000_00">Rp1.000.000,00 - Rp3.000.000,00</label>
                                </li>
                                <li class="col-md-3 col-sm-6">
                                    <input type="radio" name="pendapatan_ortu" value="Rp3.000.000,00 - Rp5.000.000,00" id="Rp3_000_000_00_-_Rp5_000_000_00" onchange="togglePekerjaanInput()">
                                    <label for="Rp3_000_000_00_-_Rp5_000_000_00">Rp3.000.000,00 - Rp5.000.000,00</label>
                                </li>
                                <li class="col-md-3 col-sm-6">
                                    <input type="radio" name="pendapatan_ortu" value="Rp5.000.000,00 - Rp10.000.000,00" id="Rp5_000_000_00_-_Rp10_000_000_00" onchange="togglePekerjaanInput()">
                                    <label for="Rp5_000_000_00_-_Rp10_000_000_00">Rp5.000.000,00 - Rp10.000.000,00</label>
                                </li>
                                <li class="col-md-3 col-sm-6">
                                    <input type="radio" name="pendapatan_ortu" value="Rp10.000.000,00 - Rp25.000.000,00" id="Rp10_000_000_00_-_Rp25_000_000_00" onchange="togglePekerjaanInput()">
                                    <label for="Rp10_000_000_00_-_Rp25_000_000_00">Rp10.000.000,00 - Rp25.000.000,00</label>
                                </li>
                                <li class="col-md-3 col-sm-6">
                                    <input type="radio" name="pendapatan_ortu" value="Rp25.000.000,00 - Rp50.000.000,00" id="Rp25_000_000_00_-_Rp50_000_000_00" onchange="togglePekerjaanInput()">
                                    <label for="Rp25_000_000_00_-_Rp50_000_000_00">Rp25.000.000,00 - Rp50.000.000,00</label>
                                </li>
                                <li class="col-md-3 col-sm-6">
                                    <input type="radio" name="pendapatan_ortu" value="Lebih dari Rp50.000.000,00" id="Lebih_dari_Rp50_000_000_00" onchange="togglePekerjaanInput()">
                                    <label for="Lebih_dari_Rp50_000_000_00">Lebih dari Rp50.000.000,00</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                <br>
                <h4>Data Pendidikan Sebelumnya</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="namasekolah_asal" class="form-label">Nama Sekolah Asal</label>
                        <input type="text" name="namasekolah_asal" id="namasekolah_asal" class="form-control" maxlength="50" placeholder="Contoh: SMK Negeri 1 Cibinong" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" placeholder="Contoh: 2024" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="alamat_sekolah" class="form-label">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" id="alamat_sekolah" class="form-control" rows="3" placeholder="Contoh: Jl. Raya Bogor KM 46, Cibinong, Bogor" required></textarea>
                    </div>
                </div>
                <br>
                <h4>Riwayat Penyakit</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                        <input type="text" name="riwayat_penyakit" id="riwayat_penyakit" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="alergi" class="form-label">Alergi</label>
                        <input type="text" name="alergi" id="alergi" class="form-control">
                    </div>
                </div>
                <br>
                <h4>Prestasi dan Pengalaman</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="prestasi_akademik" class="form-label">Prestasi Akademik</label>
                        <textarea name="prestasi_akademik" id="prestasi_akademik" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="prestasi_non_akademik" class="form-label">Prestasi Non-Akademik</label>
                        <textarea name="prestasi_non_akademik" id="prestasi_non_akademik" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pengalaman_ekskul" class="form-label">Pengalaman Ekskul</label>
                        <textarea name="pengalaman_ekskul" id="pengalaman_ekskul" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="kepribadian" class="form-label">Kepribadian</label>
                        <textarea name="kepribadian" id="kepribadian" class="form-control" rows="3"></textarea>
                    </div>
                </div>
              
                        <button type="submit" class="btn btn-primary" title="Kirim Data">
                            Kirim
                        </button>
                        <button type="reset" class="btn btn-danger" title="Kosongkan Form">
                            Batal
                        </button>
                </div>
                    </form>
                </div>
            </div>
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
  function togglePekerjaanInput() {
    ['ayah', 'ibu'].forEach(function (parent) {
        var selected = document.querySelector('input[name="pekerjaan_' + parent + '"]:checked');
        var input = document.getElementById('pekerjaan_' + parent + '_lainnya');
        var showOther = selected && selected.value === 'Lainnya';

        input.style.display = showOther ? 'block' : 'none';
        input.required = Boolean(showOther);
        if (!showOther) {
            input.value = '';
        }
    });
  }
</script>

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
        const form = document.getElementById('biodata-form');
        const summary = document.getElementById('client-validation-errors');
        const summaryList = summary.querySelector('ul');
        const fileInput = document.getElementById('fotorumah_url');
        const fileWarning = document.getElementById('fileWarning');
        const oldValues = @json(old());

        Object.keys(oldValues).forEach(function (name) {
            const fields = form.querySelectorAll('[name="' + CSS.escape(name) + '"]');
            fields.forEach(function (field) {
                if (field.type === 'file') {
                    return;
                }
                if (field.type === 'radio') {
                    field.checked = field.value === String(oldValues[name]);
                } else {
                    field.value = oldValues[name] ?? '';
                }
            });
        });
        togglePekerjaanInput();
        const todayDate = new Date();
        todayDate.setMinutes(todayDate.getMinutes() - todayDate.getTimezoneOffset());
        const today = todayDate.toISOString().slice(0, 10);
        form.querySelectorAll('input[type="date"]').forEach(function (field) {
            field.max = today;
        });

        function updateFileValidation() {
            const file = fileInput.files[0];
            const tooLarge = file && file.size > 2 * 1024 * 1024;
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            const extension = file ? file.name.split('.').pop().toLowerCase() : '';
            const invalidType = file && !allowedExtensions.includes(extension);
            fileInput.setCustomValidity(tooLarge
                ? 'Ukuran foto maksimal 2 MB.'
                : (invalidType ? 'Foto harus berformat JPG, PNG, atau GIF.' : ''));
            fileWarning.textContent = tooLarge
                ? 'Ukuran file tidak boleh lebih dari 2 MB!'
                : 'Format foto harus JPG, PNG, atau GIF.';
            fileWarning.classList.toggle('d-none', !tooLarge && !invalidType);
        }

        fileInput.addEventListener('change', updateFileValidation);
        updateFileValidation();

        form.addEventListener('submit', function (event) {
            togglePekerjaanInput();
            updateFileValidation();

            const invalidFields = Array.from(form.elements).filter(function (field) {
                return field.willValidate && !field.validity.valid;
            });
            const invalidGroups = new Set();
            const errors = [];

            invalidFields.forEach(function (field) {
                if (field.type === 'radio') {
                    if (invalidGroups.has(field.name)) {
                        return;
                    }
                    invalidGroups.add(field.name);
                }

                const label = field.type === 'radio'
                    ? ({
                        pekerjaan_ayah: 'Pekerjaan ayah',
                        pekerjaan_ibu: 'Pekerjaan ibu',
                        pendapatan_ortu: 'Rentang pendapatan orang tua'
                    }[field.name] || field.name)
                    : (form.querySelector('label[for="' + CSS.escape(field.id) + '"]')?.textContent.trim()
                        || field.name);
                let message = field.validationMessage;
                if (field.validity.valueMissing) {
                    message = label + ' wajib diisi.';
                } else if (field.validity.typeMismatch) {
                    message = label + ' tidak valid.';
                } else if (field.validity.patternMismatch) {
                    message = label + ' harus menggunakan format yang diminta.';
                }
                errors.push({ field: field, message: message });
            });

            if (errors.length > 0) {
                event.preventDefault();
                summaryList.replaceChildren();
                errors.forEach(function (error) {
                    const item = document.createElement('li');
                    item.textContent = error.message;
                    summaryList.appendChild(item);
                    error.field.classList.add('is-invalid');
                });
                summary.classList.remove('d-none');
                summary.focus();
                summary.scrollIntoView({ behavior: 'smooth', block: 'center' });
                errors[0].field.focus({ preventScroll: true });
                return;
            }

            summary.classList.add('d-none');
            form.querySelectorAll('.is-invalid').forEach(function (field) {
                field.classList.remove('is-invalid');
            });
        });

        form.addEventListener('input', function (event) {
            if (event.target.matches('.is-invalid') && event.target.validity.valid) {
                event.target.classList.remove('is-invalid');
            }
        });

        form.addEventListener('change', function (event) {
            if (event.target.matches('input[type="radio"]')) {
                togglePekerjaanInput();
            }
        });

        const serverErrors = document.getElementById('server-validation-errors');
        if (serverErrors) {
            serverErrors.focus();
            serverErrors.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>


</body>

</html>