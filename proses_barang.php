<?php
require_once 'config.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tambah Barang
    if (isset($_POST['tambah'])) {
        $kode_barang = clean_input($_POST['kode_barang']);
        $nama_barang = clean_input($_POST['nama_barang']);
        $id_kategori = clean_input($_POST['id_kategori']);
        $merk = clean_input($_POST['merk']);
        $spesifikasi = clean_input($_POST['spesifikasi']);
        $harga_beli = clean_input($_POST['harga_beli']);
        $harga_jual = clean_input($_POST['harga_jual']);
        $stok = clean_input($_POST['stok']);
        $stok_minimum = clean_input($_POST['stok_minimum']);
        $satuan = clean_input($_POST['satuan']);

        $query = "INSERT INTO barang (kode_barang, nama_barang, id_kategori, merk, spesifikasi, harga_beli, harga_jual, stok, stok_minimum, satuan) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssissddiss", $kode_barang, $nama_barang, $id_kategori, $merk, $spesifikasi, $harga_beli, $harga_jual, $stok, $stok_minimum, $satuan);

        if ($stmt->execute()) {
            $id_barang = $stmt->insert_id;

            // Catat riwayat stok
            $query_riwayat = "INSERT INTO riwayat_stok (id_barang, tanggal, jenis, jumlah, stok_sebelum, stok_sesudah, keterangan, id_user) 
                              VALUES (?, NOW(), 'masuk', ?, 0, ?, 'Stok awal barang baru', ?)";
            $stmt_riwayat = $conn->prepare($query_riwayat);
            $stmt_riwayat->bind_param("iiii", $id_barang, $stok, $stok, $_SESSION['user_id']);
            $stmt_riwayat->execute();

            header("Location: barang.php?success=1");
        } else {
            header("Location: barang.php?error=1");
        }
    }

    // Edit Barang
    if (isset($_POST['edit'])) {
        $id_barang = clean_input($_POST['id_barang']);
        $kode_barang = clean_input($_POST['kode_barang']);
        $nama_barang = clean_input($_POST['nama_barang']);
        $id_kategori = clean_input($_POST['id_kategori']);
        $merk = clean_input($_POST['merk']);
        $spesifikasi = clean_input($_POST['spesifikasi']);
        $harga_beli = clean_input($_POST['harga_beli']);
        $harga_jual = clean_input($_POST['harga_jual']);
        $stok_minimum = clean_input($_POST['stok_minimum']);
        $satuan = clean_input($_POST['satuan']);

        $query = "UPDATE barang SET kode_barang = ?, nama_barang = ?, id_kategori = ?, merk = ?, spesifikasi = ?, 
                  harga_beli = ?, harga_jual = ?, stok_minimum = ?, satuan = ? 
                  WHERE id_barang = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssissddisi", $kode_barang, $nama_barang, $id_kategori, $merk, $spesifikasi, $harga_beli, $harga_jual, $stok_minimum, $satuan, $id_barang);

        if ($stmt->execute()) {
            header("Location: barang.php?success=2");
        } else {
            header("Location: barang.php?error=2");
        }
    }
}

header("Location: barang.php");
exit();
