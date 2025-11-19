<div align="center">

# 🛒 Toko GenZ

### Modern Electronic Store Management System

[![Version](https://img.shields.io/badge/version-1.0.0-blue?style=for-the-badge)](https://github.com)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE)

**A comprehensive point-of-sale and inventory management system designed for modern electronics retail businesses**

[Features](#-features) • [Installation](#-installation) • [Usage](#-usage) • [Documentation](#-documentation)

---

</div>

## 📖 Overview

Toko GenZ is a full-featured electronic store management system built with modern PHP and MySQL. It provides everything you need to run a successful retail business: from inventory tracking and point-of-sale to detailed financial reporting and analytics.

## ✨ Fitur Utama

### 🔐 Autentikasi
- Login dengan username & password
- Session management yang aman
- Proteksi semua halaman dengan middleware

### 📊 Dashboard
- Statistik penjualan real-time
- Grafik penjualan 7 hari terakhir
- Monitoring stok barang
- Transaksi terbaru
- Produk terlaris

### 📦 Manajemen Barang
- CRUD (Create, Read, Update, Delete) barang
- Kategori produk elektronik
- Generate kode barang otomatis
- Upload spesifikasi produk
- Manajemen harga beli & jual
- Status barang (aktif/nonaktif)

### 📊 Stok Barang
- Monitoring stok real-time
- Notifikasi stok menipis
- Tambah/kurangi stok
- Riwayat pergerakan stok
- Multi satuan (unit, pcs, box, set)

### 💰 Point of Sale (POS)
- Interface kasir yang modern & responsif
- Pencarian produk cepat
- Keranjang belanja interaktif
- Perhitungan pajak otomatis (5%)
- Multiple metode pembayaran
- Perhitungan kembalian otomatis
- Generate faktur otomatis

### 🧾 Transaksi
- Riwayat transaksi lengkap
- Filter berdasarkan periode
- Detail transaksi
- Cetak ulang faktur
- Status transaksi

### 📈 Laporan Rugi Laba
- Laporan keuangan lengkap
- Perhitungan HPP (Harga Pokok Penjualan)
- Laba kotor & laba bersih
- Margin keuntungan
- Analisis per kategori
- Top 10 produk terlaris
- Filter periode (hari, minggu, bulan, tahun, custom)
- Export/cetak laporan

### ⚙️ Pengaturan
- Manajemen profil user
- Ganti password
- Pengaturan informasi toko
- Konfigurasi pajak
- Customizable footer faktur

## 🚀 Teknologi yang Digunakan

- **Backend**: PHP 8.0+
- **Database**: MySQL 5.7+
- **Frontend**: 
  - HTML5
  - CSS3
  - JavaScript (Vanilla)
  - Bootstrap 5.3.2
  - Font Awesome 6.4.2
  - Chart.js
  - DataTables
- **Server**: XAMPP (Apache + MySQL)

## 📋 Persyaratan Sistem

- PHP >= 8.0
- MySQL >= 5.7
- Apache Web Server
- XAMPP/WAMP/LAMP
- Web Browser (Chrome, Firefox, Safari, Edge)

## 🔧 Instalasi

### 1. Clone atau Download Project

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/
# Project sudah ada di folder Pasya
```

### 2. Setup Database

1. Buka **phpMyAdmin** (http://localhost/phpmyadmin)
2. Buat database baru dengan nama `toko_genz`
3. Import file `database.sql`:
   - Klik database `toko_genz`
   - Pilih tab **Import**
   - Browse file `database.sql`
   - Klik **Go**

### 3. Konfigurasi Database

File `config.php` sudah dikonfigurasi dengan default XAMPP:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'toko_genz');
```

Jika menggunakan konfigurasi berbeda, edit file `config.php`.

### 4. Jalankan Aplikasi

1. Start XAMPP:
   - Buka XAMPP Control Panel
   - Start **Apache**
   - Start **MySQL**

2. Akses aplikasi di browser:
   ```
   http://localhost/Pasya/login.php
   ```

## 🔑 Kredensial Login

```
Username: pasyaganteng
Password: pasya17
```

## 📁 Struktur Folder

```
Pasya/
├── config.php                  # Konfigurasi database & helper functions
├── database.sql                # File SQL untuk import database
├── login.php                   # Halaman login
├── logout.php                  # Proses logout
├── header.php                  # Template header & sidebar
├── footer.php                  # Template footer & scripts
├── dashboard.php               # Dashboard utama
├── barang.php                  # Manajemen barang
├── proses_barang.php          # Proses CRUD barang
├── stok.php                    # Monitoring & update stok
├── proses_stok.php            # Proses update stok
├── get_riwayat_stok.php       # API riwayat stok
├── penjualan.php              # Point of Sale (POS)
├── proses_penjualan.php       # Proses transaksi penjualan
├── transaksi.php              # Riwayat transaksi
├── get_detail_transaksi.php   # API detail transaksi
├── cetak_faktur.php           # Cetak faktur penjualan
├── laporan.php                # Laporan rugi laba
├── pengaturan.php             # Pengaturan sistem
├── proses_pengaturan.php      # Proses update pengaturan
└── README.md                   # Dokumentasi
```

## 📊 Database Schema

### Tabel Utama:

1. **users** - Data pengguna sistem
2. **kategori** - Kategori produk
3. **barang** - Master data barang
4. **transaksi** - Header transaksi penjualan
5. **detail_transaksi** - Detail item transaksi
6. **riwayat_stok** - History pergerakan stok
7. **pengaturan_toko** - Konfigurasi toko

## 🎨 Fitur UI/UX

- ✅ Desain modern dengan gradient colors
- ✅ Fully responsive (mobile, tablet, desktop)
- ✅ Dark sidebar dengan light content
- ✅ Interactive cards dengan hover effects
- ✅ Smooth animations
- ✅ Icon-based navigation
- ✅ DataTables untuk tabel interaktif
- ✅ Modal dialogs
- ✅ Real-time calculations
- ✅ Toast notifications
- ✅ Print-friendly layouts

## 📱 Responsive Design

Aplikasi telah dioptimasi untuk berbagai ukuran layar:

- 📱 **Mobile** (< 768px)
- 📱 **Tablet** (768px - 1024px)
- 💻 **Desktop** (> 1024px)

## 🔒 Keamanan

- ✅ Password hashing dengan `password_hash()`
- ✅ Prepared statements untuk query (mencegah SQL Injection)
- ✅ Input sanitization dengan `clean_input()`
- ✅ Session-based authentication
- ✅ CSRF protection ready
- ✅ XSS protection dengan `htmlspecialchars()`

## 📈 Fitur Canggih

### 1. Perhitungan Otomatis
- Subtotal per item
- Total transaksi
- Pajak (customizable %)
- Kembalian
- HPP (Harga Pokok Penjualan)
- Laba kotor & bersih
- Margin keuntungan

### 2. Reporting
- Grafik penjualan
- Top produk
- Analisis kategori
- Filter periode flexible
- Export ke print

### 3. Inventory Management
- Auto-update stok saat penjualan
- Notifikasi stok minimum
- Riwayat lengkap
- Multiple warehouse ready

## 🎯 Cara Penggunaan

### Input Barang Baru
1. Buka menu **Data Barang**
2. Klik tombol **+ Tambah Barang**
3. Isi form (kode auto-generate)
4. Klik **Simpan**

### Proses Penjualan
1. Buka menu **Penjualan (POS)**
2. Klik produk untuk menambah ke keranjang
3. Atur quantity sesuai kebutuhan
4. Pilih metode pembayaran
5. Input uang bayar
6. Klik **Proses Transaksi**
7. Faktur otomatis tercetak

### Lihat Laporan
1. Buka menu **Laporan Rugi Laba**
2. Pilih periode (hari ini, minggu ini, bulan ini, custom)
3. Klik **Tampilkan**
4. Klik **Cetak** untuk print

## 🐛 Troubleshooting

### Database Connection Error
```
Error: Koneksi gagal
```
**Solusi**: 
- Pastikan MySQL sudah running di XAMPP
- Cek kredensial database di `config.php`
- Pastikan database `toko_genz` sudah dibuat

### Blank Page
**Solusi**:
- Enable error reporting di `php.ini`
- Cek Apache error log
- Pastikan PHP >= 8.0

### Session Issues
**Solusi**:
- Hapus cookies browser
- Restart browser
- Cek folder session PHP writable

## 📝 Data Sample

Database sudah dilengkapi dengan data sample:
- ✅ 1 User admin
- ✅ 10 Kategori elektronik
- ✅ 10 Produk sample
- ✅ Pengaturan toko default

## 🔄 Update & Maintenance

### Backup Database
```bash
# Via phpMyAdmin: Export > toko_genz > Go
# Via command line:
mysqldump -u root toko_genz > backup.sql
```

### Restore Database
```bash
mysql -u root toko_genz < backup.sql
```

## 🤝 Kontribusi

Aplikasi ini dibuat oleh developer fullstack dengan fokus pada:
- Clean code
- Best practices
- User experience
- Performance
- Security

## 📞 Support

Jika ada pertanyaan atau masalah, silakan hubungi tim developer.

## 📄 License

MIT License - Bebas digunakan untuk keperluan komersial maupun non-komersial.

## 🎉 Fitur Mendatang (Roadmap)

- [ ] Multi-user dengan role management
- [ ] Barcode scanner integration
- [ ] Export laporan ke PDF & Excel
- [ ] Email notification
- [ ] SMS gateway
- [ ] Customer management
- [ ] Loyalty program
- [ ] API REST untuk mobile app
- [ ] Multi-store/cabang
- [ ] Dashboard analytics advanced

---

## 🚀 Quick Start Guide

```bash
# 1. Start XAMPP
# 2. Import database.sql ke phpMyAdmin
# 3. Akses http://localhost/Pasya/login.php
# 4. Login dengan username: pasyaganteng, password: pasya17
# 5. Selamat menggunakan! 🎉
```

---

**Developed with ❤️ for Toko GenZ**

**Version**: 1.0.0  
**Last Updated**: November 2025  
**Framework**: PHP Native + Bootstrap 5  
**Database**: MySQL 5.7+
# dashboard-toko-kelontong
