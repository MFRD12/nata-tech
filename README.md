<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" width="100">
</p>

<h1 align="center">SIM Kepegawaian & Keuangan</h1>

<p align="center">
  Aplikasi web berbasis Laravel untuk mengelola data kepegawaian dan transaksi keuangan secara efisien dan terpusat.
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-red?style=flat&logo=laravel" alt="Laravel"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-8.2-blue?style=flat&logo=php" alt="PHP"></a>
  <a href="#"><img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38b2ac?style=flat&logo=tailwind-css" alt="Tailwind CSS"></a>
  <a href="#"><img src="https://img.shields.io/badge/License-MIT-green?style=flat" alt="MIT License"></a>
</p>

---

## 📘 Deskripsi

**SIM Kepegawaian & Keuangan** adalah sistem manajemen berbasis web untuk membantu mengelola data pegawai, absensi, serta transaksi keuangan dalam satu platform. Aplikasi ini dirancang dengan pendekatan modular dan fleksibel untuk berbagai kebutuhan organisasi.

---

## ✨ Fitur Utama

- Multi-role user: Super Admin, HRD, Keuangan, dan Pegawai
- Pengelolaan akun & data pegawai
- Absensi masuk & pulang
- Manajemen transaksi pemasukan & pengeluaran
- Filter laporan berdasarkan kategori, waktu, dan nominal
- Export laporan ke PDF dan Excel
- Tampilan responsif + mode gelap

---

## ⚙️ Teknologi Digunakan

- Laravel 12
- PHP 8.2
- Laravel Breeze + Tailwind CSS
- Spatie Laravel Permission (`^6.18`)
- Barryvdh Laravel DOMPDF (`^3.1`)
- Maatwebsite Laravel Excel (`^3.1`)
- Laravel Tinker

---

## 📦 Kebutuhan Sistem

- PHP ^8.2
- Composer
- Node.js & NPM
- MySQL
- Git Bash atau Terminal

---

## 🚀 Instalasi & Menjalankan Aplikasi

Untuk menjalankan proyek ini secara lokal, ikuti langkah-langkah berikut:

```bash
# 1. Clone repositori
git clone https://github.com/MFRD12/nata-tech.git
cd nata-tech

# 2. Install dependency
composer install
npm install

# 3. Salin file .env
cp .env.example .env

# 4. Konfigurasi file .env (sesuaikan dengan database lokal)
# Contoh konfigurasi:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=sim
# DB_USERNAME=root
# DB_PASSWORD=

# Optional: konfigurasi email (jika diperlukan)
# MAIL_MAILER=log
# MAIL_HOST=127.0.0.1
# MAIL_PORT=2525
# MAIL_USERNAME=null
# MAIL_PASSWORD=null
# MAIL_FROM_ADDRESS="hello@example.com"
# MAIL_FROM_NAME="${APP_NAME}"

# 5. Generate app key
php artisan key:generate

# 6. Migrasi dan seed database
php artisan migrate --seed

# 7. Kompilasi asset frontend
npm run dev

# 8. Jalankan server
php artisan serve

# 8. Jalankan server (optional)
composer run dev



