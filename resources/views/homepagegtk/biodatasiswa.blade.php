@php
    $isKurikulum = ($role ?? null) === 'kurikulum' 
        || (!isset($role) && (session()->has('kurikulum_id') && !session()->has('walas_id') && !\Illuminate\Support\Facades\Auth::guard('walas')->check()));
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - {{ $isKurikulum ? 'Kurikulum' : 'Wali Kelas' }}</title>
  <meta name="description" content="Biodata Siswa SMKN 1 Cibinong">
  <meta name="keywords" content="biodata, siswa, e-walas">

  <!-- Favicons -->
  <link href="{{ asset('images/logokampak.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css?v=2') }}" rel="stylesheet">

  <style>
        body {
            font-family: 'Inter', 'Roboto', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Kotak pesan toast */
        .alert {
            position: fixed;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: auto;
            min-width: 320px;
            max-width: 90%;
            padding: 12px 24px;
            z-index: 9999;
            text-align: center;
            font-size: 15px;
            font-weight: 500;
            color: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            animation: slideDown 0.4s ease-out;
        }

        .alert-danger {
            background-color: #ef4444;
        }

        .alert-success {
            background-color: #10b981;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translate(-50%, 0);
            }
            to {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
        }

        /* Card Biodata Styling */
        .card-biodata {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            overflow: hidden;
            margin-bottom: 24px;
            transition: all 0.2s ease-in-out;
        }

        .card-biodata:hover {
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .card-biodata-header {
            background: linear-gradient(135deg, #0d6efd 0%, #1d4ed8 100%);
            color: #ffffff;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-header-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0d6efd;
            display: flex;
            align-items: center;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 16px;
        }

        .info-row {
            margin-bottom: 8px;
            font-size: 0.93rem;
            line-height: 1.5;
        }

        .info-row strong {
            color: #475569;
            min-width: 170px;
            display: inline-block;
        }

        .parent-info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px 20px;
            height: 100%;
        }

        .parent-info-card h6 {
            color: #0f172a;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .badge-pill-custom {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
        }
    </style>

    @include('partials.btn_back_style')
</head>

<body class="index-page">
     <!-- Pesan error -->
     @if (session('error'))
        <div class="alert alert-danger" id="alertError">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Pesan success -->
    @if (session('success'))
        <div class="alert alert-success" id="alertSuccess">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Header / Navbar -->
    <header id="header" class="header d-flex align-items-center fixed-top">
      <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ $isKurikulum ? '/kurikulumpage' : '/walaspage' }}" class="logo d-flex align-items-center me-auto me-xl-0 text-decoration-none">
          <h1 class="sitename">E - Walas</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
          @if($isKurikulum)
            <li><a href="/kurikulumpage">Beranda</a></li>
          @else
            <li><a href="/walaspage">Beranda</a></li>
            <li><a href="/siswadata">Data Siswa</a></li>
          @endif
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- User profile & Logout -->
        <div class="user-info d-flex align-items-center">
            @if($isKurikulum)
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>
                <a href="/profilekurikulum" class="text-decoration-none">
                    <span class="fw-semibold">{{ $kurikulum->nama ?? session('kurikulum_nama', 'Kurikulum') }}</span>
                </a>
                <form action="{{ route('logoutkurikulum') }}" method="POST" class="ms-3 mb-0">
                    @csrf
                    <button type="submit" class="btn-getstarted">Logout</button>
                </form>
            @else
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>
                <a href="/profilewalas" class="text-decoration-none">
                    <span class="fw-semibold">{{ $walas->nama ?? 'Walas' }}</span>
                </a>
                <form action="{{ route('logoutwalas') }}" method="POST" class="ms-3 mb-0">
                    @csrf
                    <button type="submit" class="btn-getstarted">Logout</button>
                </form>
            @endif
        </div>
      </div>
    </header>

    <main class="main" style="padding-top: 90px; min-height: 80vh;">
      <section id="hero" class="hero section py-4">
        <div class="container" data-aos="fade-up" data-aos-delay="100">

          <!-- Action bar: Back & Download PDF -->
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <div class="d-flex align-items-center flex-wrap gap-2">
              <a href="{{ $backUrl ?? ($isKurikulum ? route('kurikulum.index') : route('siswadata.index')) }}" class="btn btn-back">
                  <i class="bi bi-arrow-left me-1"></i> Kembali
              </a>
              <a href="{{ $pdfUrl ?? ($isKurikulum ? route('kurikulum.biodatasiswa', ['id' => $siswa->id, 'export' => 'pdf']) : route('homepagegtk.biodatasiswa', ['id' => $siswa->id, 'export' => 'pdf'])) }}" 
                 class="btn btn-primary" 
                 style="background-color: #0d6efd; color: white; border-color: #0d6efd; border-radius: 8px;">
                  <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
              </a>
            </div>
            <div class="company-badge py-1 px-3">
              <i class="bi bi-person-vcard me-2"></i> Biodata Siswa: <strong>{{ $siswa->nama }}</strong>
            </div>
          </div>

          <div class="text-center mb-4">
              <h2 class="fw-bold mb-1">Biodata Diri Siswa</h2>
              <p class="text-muted mb-0">Rombel: {{ $rombel->nama_kelas ?? ($siswa->rombel->nama_kelas ?? '-') }} | Status: {{ ucfirst($siswa->status ?? 'Aktif') }}</p>
          </div>

          <div>
              @if($biodatas->isEmpty())
                  <!-- Jika data kosong -->
                  <div class="card p-5 text-center border-0 shadow-sm" style="border-radius: 12px;">
                      <div class="mb-3">
                          <i class="bi bi-folder-x text-muted" style="font-size: 3rem;"></i>
                      </div>
                      <h5 class="text-muted mb-3">Biodata untuk siswa ini belum tersedia.</h5>
                      <div>
                          @if($isKurikulum)
                              <a href="{{ Route::has('kurikulum.createbiodata') ? route('kurikulum.createbiodata', $siswa->id) : url('/kurikulum/siswa/biodata/' . $siswa->id . '/create') }}" class="btn btn-primary px-4 py-2">
                                  <i class="bi bi-plus-circle me-1"></i> Buat Biodata Siswa
                              </a>
                          @else
                              <a href="{{ Route::has('homepagegtk.createbiodata') ? route('homepagegtk.createbiodata', $siswa->id) : url('/siswabiodata/' . $siswa->id . '/create') }}" class="btn btn-primary px-4 py-2">
                                  <i class="bi bi-plus-circle me-1"></i> Buat Biodata Siswa
                              </a>
                          @endif
                      </div>
                  </div>
              @else
                  <!-- Jika data ditemukan -->
                  @foreach($biodatas as $biodata)
                      <div class="card-biodata">
                          <div class="card-biodata-header">
                              <h5 class="mb-0 text-white fw-bold">
                                  <i class="bi bi-person-fill me-2"></i>{{ $biodata->nama_lengkap }}
                              </h5>
                              <div class="d-flex align-items-center gap-2">
                                  <span class="badge bg-white text-primary badge-pill-custom">
                                      NIS: {{ $biodata->nis ?: (\App\Models\DaftarPesertaDidik::where('nama_siswa', $biodata->siswas_id)->value('nis') ?? '-') }}
                                  </span>
                                  <span class="badge bg-white text-primary badge-pill-custom">
                                      NISN: {{ $biodata->nisn ?: (\App\Models\DaftarPesertaDidik::where('nama_siswa', $biodata->siswas_id)->value('nisn') ?? '-') }}
                                  </span>
                              </div>
                          </div>

                          <div class="card-body p-4">
                              <!-- Section 1: Data Pribadi Siswa -->
                              <div class="section-header-title">
                                  <i class="bi bi-person-lines-fill me-2"></i> Data Pribadi Siswa
                              </div>
                              <div class="row g-3 mb-4">
                                  <div class="col-md-6">
                                      <div class="info-row"><strong>Jenis Kelamin:</strong> {{ $biodata->jenis_kelamin }}</div>
                                      <div class="info-row"><strong>Tempat, Tgl Lahir:</strong> {{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ?? '-' }}</div>
                                      <div class="info-row"><strong>Alamat Lengkap:</strong> {{ $biodata->alamat ?? '-' }}</div>
                                      <div class="info-row"><strong>Jalur Masuk:</strong> {{ $biodata->jalur_masuk ?? '-' }}</div>
                                      <div class="info-row"><strong>Jarak Rumah:</strong> {{ $biodata->jarak_rumah ?? '-' }}</div>
                                      <div class="info-row"><strong>Transportasi Sekolah:</strong> {{ $biodata->transportasi_sekolah ?? '-' }}</div>
                                      <div class="info-row"><strong>Transportasi Rumah:</strong> {{ $biodata->transportasi_rumah ?? '-' }}</div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="info-row"><strong>Kelas:</strong> {{ $biodata->kelas ?? '-' }}</div>
                                      <div class="info-row"><strong>Kompetensi:</strong> {{ $biodata->kompetensi ?? '-' }}</div>
                                      <div class="info-row"><strong>Agama:</strong> {{ $biodata->agama ?? '-' }}</div>
                                      <div class="info-row"><strong>Kewarganegaraan:</strong> {{ $biodata->kewarganegaraan ?? '-' }}</div>
                                      <div class="info-row"><strong>Anak Ke / Jumlah Saudara:</strong> Ke-{{ $biodata->anak_ke ?? '1' }} dari {{ $biodata->jumlah_saudara ?? '1' }} bersaudara</div>
                                      <div class="info-row"><strong>No WhatsApp:</strong> {{ $biodata->no_wa ?? '-' }}</div>
                                      <div class="info-row"><strong>Email Siswa:</strong> {{ $biodata->email ?? '-' }}</div>
                                      <div class="info-row"><strong>Tahun Masuk:</strong> {{ $biodata->tahun_masuk ?? '-' }}</div>
                                  </div>
                              </div>

                              <!-- Section 2: Lokasi & Foto Rumah -->
                              <div class="row g-4 mb-4">
                                  <div class="col-md-6">
                                      <div class="section-header-title">
                                          <i class="bi bi-geo-alt-fill me-2"></i> Lokasi Alamat (Google Maps)
                                      </div>
                                      @php
                                          $mapUrl = trim((string) ($biodata->alamat_maps ?? ''));
                                          $mapEmbedUrl = \App\Support\GoogleMapsUrl::embedUrl($mapUrl);
                                          $isGoogleMapsUrl = \App\Support\GoogleMapsUrl::isGoogleMapsUrl($mapUrl);
                                      @endphp
                                      @if($mapEmbedUrl)
                                          <iframe
                                              src="{{ $mapEmbedUrl }}"
                                              width="100%"
                                              height="240"
                                              style="border:0; border-radius: 8px;"
                                              allowfullscreen=""
                                              loading="lazy"
                                              referrerpolicy="no-referrer-when-downgrade">
                                          </iframe>
                                      @elseif($isGoogleMapsUrl)
                                          <div class="p-3 bg-light rounded text-center">
                                              <p class="text-muted mb-2">Tautan peta Google Maps:</p>
                                              <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm">
                                                  <i class="bi bi-box-arrow-up-right me-1"></i> Buka di Google Maps
                                              </a>
                                          </div>
                                      @else
                                          <div class="p-3 bg-light rounded text-center text-muted">
                                              <i class="bi bi-map fs-3 d-block mb-1"></i>
                                              Lokasi peta belum diatur.
                                          </div>
                                      @endif
                                  </div>

                                  <div class="col-md-6">
                                      <div class="section-header-title">
                                          <i class="bi bi-house-door-fill me-2"></i> Foto Tampak Depan Rumah
                                      </div>
                                      @if($biodata->fotorumah_url)
                                          <div class="text-center">
                                              <img src="{{ asset('storage/'.$biodata->fotorumah_url) }}" 
                                                  class="img-fluid rounded border shadow-sm" 
                                                  style="max-width: 100%; max-height: 240px; object-fit: cover;">
                                          </div>
                                      @else
                                          <div class="p-4 bg-light rounded text-center text-muted" style="min-height: 180px; display: flex; flex-direction: column; justify-content: center;">
                                              <i class="bi bi-image fs-1 d-block mb-2"></i>
                                              <span>Foto tampak depan rumah belum diunggah.</span>
                                          </div>
                                      @endif
                                  </div>
                              </div>

                              <!-- Section 3: Data Orang Tua -->
                              <div class="section-header-title">
                                  <i class="bi bi-people-fill me-2"></i> Data Orang Tua
                              </div>
                              <div class="row g-4 mb-4">
                                  <div class="col-md-6">
                                      <div class="parent-info-card">
                                          <h6><i class="bi bi-person-badge-fill text-primary me-2"></i> Data Ayah</h6>
                                          <div class="info-row"><strong>Nama Ayah:</strong> {{ $biodata->nama_ayah ?? '-' }}</div>
                                          <div class="info-row"><strong>Pekerjaan Ayah:</strong> <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $biodata->pekerjaan_ayah ?? '-' }}</span></div>
                                          <div class="info-row"><strong>Tempat, Tgl Lahir:</strong> {{ $biodata->tempat_lahir_ayah ?? '-' }}, {{ $biodata->tanggal_lahir_ayah ?? '-' }}</div>
                                          <div class="info-row"><strong>Alamat Ayah:</strong> {{ $biodata->alamat_ayah ?? '-' }}</div>
                                          <div class="info-row"><strong>No WA Ayah:</strong> {{ $biodata->no_wa_ayah ?? '-' }}</div>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="parent-info-card">
                                          <h6><i class="bi bi-person-badge-fill text-danger me-2"></i> Data Ibu</h6>
                                          <div class="info-row"><strong>Nama Ibu:</strong> {{ $biodata->nama_ibu ?? '-' }}</div>
                                          <div class="info-row"><strong>Pekerjaan Ibu:</strong> <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $biodata->pekerjaan_ibu ?? '-' }}</span></div>
                                          <div class="info-row"><strong>Tempat, Tgl Lahir:</strong> {{ $biodata->tempat_lahir_ibu ?? '-' }}, {{ $biodata->tanggal_lahir_ibu ?? '-' }}</div>
                                          <div class="info-row"><strong>Alamat Ibu:</strong> {{ $biodata->alamat_ibu ?? '-' }}</div>
                                          <div class="info-row"><strong>No WA Ibu:</strong> {{ $biodata->no_wa_ibu ?? '-' }}</div>
                                      </div>
                                  </div>
                              </div>

                              <!-- Section 4: Pendapatan Orang Tua -->
                              <div class="section-header-title">
                                  <i class="bi bi-cash-coin me-2"></i> Pendapatan Kedua Orang Tua
                              </div>
                              <div class="p-3 bg-light rounded border mb-4">
                                  <div class="info-row mb-0">
                                      <strong>Rentang Pendapatan:</strong> 
                                      <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6">
                                          {{ $biodata->pendapatan_ortu ?? 'Belum diisi' }}
                                      </span>
                                  </div>
                              </div>

                              <!-- Section 5: Data Pelengkap -->
                              <div class="section-header-title">
                                  <i class="bi bi-journal-check me-2"></i> Data Pendidikan & Pelengkap
                              </div>
                              <div class="row g-3">
                                  <div class="col-md-6">
                                      <div class="info-row"><strong>Sekolah Asal:</strong> {{ $biodata->namasekolah_asal ?? '-' }}</div>
                                      <div class="info-row"><strong>Alamat Sekolah:</strong> {{ $biodata->alamat_sekolah ?? '-' }}</div>
                                      <div class="info-row"><strong>Tahun Kelulusan:</strong> {{ $biodata->tahun_lulus ?? '-' }}</div>
                                      <div class="info-row"><strong>Riwayat Penyakit:</strong> {{ $biodata->riwayat_penyakit ?? 'Tidak ada' }}</div>
                                      <div class="info-row"><strong>Alergi:</strong> {{ $biodata->alergi ?? 'Tidak ada' }}</div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="info-row"><strong>Prestasi Akademik:</strong> {{ $biodata->prestasi_akademik ?? '-' }}</div>
                                      <div class="info-row"><strong>Prestasi Non Akademik:</strong> {{ $biodata->prestasi_non_akademik ?? '-' }}</div>
                                      <div class="info-row"><strong>Pengalaman Ekskul:</strong> {{ $biodata->pengalaman_eskul ?? ($biodata->pengalaman_ekskul ?? '-') }}</div>
                                      <div class="info-row"><strong>Kepribadian:</strong> {{ $biodata->kepribadian ?? '-' }}</div>
                                  </div>
                              </div>
                          </div>

                          <div class="card-footer bg-light py-3 px-4 d-flex justify-content-end align-items-center">
                              <a href="{{ $editUrl ?? ($isKurikulum ? route('kurikulum.editbiodata', $biodata->id) : route('homepagegtk.editbiodata', $biodata->id)) }}" class="btn btn-primary px-3">
                                  <i class="bi bi-pencil-square me-1"></i> Edit Biodata
                              </a>
                          </div>
                      </div>
                  @endforeach
              @endif
          </div>
        </div>
      </section>
    </main>

    <footer id="footer" class="footer border-top py-4 bg-white mt-5">
      <div class="container text-center">
        <p class="mb-0">© <span>Copyright</span> <strong class="px-1 sitename">SIJA SMKN 1 Cibinong</strong> <span>All Rights Reserved</span></p>
      </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        window.onload = function() {
            var errorAlert = document.getElementById('alertError');
            var successAlert = document.getElementById('alertSuccess');

            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.animation = 'slideUp 0.4s ease-out forwards';
                    setTimeout(function() {
                        errorAlert.style.display = 'none';
                    }, 400);
                }, 3000);
            }

            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.animation = 'slideUp 0.4s ease-out forwards';
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 400);
                }, 3000);
            }
        };
    </script>
</body>
</html>