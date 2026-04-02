# Sistem Manajemen Peminjaman Alat

<p align="center">
    <strong>Aplikasi Web untuk Mengelola Peminjaman dan Pengembalian Alat/Peralatan</strong>
</p>

<p align="center">
    <a href="#fitur-utama">Fitur</a> •
    <a href="#persyaratan-sistem">Persyaratan</a> •
    <a href="#instalasi">Instalasi</a> •
    <a href="#penggunaan">Penggunaan</a> •
    <a href="#struktur-database">Database</a>
</p>

---

## 📋 Deskripsi Proyek

**Sistem Manajemen Peminjaman Alat** adalah aplikasi web yang dirancang untuk memudahkan proses manajemen peminjaman dan pengembalian peralatan/alat. Aplikasi ini menggunakan Laravel 13 sebagai framework backend dan Tailwind CSS untuk frontend yang responsif dan modern.

Sistem ini cocok digunakan oleh:
- Sekolah/Universitas untuk manajemen alat laboratorium
- Kantor/Perusahaan untuk manajemen alat kerja
- Pusat sewa alat/perangkat
- Komunitas atau koperasi yang memiliki inventaris bersama

---

## ⚡ Fitur Utama

### 1. **Manajemen Kategori Alat**
   - Membuat dan mengelola kategori alat
   - Organisasi alat berdasarkan jenis/kategori

### 2. **Manajemen Inventaris Alat**
   - Tambah, edit, dan hapus data alat
   - Pantau kondisi alat (baik, rusak, dll)
   - Tracking status ketersediaan alat

### 3. **Manajemen Peminjaman**
   - Proses peminjaman alat yang mudah
   - Atur tanggal peminjaman dan pengembalian
   - Catat kondisi alat saat peminjaman
   - Tracking status peminjaman

### 4. **Manajemen Pengembalian**
   - Edit data pengembalian alat
   - Verifikasi kondisi alat saat dikembalikan
   - Proses pengembalian yang terstruktur

### 5. **Laporan & Analisis**
   - Laporan peminjaman per alat/periode
   - Export laporan dalam format PDF
   - Cetak laporan untuk dokumentasi

### 6. **Log Aktivitas**
   - Mencatat semua aktivitas dalam sistem
   - Audit trail untuk keamanan dan transparansi
   - Tracking perubahan data

### 7. **Manajemen Pengguna**
   - Sistem autentikasi yang aman
   - Manajemen profil pengguna
   - Keamanan berbasis role

---

## 🔧 Persyaratan Sistem

Sebelum memulai, pastikan Anda memiliki:

- **PHP** ≥ 8.3
- **Composer** (PHP Package Manager)
- **Node.js** ≥ 16.0 dan **npm**
- **Database**: MySQL 8.0+ atau SQLite
- **Git** (opsional)

---

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd pengembangan-aplikasi-peminjaman-alat
```

### 2. Instalasi Otomatis (Recommended)
```bash
composer run-script setup
```

Atau lakukan instalasi manual sesuai langkah berikut:

### 3. Instalasi Manual

#### Step 1: Install PHP Dependencies
```bash
composer install
```

#### Step 2: Setup Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### Step 3: Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=peminjaman_alat
DB_USERNAME=root
DB_PASSWORD=
```

#### Step 4: Migrasi Database
```bash
php artisan migrate
```

#### Step 5: Install Node Dependencies
```bash
npm install
```

#### Step 6: Build Frontend Assets
```bash
npm run build
```

---

## 🚀 Penggunaan

### Development Mode
Jalankan server development dengan fitur hot reload:
```bash
composer run-script dev
```

Atau jalankan secara terpisah:
```bash
# Terminal 1: Artisan Server
php artisan serve

# Terminal 2: Vite Development Server
npm run dev

# Terminal 3 (Optional): Queue Listener
php artisan queue:listen

# Terminal 4 (Optional): Pail (Log Viewer)
php artisan pail
```

### Production Mode
Build frontend assets:
```bash
npm run build
```

Jalankan server:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Testing
Jalankan test suite dengan Pest:
```bash
composer run-script test
```

---

## 🏗️ Struktur Database

### Tabel-Tabel Utama

#### **users**
- `id` (Primary Key)
- `name` (Nama Pengguna)
- `email` (Email)
- `password` (Password terenkripsi)
- `created_at`, `updated_at`

#### **kategori**
- `id` (Primary Key)
- `nama_kategori` (Nama Kategori)
- `created_at`, `updated_at`

#### **alat**
- `id` (Primary Key)
- `nama_alat` (Nama Alat)
- `id_kategori` (Foreign Key ke kategori)
- `deskripsi` (Deskripsi Alat)
- `kondisi` (Kondisi: baik, rusak, diperbaiki)
- `status` (Status: tersedia, dipinjam)
- `created_at`, `updated_at`

#### **peminjaman**
- `id` (Primary Key)
- `id_alat` (Foreign Key ke alat)
- `nama_peminjam` (Nama Peminjam)
- `tgl_pinjam` (Tanggal Peminjaman)
- `tgl_kembali` (Tanggal Pengembalian Direncanakan)
- `kondisi` (Kondisi Alat Saat Dipinjam)
- `status` (Status: aktif, selesai, overdue)
- `created_at`, `updated_at`

#### **log_aktivitas**
- `id` (Primary Key)
- `user_id` (Foreign Key ke users)
- `aktivitas` (Deskripsi Aktivitas)
- `keterangan` (Detail Aktivitas)
- `created_at`, `updated_at`

---

## 🔐 Fitur Keamanan

- ✅ Autentikasi Laravel Breeze
- ✅ CSRF Protection
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ Password Hashing (Bcrypt)
- ✅ Security Headers
- ✅ Rate Limiting

---

## 📝 Catatan Penggunaan

### Kondisi Alat
- `Baik`: Alat dalam kondisi normal
- `Rusak`: Alat tidak dapat digunakan
- `Diperbaiki`: Alat sedang dalam perbaikan

### Status Alat
- `Tersedia`: Alat dapat dipinjam
- `Dipinjam`: Alat sedang dipinjam
- `Maintenance`: Alat sedang dalam pemeliharaan

### Status Peminjaman
- `Aktif`: Peminjaman sedang berlangsung
- `Selesai`: Alat telah dikembalikan
- `Overdue`: Alat belum dikembalikan melewati batas tanggal

---

## 🛠️ Stack Teknologi

- **Backend**: Laravel 13, PHP 8.3
- **Frontend**: Tailwind CSS 3, Alpine.js, Blade
- **Database**: MySQL/SQLite
- **Build Tool**: Vite
- **Testing**: Pest
- **Package Manager**: Composer, npm

---

## 📜 Lisensi

Proyek ini menggunakan lisensi **MIT**. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

## 🚦 Roadmap Fitur

- [ ] Dashboard dengan statistik real-time
- [ ] Notifikasi untuk pengembalian overdue
- [ ] Export laporan ke format Excel
- [ ] Mobile app
- [ ] Multi-user dengan role permissions
- [ ] Integrasi email notifications

---

**Terima kasih telah menggunakan Sistem Manajemen Peminjaman Alat!** 🎉
