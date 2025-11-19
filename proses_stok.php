<?php
require_once 'config.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_stok'])) {
    $id_barang = clean_input($_POST['id_barang']);
    $jenis = clean_input($_POST['jenis']); // masuk atau keluar
    $jumlah = clean_input($_POST['jumlah']);
    $keterangan = clean_input($_POST['keterangan']);

    // Get stok sekarang
    $query_stok = "SELECT stok FROM barang WHERE id_barang = ?";
    $stmt_stok = $conn->prepare($query_stok);
    $stmt_stok->bind_param("i", $id_barang);
    $stmt_stok->execute();
    $result_stok = $stmt_stok->get_result();
    $stok_sebelum = $result_stok->fetch_assoc()['stok'];

    // Hitung stok baru
    if ($jenis == 'masuk') {
        $stok_sesudah = $stok_sebelum + $jumlah;
    } else {
        $stok_sesudah = $stok_sebelum - $jumlah;
        if ($stok_sesudah < 0) {
            header("Location: stok.php?error=stok_kurang");
            exit();
        }
    }

    // Update stok barang
    $query_update = "UPDATE barang SET stok = ? WHERE id_barang = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("ii", $stok_sesudah, $id_barang);

    if ($stmt_update->execute()) {
        // Catat riwayat
        $query_riwayat = "INSERT INTO riwayat_stok (id_barang, tanggal, jenis, jumlah, stok_sebelum, stok_sesudah, keterangan, id_user) 
                          VALUES (?, NOW(), ?, ?, ?, ?, ?, ?)";
        $stmt_riwayat = $conn->prepare($query_riwayat);
        $stmt_riwayat->bind_param("isiissi", $id_barang, $jenis, $jumlah, $stok_sebelum, $stok_sesudah, $keterangan, $_SESSION['user_id']);
        $stmt_riwayat->execute();

        header("Location: stok.php?success=1");
    } else {
        header("Location: stok.php?error=1");
    }
}

header("Location: stok.php");
exit();
