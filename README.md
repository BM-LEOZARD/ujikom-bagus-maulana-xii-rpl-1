# Sistem Manajemen Peminjaman Alat

<p align="center">
    <strong>Aplikasi Web untuk Mengelola Peminjaman dan Pengembalian Alat/Peralatan</strong>
</p>

<p align="center">
    <a href="#deskripsi-proyek">Deskripsi</a> •
    <a href="#fitur-utama">Fitur</a> •
    <a href="#persyaratan-sistem">Persyaratan</a> •
    <a href="#instalasi">Instalasi</a> •
    <a href="#penggunaan">Penggunaan</a>
</p>

---

## Deskripsi Proyek

Sistem Manajemen Peminjaman Alat adalah aplikasi web yang dikembangkan sebagai proyek Ujian Kompetensi Keahlian (Ujikom) di Sekolah Menengah Kejuruan. Aplikasi ini dirancang untuk mengelola proses peminjaman dan pengembalian peralatan/alat secara terstruktur dan efisien. 

Aplikasi ini dibangun menggunakan Laravel 13 sebagai framework backend dan Tailwind CSS untuk antarmuka frontend yang responsif dan profesional.

Aplikasi ini dapat diimplementasikan pada:
- Institusi pendidikan (sekolah, universitas) untuk manajemen alat laboratorium
- Perusahaan untuk manajemen alat kerja
- Pusat penyewaan peralatan
- Organisasi yang mengelola inventaris bersama

---

## Fitur Utama

### 1. Manajemen Kategori Alat
- Membuat dan mengelola kategori alat
- Organisasi alat berdasarkan jenis dan kategori

### 2. Manajemen Inventaris Alat
- Menambah, mengedit, dan menghapus data alat
- Memantau kondisi alat (baik, rusak)
- Melacak status ketersediaan alat

### 3. Manajemen Peminjaman
- Memproses peminjaman alat dengan struktur yang jelas
- Mengatur tanggal peminjaman dan pengembalian
- Mencatat kondisi alat saat peminjaman dilakukan
- Melacak status peminjaman (belum kembali, selesai)

### 4. Manajemen Pengembalian
- Mengelola data pengembalian alat
- Memverifikasi kondisi alat saat dikembalikan
- Memproses pengembalian dengan terstruktur

### 5. Laporan dan Analisis
- Menghasilkan laporan peminjaman per alat atau periode
- Mengekspor laporan dalam format PDF
- Mencetak laporan untuk dokumentasi

### 6. Log Aktivitas
- Mencatat semua aktivitas dalam sistem
- Menyediakan audit trail untuk keamanan dan transparansi
- Melacak perubahan data secara terperinci

### 7. Manajemen Pengguna
- Sistem otentikasi yang aman
- Pengelolaan profil pengguna

---

## Persyaratan Sistem

Sebelum melakukan instalasi, pastikan sistem Anda memenuhi persyaratan berikut:

- PHP versi 8.3 atau lebih tinggi
- Composer (PHP Package Manager)
- Node.js versi 16.0 atau lebih tinggi dan npm
- Database: MySQL 8.0 atau lebih tinggi, atau SQLite
- Git (opsional)

---

## Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/BM-LEOZARD/ujikom-bagus-maulana-xii-rpl-1.git
cd pengembangan-aplikasi-peminjaman-alat
```

### 2. Instalasi Otomatis (Direkomendasikan)
```bash
composer run-script setup
```

Atau lakukan instalasi manual dengan mengikuti langkah-langkah berikut:

### 3. Instalasi Manual

**Langkah 1: Instalasi Dependensi PHP**
```bash
composer install
```

**Langkah 2: Konfigurasi Lingkungan**
```bash
# Salin file environment
cp .env.example .env

# Hasilkan application key
php artisan key:generate
```

**Langkah 3: Konfigurasi Database**
Edit file `.env` dan sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_pinjam_alat
DB_USERNAME=root
DB_PASSWORD=
```

**Langkah 4: Migrasi Database**
```bash
php artisan migrate
```

**Langkah 5: Instalasi Dependensi Node**
```bash
npm install
```

**Langkah 6: Build Frontend Assets**
```bash
npm run build
```

---

## Penggunaan

### Mode Pengembangan
Jalankan server pengembangan dengan fitur hot reload:
```bash
composer run-script dev
```

Atau jalankan secara terpisah pada terminal yang berbeda:
```bash
# Terminal 1: Artisan Server
php artisan serve

# Terminal 2: Vite Development Server
npm run dev

# Terminal 3 (Opsional): Queue Listener
php artisan queue:listen

# Terminal 4 (Opsional): Pail (Log Viewer)
php artisan pail
```

### Mode Produksi
Build frontend assets dengan perintah:
```bash
npm run build
```

Jalankan server:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Testing
Jalankan test suite menggunakan Pest:
```bash
composer run-script test
```

---

## Struktur Database

### Tabel-Tabel Utama

#### Tabel users
- `id` (Primary Key)
- `name` (Nama Pengguna)
- `username` (Nama Akun)
- `email` (Alamat Email)
- `password` (Password Terenkripsi)
- `created_at`, `updated_at`

#### Tabel kategori
- `id` (Primary Key)
- `nama_kategori` (Nama Kategori Alat)
- `created_at`, `updated_at`

#### Tabel alat
- `id` (Primary Key)
- `nama_alat` (Nama Alat)
- `id_kategori` (Foreign Key ke Tabel kategori)
- `deskripsi` (Deskripsi Alat)
- `kondisi` (Kondisi: baik, rusak)
- `status` (Status: tersedia, dipinjam)
- `created_at`, `updated_at`

#### Tabel peminjaman
- `id` (Primary Key)
- `id_alat` (Foreign Key ke Tabel alat)
- `nama_peminjam` (Nama Peminjam)
- `tgl_pinjam` (Tanggal Peminjaman)
- `tgl_kembali` (Tanggal Pengembalian Direncanakan)
- `kondisi` (Status: baik, rusak)
- `status` (Status: belum kembali, selesai)
- `created_at`, `updated_at`

#### Tabel log_aktivitas
- `id` (Primary Key)
- `user_id` (Foreign Key ke Tabel users)
- `aksi` (Deskripsi Aktivitas)
- `Modul` (Aktivitas Antar Tabel)
- `keterangan` (Detail Aktivitas)
- `created_at`, `updated_at`

---

## Fitur Keamanan

- Otentikasi Laravel Breeze
- Proteksi CSRF (Cross-Site Request Forgery)
- Pencegahan SQL Injection (Menggunakan Eloquent ORM)
- Hashing Password (Bcrypt)
- Security Headers
- Rate Limiting

---

## Catatan Penggunaan

### Kondisi Alat
- **Baik**: Alat berada dalam kondisi normal dan dapat digunakan
- **Rusak**: Alat tidak dapat digunakan dan memerlukan perbaikan

### Status Alat
- **Tersedia**: Alat dapat dipinjam oleh pengguna
- **Dipinjam**: Alat sedang dipinjam dan tidak tersedia

### Status Peminjaman
- **Belum Kembali**: Peminjaman sedang berlangsung
- **Selesai**: Alat telah dikembalikan dengan lengkap

---

## Stack Teknologi

- **Backend**: Laravel 13, PHP 8.3
- **Frontend**: Tailwind CSS 3, Alpine.js, Blade
- **Database**: MySQL / SQLite
- **Build Tool**: Vite
- **Testing**: Pest
- **Package Manager**: Composer, npm

---

## Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

## Roadmap Fitur

- Dashboard dengan statistik real-time
- Notifikasi untuk pengembalian yang terlambat
- Export laporan ke format Excel
- Integrasi email notifications
- Peningkatan fitur keamanan dan performa
- Pengembangan aplikasi mobile

---

Dokumentasi ini disusun sebagai bagian dari Proyek Ujian Kompetensi Keahlian (Ujikom) Sekolah Menengah Kejuruan.
