# 📦 Panduan Instalasi Toko GenZ

Panduan lengkap instalasi aplikasi Toko GenZ di XAMPP.

## 📋 Prasyarat

Sebelum memulai instalasi, pastikan Anda telah menginstall:

- ✅ **XAMPP** versi 8.0 atau lebih tinggi
- ✅ **Web Browser** modern (Chrome, Firefox, Safari, Edge)
- ✅ Koneksi internet (untuk load CDN Bootstrap, Font Awesome, dll)

## 🚀 Langkah-langkah Instalasi

### Step 1: Persiapan XAMPP

1. **Install XAMPP** jika belum terinstall
   - Download dari: https://www.apachefriends.org/
   - Install di lokasi default

2. **Start Services**
   - Buka **XAMPP Control Panel**
   - Klik **Start** pada modul **Apache**
   - Klik **Start** pada modul **MySQL**
   - Pastikan kedua services berwarna hijau (running)

### Step 2: Menyiapkan Project

Project sudah berada di lokasi yang benar:
```
/Applications/XAMPP/xamppfiles/htdocs/Pasya/
```

Jika Anda menggunakan Windows, lokasinya akan berbeda:
```
C:\xampp\htdocs\Pasya\
```

### Step 3: Setup Database

#### Cara 1: Via phpMyAdmin (Recommended)

1. **Buka phpMyAdmin**
   - Akses di browser: `http://localhost/phpmyadmin`
   
2. **Buat Database Baru**
   - Klik tab **Databases**
   - Pada kolom **Create database**, ketik: `toko_genz`
   - Pilih **Collation**: `utf8mb4_unicode_ci`
   - Klik **Create**

3. **Import File SQL**
   - Klik database **toko_genz** di sidebar kiri
   - Klik tab **Import**
   - Klik **Choose File**
   - Pilih file `database.sql` dari folder Pasya
   - Scroll ke bawah, klik **Go**
   - Tunggu hingga proses selesai
   - Anda akan melihat pesan sukses hijau

4. **Verifikasi Import**
   - Klik database **toko_genz**
   - Anda harus melihat 7 tabel:
     - ✅ users
     - ✅ kategori
     - ✅ barang
     - ✅ transaksi
     - ✅ detail_transaksi
     - ✅ riwayat_stok
     - ✅ pengaturan_toko

#### Cara 2: Via Command Line (Advanced)

```bash
# Masuk ke direktori MySQL
cd /Applications/XAMPP/xamppfiles/bin

# Login ke MySQL
./mysql -u root

# Buat database
CREATE DATABASE toko_genz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Keluar dari MySQL
exit;

# Import file SQL
./mysql -u root toko_genz < /Applications/XAMPP/xamppfiles/htdocs/Pasya/database.sql

# Verifikasi
./mysql -u root toko_genz -e "SHOW TABLES;"
```

### Step 4: Generate Password Hash (Optional)

Jika password default tidak work:

1. Akses: `http://localhost/Pasya/generate_password.php`
2. Copy hash yang dihasilkan
3. Update di database:
   - Buka phpMyAdmin
   - Klik database `toko_genz`
   - Klik tabel `users`
   - Klik **Edit** pada user `pasyaganteng`
   - Paste hash di kolom `password`
   - Klik **Go**

### Step 5: Konfigurasi Database (Jika Diperlukan)

Jika Anda menggunakan kredensial MySQL yang berbeda:

1. Buka file `config.php`
2. Edit bagian berikut sesuai konfigurasi Anda:

```php
define('DB_HOST', 'localhost');     // Host MySQL
define('DB_USER', 'root');          // Username MySQL
define('DB_PASS', '');              // Password MySQL (kosong untuk default)
define('DB_NAME', 'toko_genz');     // Nama database
```

3. Save file

### Step 6: Akses Aplikasi

1. **Buka Browser**
2. **Akses Login Page**
   ```
   http://localhost/Pasya/
   ```
   atau
   ```
   http://localhost/Pasya/login.php
   ```

3. **Login dengan Kredensial**
   ```
   Username: pasyaganteng
   Password: pasya17
   ```

4. **Selamat! Anda berhasil login! 🎉**

## ✅ Verifikasi Instalasi

Setelah login, lakukan verifikasi:

### 1. Cek Dashboard
- ✅ Statistik muncul dengan benar
- ✅ Grafik penjualan tampil
- ✅ Tidak ada error

### 2. Cek Data Barang
- Akses menu **Data Barang**
- ✅ Harus ada 10 produk sample
- ✅ DataTable berfungsi (search, pagination)

### 3. Test POS (Point of Sale)
- Akses menu **Penjualan (POS)**
- Klik salah satu produk
- ✅ Produk masuk ke keranjang
- ✅ Perhitungan otomatis bekerja

### 4. Test Transaksi
- Lanjutkan dari POS
- Input uang bayar
- Klik **Proses Transaksi**
- ✅ Transaksi berhasil
- ✅ Faktur muncul di tab baru

## 🐛 Troubleshooting

### Error: "Koneksi gagal"

**Penyebab**: MySQL tidak running atau kredensial salah

**Solusi**:
```bash
1. Cek XAMPP Control Panel
2. Pastikan MySQL berwarna hijau (running)
3. Restart MySQL jika perlu
4. Cek config.php - pastikan kredensial benar
```

### Error: "Table doesn't exist"

**Penyebab**: Database belum diimport

**Solusi**:
```bash
1. Pastikan database toko_genz sudah dibuat
2. Import ulang file database.sql
3. Refresh halaman
```

### Error: "Warning: session_start()"

**Penyebab**: Session folder tidak writable

**Solusi**:
```bash
# macOS/Linux
sudo chmod -R 777 /Applications/XAMPP/xamppfiles/tmp

# Windows (run as Administrator)
icacls "C:\xampp\tmp" /grant Users:F /t
```

### Halaman Blank/Putih

**Penyebab**: PHP error tidak ditampilkan

**Solusi**:
```php
// Tambahkan di awal config.php (untuk debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

### Login Gagal

**Penyebab**: Password hash tidak match

**Solusi**:
```bash
1. Akses http://localhost/Pasya/generate_password.php
2. Copy hash yang dihasilkan
3. Update di database tabel users
```

### CSS/JavaScript Tidak Load

**Penyebab**: CDN tidak dapat diakses

**Solusi**:
```bash
1. Cek koneksi internet
2. Atau download library manual dan simpan local
```

## 🔒 Keamanan Post-Installation

Setelah instalasi selesai, lakukan langkah keamanan:

### 1. Ganti Password Default
- Login ke aplikasi
- Akses menu **Pengaturan**
- Tab **Ganti Password**
- Ubah dari `pasya17` ke password yang kuat

### 2. Hapus File Generate Password
```bash
rm /Applications/XAMPP/xamppfiles/htdocs/Pasya/generate_password.php
```

### 3. Disable Error Display (Production)
Edit `config.php`:
```php
// Comment atau hapus baris debugging
// ini_set('display_errors', 1);
```

### 4. Set Permissions yang Benar
```bash
# macOS/Linux
chmod 644 config.php
chmod 755 /Applications/XAMPP/xamppfiles/htdocs/Pasya
```

## 📊 Data Sample

Database sudah include data sample:

### Users
- 1 Admin: `pasyaganteng`

### Kategori
- 10 kategori elektronik (Smartphone, Laptop, Tablet, dll)

### Barang
- 10 produk elektronik dengan harga dan stok

### Pengaturan Toko
- Nama: Toko GenZ
- Pajak: 5%
- Informasi kontak lengkap

## 🎯 Next Steps

Setelah instalasi berhasil:

1. ✅ **Customize Pengaturan Toko**
   - Akses menu Pengaturan > Tab Toko
   - Update nama, alamat, kontak sesuai toko Anda

2. ✅ **Input Data Barang Real**
   - Hapus atau edit data sample
   - Input produk yang benar-benar dijual

3. ✅ **Setup Kategori**
   - Sesuaikan kategori dengan jenis produk Anda

4. ✅ **Training User**
   - Latih kasir untuk menggunakan POS
   - Jelaskan alur transaksi

5. ✅ **Backup Database**
   - Buat backup rutin
   - Export via phpMyAdmin

## 🆘 Support

Jika mengalami kendala:

1. Baca dokumentasi di **README.md**
2. Cek bagian Troubleshooting di atas
3. Pastikan semua requirements terpenuhi
4. Cek Apache/MySQL error logs di XAMPP

## 📞 Lokasi Log Files

### Apache Error Log
```
# macOS
/Applications/XAMPP/xamppfiles/logs/error_log

# Windows
C:\xampp\apache\logs\error.log
```

### MySQL Error Log
```
# macOS
/Applications/XAMPP/xamppfiles/var/mysql/*.err

# Windows
C:\xampp\mysql\data\*.err
```

## ✨ Tips & Tricks

### Quick Access
Bookmark URL berikut di browser:
```
http://localhost/Pasya/dashboard.php
```

### Keyboard Shortcuts (di POS)
- `Ctrl + F`: Focus ke search produk
- `Enter`: Tambah produk yang dipilih

### Print Faktur
- Gunakan `Ctrl + P` atau tombol Print di halaman faktur
- Sesuaikan ukuran kertas di printer settings

## 🎉 Selamat!

Instalasi selesai! Aplikasi Toko GenZ siap digunakan.

Nikmati fitur-fitur modern untuk mengelola toko elektronik Anda! 🚀

---

**Happy Selling! 🛒**
