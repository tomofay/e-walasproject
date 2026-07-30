# 📘 E-Walas

**Sistem Informasi Administrasi Wali Kelas** — Aplikasi web untuk mengelola seluruh administrasi wali kelas di SMK secara digital.

![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?logo=tailwind-css&logoColor=white)
![Database](https://img.shields.io/badge/DB-SQLite_|_MySQL-4479A1?logo=sqlite&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)

---

## 🎯 Tentang E-Walas

E-Walas adalah platform digital yang membantu wali kelas SMK mengelola tugas administrasi kelas secara terpusat. Mulai dari pendataan siswa, presensi harian, catatan kasus, home visit, hingga pembuatan berita acara dan laporan PDF — semuanya tersedia dalam satu sistem.

Selain wali kelas, sistem ini juga menyediakan dashboard untuk **Admin**, **Kepala Kompetensi (Kakom)**, **Kepala Sekolah**, **Kurikulum**, dan **Siswa** dengan hak akses yang berbeda-beda.

---

## ✨ Fitur Utama

### 🔑 Multi-Role Authentication
6 guard autentikasi terpisah: **Admin**, **Wali Kelas**, **Kakom**, **Kepala Sekolah**, **Kurikulum**, dan **Siswa**.

### 👑 Admin
- CRUD warga sekolah — Walas, Kakom, Kurikulum, Kepsek, Guru
- CRUD rombel & mata pelajaran
- Manajemen tahun ajaran
- Import data massal via Excel (siswa, walas, guru, kakom, kurikulum, kepsek, mapel, rombel)
- Export data ke Excel
- Kenaikan kelas & pengelolaan alumni
- Monitoring data administrasi seluruh walas

### 👨‍🏫 Wali Kelas (Walas)
- **Manajemen Siswa** — CRUD data siswa + biodata lengkap (validasi NIS & NISN)
- **Administrasi Kelas:**
  - Identitas Kelas
  - Struktur Organisasi Kelas
  - Jadwal KBM
  - Jadwal Piket Kelas
  - Denah Tempat Kerja Kelompok
- **Presensi** — Rekap presensi harian dengan detail per siswa, export PDF
- **Catatan Kasus Siswa** — Pencatatan dan monitoring kasus, export PDF
- **Home Visit** — Data kunjungan rumah, export PDF
- **Buku Tamu Orangtua** — Rekam kunjungan orangtua, export PDF
- **Berita Acara** — Kenaikan Kelas, Kelulusan, Serah Terima Rapor
- **Rencana Kegiatan Walas** — Perencanaan semester ganjil & genap
- **Daftar Peserta Didik** & **Rekapitulasi Jumlah Siswa**
- **Daftar Serah Terima Rapor** — Import via Excel
- **Prestasi Siswa** — Input dan rekap, export PDF
- **Laporan Statistik:**
  - Pendapatan Orangtua (export PDF)
  - Persentase Pekerjaan Orangtua
  - Grafik Jarak Tempuh Siswa (export PDF)

### 🔍 Kakom / Kepala Sekolah / Kurikulum
- View-only seluruh data administrasi wali kelas per rombel
- Cetak laporan PDF dari seluruh modul
- Monitoring data wali kelas, rombel, dan tahun ajaran

### 🎒 Siswa
- Login mandiri
- Input & edit biodata diri
- Input prestasi pribadi
- Melihat catatan kasus

---

## 🛠 Tech Stack

| Layer      | Teknologi                                           |
| ---------- | --------------------------------------------------- |
| Framework  | Laravel 11                                          |
| Bahasa     | PHP 8.2+                                            |
| Frontend   | Tailwind CSS 3, Vite 6                              |
| Database   | SQLite (dev) / MySQL (production)                   |
| PDF        | [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) |
| Excel      | [maatwebsite/excel](https://laravel-excel.com)      |
| Auth       | Multi-guard session-based (6 guard)                 |
| Templating | Blade                                               |

---

## 📋 Prasyarat

- **PHP** ≥ 8.2
- **Composer**
- **Node.js** & **npm**
- **SQLite** (default) atau **MySQL**

---

## 🚀 Instalasi

```bash
# 1. Clone repository
git clone https://github.com/cessaaisya/e-walasproject.git
cd e-walasproject

# 2. Install dependencies
composer install
npm install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Setup database (SQLite default)
#   Edit .env jika ingin menggunakan MySQL
php artisan migrate
php artisan db:seed

# 5. Build frontend & jalankan server
npm run dev
php artisan serve
```

Akses aplikasi di **http://localhost:8000**

---

## 🏗 Struktur Proyek

```
e-walasproject/
├── app/
│   ├── Models/                  # 37 model (Admin, Walas, Siswa, Rombel, dll.)
│   └── Http/
│       ├── Controllers/         # 87 controller
│       └── Middleware/          # Admin, Walas, Kakom, Siswa middleware
├── config/
│   └── auth.php                 # 6 guard authentication
├── database/
│   └── migrations/              # 39 tabel migrasi
├── routes/
│   └── web.php                  # Seluruh route aplikasi
├── resources/
│   └── views/                   # 24 modul Blade (per role + template PDF)
├── composer.json                # Dependensi PHP
└── package.json                 # Dependensi frontend
```

---

## 🔐 Kredensial Default

Semua user menggunakan password: **`12345678`**

| Role       | Nama Login                    | Halaman Login     |
| ---------- | ----------------------------- | ----------------- |
| Admin      | `Admin E-Walas`              | `/loginadmin`     |
| Walas      | `Budi Santoso, S.Pd.`        | `/logingtk`       |
| Kakom      | `Drs. Rahmat Hidayat`        | `/loginkaprog`    |
| Kepsek     | `Drs. H. Ahmad Fauzi, M.Pd.` | `/loginkepsek`    |
| Kurikulum  | `Sri Wahyuni, M.Pd.`         | `/loginkurikulum` |
| Siswa      | `Andi Pratama`               | `/loginsiswa`     |

> ⚠️ **Penting:** Ganti password default setelah instalasi. Sistem menggunakan perbandingan password plaintext — disarankan mengimplementasikan `Hash::bcrypt()` pada production.

---

## 🐳 Docker Deployment

```bash
# 1. Clone & masuk direktori
git clone https://github.com/cessaaisya/e-walasproject.git
cd e-walasproject

# 2. Generate APP_KEY (jalankan sekali)
cp .env.docker .env
docker run --rm -v "%cd%:/app" composer:2 sh -c "cd /app && php artisan key:generate"

# Atau di Linux/Mac:
# docker run --rm -v "$(pwd):/app" composer:2 sh -c "cd /app && php artisan key:generate"

# 3. Salin APP_KEY dari .env ke .env.docker (atau tetap di .env)

# 4. Build & jalankan
docker compose up -d --build

# 5. Buka http://localhost:8080
```

### Konfigurasi Docker
| Variabel          | Default          | Keterangan          |
| ----------------- | ---------------- | ------------------- |
| `APP_PORT`        | `8080`           | Port aplikasi       |
| `DB_DATABASE`     | `ewalas`         | Nama database       |
| `DB_USERNAME`     | `ewalas`         | User database       |
| `DB_PASSWORD`     | `ewalas_secret`  | Password database   |
| `DB_ROOT_PASSWORD`| `root_secret`    | Root password MySQL |

Override variabel di `.env` sebelum `docker compose up`.

### Perintah Berguna
```bash
docker compose up -d --build   # Build ulang & jalankan
docker compose down            # Hentikan container
docker compose down -v         # Hentikan + hapus volume DB
docker compose logs -f app     # Pantau log aplikasi
docker compose exec app php artisan migrate:fresh --seed  # Reset DB
```

---

## 📦 Deployment Manual (non-Docker)

```bash
cp .env.example .env
# Edit .env: APP_ENV=production, APP_DEBUG=false, DB koneksi production

composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📄 Lisensi

Proyek ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).
