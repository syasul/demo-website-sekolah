# 🏫 Sistem Website Sekolah & Manajemen Raport Digital (SIAS)
### Platform Terpadu Profil Sekolah, PPDB Online, Data Pokok Siswa, dan Penginputan Nilai Raport
*(Versi Siap Distribusi / Siap Produksi — Laravel 11 + Tailwind CSS)*

---

## 📌 Ringkasan Produk

Aplikasi Website Sekolah Modern dan Sistem Informasi Akademik berbasis **Laravel 11**, **Tailwind CSS**, dan **Alpine.js**. Dirancang khusus dengan standar siap pakai (*ready-to-deploy*) untuk jenjang SD, SMP/MTs, hingga SMA/MA/SMK.

Sistem memadukan fungsionalitas **Company Profile Publik**, **Pendaftaran Peserta Didik Baru (PPDB Online)** dengan pelacakan nomor registrasi, **Manajemen Data Siswa (Import/Export Excel dengan Preview Interaktif)**, **Panel Guru untuk Penilaian Berkala & Remidi**, serta **Portal Raport Siswa dengan Cetak PDF Resmi**.

---

## 🌟 Fitur Utama

### 1. Panel Administrator (Tata Usaha & Manajemen Sekolah)
- **Data Pokok Siswa:**
  - Input siswa manual satu per satu dengan generate akun login otomatis.
  - **Import Excel Massal** dengan template resmi, validasi baris, dan **fitur pratinjau (preview) sebelum commit ke database**.
  - **Export Data Siswa ke Excel** (.xlsx) per kelas untuk backup atau pelaporan dinas.
  - Reset kata sandi instan untuk siswa yang lupa password.
  - Fitur nonaktifkan siswa (*Soft Delete*) agar riwayat nilai historis tetap aman.
- **PPDB (Penerimaan Peserta Didik Baru):**
  - Monitor pendaftar masuk dengan filter status (*pending*, *diterima*, *ditolak*).
  - Verifikasi berkas, catat review panitia, dan **Fitur Konversi Otomatis**: mengubah pendaftar diterima langsung menjadi siswa aktif dan assign ke rombel kelas dalam 1 klik.
- **Manajemen Kelas (Rombel):**
  - Struktur tingkat (10, 11, 12 atau 7, 8, 9) dan rombel (A, B, C, dst.).
  - Hak akses dibatasi (*Admin hanya view & create rombel master, tidak dapat mengutak-atik nilai*).
- **Manajemen Guru & Pembagian Tugas Mengajar:**
  - Penugasan guru mata pelajaran per kelas (*Guru Mapel*).
  - Penunjukan Wali Kelas dengan sinkronisasi ke lembar raport.
- **Master Mata Pelajaran & Bobot Nilai:**
  - Penentuan KKM (Kriteria Ketuntasan Minimal) per mata pelajaran.
  - Konfigurasi bobot komponen nilai (Tugas: 20%, UH: 30%, UTS: 20%, UAS: 30%).
- **Pengaturan Identitas Sekolah (Whitelabel/Settings):**
  - Ganti Nama Sekolah, NPSN, NSM, Alamat, Kontak, Kepala Sekolah, NIP, Tahun Ajaran Aktif, dan Semester Aktif tanpa perlu mengedit baris kode.
  - Slot upload logo kustom sekolah pembeli.

### 2. Panel Guru (Pendidik & Wali Kelas)
- **Dashboard Guru:** Ringkasan jumlah kelas yang diampu dan progress penilaian.
- **Input Nilai Berkala (Tugas & Ulangan Harian):**
  - Pembuatan sesi tugas harian dinamis (Tugas 1, Tugas 2, UH 1, UH 2, dst.).
  - Pengisian nilai tabel interaktif langsung di browser.
- **Input Nilai UTS & UAS:** Penilaian semester per mata pelajaran yang diampu.
- **Sistem Remidi Otomatis:**
  - Deteksi otomatis siswa yang memperoleh nilai di bawah KKM.
  - Form input nilai remidi khusus dengan kalkulasi penyesuaian nilai akhir.
- **Rekapitulasi Nilai Akhir & Penilaian Karakter:**
  - Kalkulasi otomatis nilai akhir berbobot.
  - Penginputan nilai keterampilan, nilai sikap (*spiritual/sosial*), dan catatan perkembangan siswa.
  - Kunci nilai semester (*Lock Grades*) untuk mencegah perubahan pasca-finalisasi.

### 3. Portal Siswa & Wali Murid
- **Informasi Akademik Siswa:** Detail kelas aktif, wali kelas, dan profil kesiswaan.
- **Lembar Raport Digital:**
  - Tampilan nilai per semester dan tahun ajaran dengan indikator ketuntasan.
  - Catatan deskripsi kemajuan dari guru mata pelajaran dan wali kelas.
  - **Cetak / Unduh Raport Resmi (PDF):** Layout standar format rapor lengkap dengan kop sekolah dinamis, logo, tabel nilai, dan kolom tanda tangan kepala sekolah/wali kelas.

### 4. Website Publik & Calon Siswa
- Profil sekolah, visi misi, fasilitas, kesiswaan, dan berita terkini.
- **Formulir PPDB Online:** Pendaftaran mandiri dengan nomor registrasi unik (`PPDB-YYYY-XXXX`).
- **Pelacak Status PPDB:** Pencarian status seleksi via nomor registrasi atau WhatsApp pendaftar.
- Halaman error kustom (403 Akses Ditolak, 404 Halaman Tidak Ditemukan, 500 Server Error) dengan visual branding senada.

---

## 🔑 Akun Uji Coba (Demo Accounts)

Aplikasi telah dilengkapi seeder demo siap uji coba:

| Role | Email Login | Password | Keterangan Akses |
|---|---|---|---|
| **Admin** | `admin@sekolah.test` | `password` | Akses penuh Manajemen Sekolah, Siswa, PPDB, Settings |
| **Guru** | `guru@sekolah.test` | `password` | Akses Kelas Diampu, Input Tugas/UH, UTS, UAS, Remidi, Rekap |
| **Siswa 1** | `siswa@sekolah.test` | `password` | NIS: 1001 — Lihat Nilai Raport & Download PDF |
| **Siswa 2** | `rizky@sekolah.test` | `password` | NIS: 1002 — Akun Siswa Kelas 10 A |

---

## 💻 Kebutuhan Sistem (System Requirements)

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM** >= 9.x
- **Ekstensi PHP Wajib:** `pdo`, `sqlite3` atau `pdo_mysql`, `mbstring`, `fileinfo`, `gd` (untuk manipulasi gambar/logo), `zip` (untuk export/import Excel), `xml`.
- **Database:** SQLite (default) atau MySQL / MariaDB 8.0+.

---

## 🚀 Panduan Instalasi Cepat (Quick Start)

### 1. Clone & Masuk ke Direktori
```bash
cd demo-website-sekolah
```

### 2. Pasang Dependensi Composer & NPM
```bash
composer install
npm install
```

### 3. Konfigurasi Lingkungan (.env)
```bash
cp .env.example .env
php artisan key:generate
```

*Jika menggunakan SQLite (bawaan):*
```bash
touch database/database.sqlite
```

*Jika menggunakan MySQL, sesuaikan baris berikut di `.env`:*
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migrasi & Seeder Demo Data
```bash
php artisan migrate:fresh --seed
```

### 5. Buat Symlink Storage Publik
```bash
php artisan storage:link
```

### 6. Jalankan Server Pengembangan
Buka dua terminal terpisah:
```bash
# Terminal 1: Dev Server PHP
php artisan serve

# Terminal 2: Build Aset Tailwind & Vite
npm run dev
```
Akses aplikasi melalui browser di: `http://localhost:8000`

---

## 🧪 Pengujian Otomatis (Automated Testing)

Aplikasi telah dilengkapi **68 automated feature & unit tests** yang mencakup otentikasi peran, keamanan route, CRUD siswa, import/export Excel, PPDB, kalkulasi remidi, hingga cetak PDF raport:

```bash
php artisan test
```

Hasil verifikasi:
```text
Tests:    68 passed (185 assertions)
Duration: ~3.7s
Result:   100% Passed
```

---

## 📁 Struktur Data & Direktori Utama

```
app/
├── Exports/
│   ├── SiswaExport.php           # Logika download Excel data siswa
│   └── SiswaTemplateExport.php   # Template baku import siswa
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                # Controller Admin (Siswa, PPDB, Guru, Kelas, Setting)
│   │   ├── Guru/                 # Controller Guru (NilaiKomponen, Remidi, Rekap)
│   │   ├── Siswa/                # Controller Siswa (Raport, PDF)
│   │   └── Client/               # Controller Publik (PPDB, Berita)
│   └── Middleware/
│       └── CheckRole.php         # Gate otorisasi multi-role (admin, guru, siswa)
├── Models/
│   ├── Siswa.php                 # Profil detail siswa & relasi soft-delete
│   ├── Pendaftar.php             # Data pendaftaran PPDB
│   ├── SchoolSetting.php         # Konfigurasi identitas sekolah dinamis
│   ├── NilaiKomponen.php         # Entri nilai tugas, UH, UTS, UAS, remidi
│   └── Nilai.php                 # Rekap nilai akhir semester
resources/views/
├── admin/                        # View modul admin (siswa, kelas, ppdb, settings)
├── guru/                         # View modul guru (input tugas, UTS/UAS, remidi, rekap)
├── siswa/                        # View modul siswa & layout PDF raport
├── client/                       # View publik (beranda, profil, PPDB, status)
└── errors/                       # View halaman error terisolasi (403, 404, 500)
```

---

## 🛡️ Keamanan & Optimasi Produksi

Saat men-deploy ke server hosting/VPS produksi:
1. Pastikan `APP_DEBUG=false` di file `.env`.
2. Lakukan caching konfigurasi dan route:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
3. Kompilasi aset frontend untuk produksi:
   ```bash
   npm run build
   ```
4. Pastikan folder `storage/` dan `bootstrap/cache/` memiliki hak izin tulis (*writable*):
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

---

## 📜 Lisensi & Penggunaan

Aplikasi ini dikembangkan untuk kebutuhan internal sekolah atau distribusi komersial resmi. Penggandaan dan distribusi kembali kepada pihak ketiga harus mematuhi perjanjian lisensi perangkat lunak yang disepakati bersama.
