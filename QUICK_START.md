# 🚀 CARA MEMULAI - TOKO GENZ

## Langkah Cepat (5 Menit)

### 1️⃣ Start XAMPP
```
Buka XAMPP Control Panel
Klik Start pada Apache
Klik Start pada MySQL
Pastikan kedua status hijau
```

### 2️⃣ Setup Database
```
1. Buka browser: http://localhost/phpmyadmin
2. Klik "New" atau "Databases"
3. Nama database: toko_genz
4. Collation: utf8mb4_unicode_ci
5. Klik "Create"
6. Pilih database toko_genz
7. Klik tab "Import"
8. Klik "Choose File"
9. Pilih file: database.sql
10. Klik "Go"
11. Tunggu proses selesai (hijau = sukses)
```

### 3️⃣ Akses Aplikasi
```
Buka browser: http://localhost/Pasya/

Login dengan:
Username: pasyaganteng
Password: pasya17
```

### 4️⃣ Selesai! 🎉
```
Anda akan masuk ke Dashboard
Semua fitur siap digunakan
```

---

## 🔍 Verifikasi Instalasi

Setelah login, cek hal berikut:

✅ **Dashboard muncul dengan statistik**
- Lihat 4 kartu statistik (penjualan, transaksi, dll)
- Ada grafik penjualan
- Ada tabel transaksi terbaru

✅ **Menu Data Barang berfungsi**
- Klik menu "Data Barang"
- Harus tampil 10 produk sample
- Tabel bisa di-search dan sort

✅ **Menu POS (Penjualan) ready**
- Klik menu "Penjualan (POS)"
- Tampil produk dalam grid
- Klik produk masuk ke keranjang
- Perhitungan otomatis jalan

✅ **Test Transaksi**
- Dari POS, tambahkan 1-2 produk
- Input uang bayar
- Klik "Proses Transaksi"
- Faktur muncul di tab baru
- Transaksi tersimpan

---

## 📱 Akses Cepat (Bookmark)

Simpan URL berikut di browser:

```
Dashboard: http://localhost/Pasya/dashboard.php
POS:       http://localhost/Pasya/penjualan.php
Laporan:   http://localhost/Pasya/laporan.php
```

---

## 🎯 Fitur yang Bisa Langsung Dicoba

### 1. Input Barang Baru
- Menu: Data Barang → Tambah Barang
- Kode auto-generate
- Isi form lengkap
- Simpan

### 2. Proses Penjualan
- Menu: Penjualan (POS)
- Klik produk
- Atur qty
- Input uang bayar
- Proses → Cetak faktur

### 3. Lihat Laporan
- Menu: Laporan Rugi Laba
- Pilih periode "Hari Ini"
- Lihat laba bersih
- Bisa di-print

### 4. Ubah Pengaturan
- Menu: Pengaturan
- Tab Pengaturan Toko
- Ubah nama, alamat, dll
- Simpan

---

## 💡 Tips Penggunaan

### Keyboard Shortcuts
- `Tab` - Navigasi form
- `Enter` - Submit form
- `Esc` - Tutup modal
- `Ctrl+F` - Search (POS)
- `Ctrl+P` - Print

### Best Practices
1. **Backup Database Rutin**
   - Export via phpMyAdmin
   - Simpan file .sql

2. **Ganti Password Default**
   - Menu Pengaturan
   - Tab Ganti Password
   - Ubah dari pasya17

3. **Update Data Toko**
   - Menu Pengaturan
   - Tab Pengaturan Toko
   - Sesuaikan info toko Anda

4. **Monitor Stok**
   - Cek menu Stok Barang
   - Perhatikan notif stok menipis
   - Update stok berkala

---

## ❓ Troubleshooting Cepat

### Login Gagal?
```
1. Pastikan database sudah diimport
2. Cek tabel users ada isinya
3. Coba clear browser cache
4. Gunakan password: pasya17 (lowercase)
```

### Halaman Blank?
```
1. Cek Apache & MySQL running
2. Cek error di console browser (F12)
3. Pastikan database toko_genz exist
4. Cek file config.php kredensial benar
```

### Error Database?
```
1. Pastikan MySQL running (hijau di XAMPP)
2. Cek database toko_genz sudah dibuat
3. Import ulang database.sql
4. Restart MySQL dari XAMPP
```

### CSS/JS Tidak Load?
```
1. Cek koneksi internet (CDN Bootstrap, dll)
2. Clear browser cache
3. Refresh dengan Ctrl+F5
4. Coba browser lain
```

---

## 📞 Butuh Bantuan?

1. Baca **README.md** untuk dokumentasi lengkap
2. Baca **INSTALLATION.md** untuk troubleshooting detail
3. Cek console browser (F12) untuk error
4. Cek log XAMPP untuk error PHP/MySQL

---

## 🎉 Selamat Mencoba!

Aplikasi Toko GenZ siap membantu mengelola:
- ✅ Inventory produk elektronik
- ✅ Penjualan harian
- ✅ Laporan keuangan
- ✅ Manajemen stok
- ✅ Dan lebih banyak lagi!

**Happy Selling! 🛒💰**

---

**Quick Command:**
```bash
# Start dari terminal (macOS/Linux)
open http://localhost/Pasya/

# Windows
start http://localhost/Pasya/
```

---

Last Updated: November 2025
