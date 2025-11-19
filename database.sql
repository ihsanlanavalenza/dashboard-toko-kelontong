-- Database: toko_genz
-- Buat database terlebih dahulu

CREATE DATABASE IF NOT EXISTS toko_genz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE toko_genz;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    no_telepon VARCHAR(20),
    role ENUM('admin', 'kasir') DEFAULT 'kasir',
    foto_profil VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Kategori Barang
CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Barang
CREATE TABLE IF NOT EXISTS barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL UNIQUE,
    nama_barang VARCHAR(200) NOT NULL,
    id_kategori INT,
    merk VARCHAR(100),
    spesifikasi TEXT,
    harga_beli DECIMAL(15,2) NOT NULL DEFAULT 0,
    harga_jual DECIMAL(15,2) NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    stok_minimum INT DEFAULT 5,
    satuan VARCHAR(20) DEFAULT 'pcs',
    gambar VARCHAR(255),
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Transaksi
CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    no_faktur VARCHAR(50) NOT NULL UNIQUE,
    tanggal_transaksi DATETIME NOT NULL,
    id_user INT NOT NULL,
    total_item INT NOT NULL DEFAULT 0,
    subtotal DECIMAL(15,2) NOT NULL DEFAULT 0,
    pajak DECIMAL(15,2) NOT NULL DEFAULT 0,
    total_bayar DECIMAL(15,2) NOT NULL DEFAULT 0,
    uang_bayar DECIMAL(15,2) NOT NULL DEFAULT 0,
    uang_kembali DECIMAL(15,2) NOT NULL DEFAULT 0,
    metode_bayar ENUM('tunai', 'transfer', 'kartu_debit', 'kartu_kredit', 'ewallet') DEFAULT 'tunai',
    catatan TEXT,
    status ENUM('selesai', 'dibatalkan') DEFAULT 'selesai',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Transaksi
CREATE TABLE IF NOT EXISTS detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT NOT NULL,
    id_barang INT NOT NULL,
    kode_barang VARCHAR(50) NOT NULL,
    nama_barang VARCHAR(200) NOT NULL,
    harga_jual DECIMAL(15,2) NOT NULL,
    jumlah INT NOT NULL,
    subtotal DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi) ON DELETE CASCADE,
    FOREIGN KEY (id_barang) REFERENCES barang(id_barang) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Riwayat Stok
CREATE TABLE IF NOT EXISTS riwayat_stok (
    id_riwayat INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    tanggal DATETIME NOT NULL,
    jenis ENUM('masuk', 'keluar', 'koreksi') NOT NULL,
    jumlah INT NOT NULL,
    stok_sebelum INT NOT NULL,
    stok_sesudah INT NOT NULL,
    keterangan TEXT,
    id_user INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_barang) REFERENCES barang(id_barang) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Pengaturan Toko
CREATE TABLE IF NOT EXISTS pengaturan_toko (
    id_pengaturan INT AUTO_INCREMENT PRIMARY KEY,
    nama_toko VARCHAR(200) NOT NULL,
    alamat TEXT,
    no_telepon VARCHAR(20),
    email VARCHAR(100),
    website VARCHAR(100),
    npwp VARCHAR(50),
    logo VARCHAR(255),
    deskripsi TEXT,
    persentase_pajak DECIMAL(5,2) DEFAULT 5.00,
    footer_faktur TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data awal user admin
INSERT INTO users (username, password, nama_lengkap, email, role) VALUES 
('pasyaganteng', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator Toko GenZ', 'admin@tokogenz.com', 'admin');
-- Password: pasya17

-- Insert data pengaturan toko default
INSERT INTO pengaturan_toko (nama_toko, alamat, no_telepon, email, persentase_pajak, footer_faktur) VALUES 
('Toko GenZ', 'Jl. Elektronik No. 123, Jakarta', '021-12345678', 'info@tokogenz.com', 5.00, 'Terima kasih atas kunjungan Anda!');

-- Insert kategori elektronik
INSERT INTO kategori (nama_kategori, deskripsi) VALUES 
('Smartphone', 'Telepon pintar berbagai merk'),
('Laptop', 'Komputer jinjing untuk berbagai kebutuhan'),
('Tablet', 'Perangkat tablet iOS dan Android'),
('Smartwatch', 'Jam tangan pintar'),
('Audio', 'Headphone, earphone, speaker'),
('Aksesoris', 'Charger, kabel, case, dll'),
('Komponen PC', 'RAM, SSD, HDD, dll'),
('Gaming', 'Console dan aksesoris gaming'),
('Smart Home', 'Perangkat rumah pintar'),
('Kamera', 'Kamera digital dan aksesoris');

-- Insert sample data barang
INSERT INTO barang (kode_barang, nama_barang, id_kategori, merk, spesifikasi, harga_beli, harga_jual, stok, satuan) VALUES 
('ELEC-001', 'iPhone 15 Pro Max 256GB', 1, 'Apple', '6.7 inch, A17 Pro Chip, 256GB Storage', 18000000, 21000000, 15, 'unit'),
('ELEC-002', 'Samsung Galaxy S24 Ultra', 1, 'Samsung', '6.8 inch, Snapdragon 8 Gen 3, 256GB', 16000000, 19000000, 20, 'unit'),
('ELEC-003', 'MacBook Air M3 13 inch', 2, 'Apple', 'M3 Chip, 8GB RAM, 256GB SSD', 15000000, 17500000, 10, 'unit'),
('ELEC-004', 'ASUS ROG Zephyrus G14', 2, 'ASUS', 'AMD Ryzen 9, RTX 4060, 16GB RAM', 18000000, 21000000, 8, 'unit'),
('ELEC-005', 'iPad Pro 11 inch M4', 3, 'Apple', 'M4 Chip, 256GB, WiFi + Cellular', 12000000, 14500000, 12, 'unit'),
('ELEC-006', 'Apple Watch Series 9', 4, 'Apple', 'GPS + Cellular, 45mm', 6000000, 7500000, 25, 'unit'),
('ELEC-007', 'Sony WH-1000XM5', 5, 'Sony', 'Wireless Noise Cancelling Headphones', 4000000, 5000000, 30, 'unit'),
('ELEC-008', 'AirPods Pro 2nd Gen', 5, 'Apple', 'Active Noise Cancellation, USB-C', 3000000, 3800000, 40, 'unit'),
('ELEC-009', 'Samsung 65 inch QLED 4K', 9, 'Samsung', 'Quantum HDR, Smart TV', 12000000, 15000000, 5, 'unit'),
('ELEC-010', 'PlayStation 5 Slim', 8, 'Sony', '1TB SSD, Digital Edition', 6000000, 7500000, 15, 'unit');

-- Create Indexes untuk performa
CREATE INDEX idx_barang_kode ON barang(kode_barang);
CREATE INDEX idx_barang_kategori ON barang(id_kategori);
CREATE INDEX idx_transaksi_tanggal ON transaksi(tanggal_transaksi);
CREATE INDEX idx_transaksi_no_faktur ON transaksi(no_faktur);
CREATE INDEX idx_detail_transaksi ON detail_transaksi(id_transaksi);
CREATE INDEX idx_riwayat_stok ON riwayat_stok(id_barang, tanggal);
