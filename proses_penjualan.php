<?php
require_once 'config.php';
check_login();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proses_transaksi'])) {
    $cart = json_decode($_POST['cart'], true);
    $subtotal = clean_input($_POST['subtotal']);
    $pajak = clean_input($_POST['pajak']);
    $total_bayar = clean_input($_POST['total_bayar']);
    $uang_bayar = clean_input($_POST['uang_bayar']);
    $uang_kembali = clean_input($_POST['uang_kembali']);
    $metode_bayar = clean_input($_POST['metode_bayar']);
    $catatan = clean_input($_POST['catatan']);

    // Validasi
    if (empty($cart) || count($cart) == 0) {
        echo json_encode(['success' => false, 'message' => 'Keranjang kosong']);
        exit();
    }

    // Generate nomor faktur
    $no_faktur = generate_no_faktur();
    $tanggal_transaksi = date('Y-m-d H:i:s');
    $id_user = $_SESSION['user_id'];
    $total_item = count($cart);

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert transaksi
        $query_transaksi = "INSERT INTO transaksi (no_faktur, tanggal_transaksi, id_user, total_item, subtotal, pajak, total_bayar, uang_bayar, uang_kembali, metode_bayar, catatan, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'selesai')";
        $stmt_transaksi = $conn->prepare($query_transaksi);
        $stmt_transaksi->bind_param("ssiddddddss", $no_faktur, $tanggal_transaksi, $id_user, $total_item, $subtotal, $pajak, $total_bayar, $uang_bayar, $uang_kembali, $metode_bayar, $catatan);
        $stmt_transaksi->execute();

        $id_transaksi = $conn->insert_id;

        // Insert detail dan update stok
        foreach ($cart as $item) {
            $id_barang = $item['id_barang'];
            $kode_barang = $item['kode_barang'];
            $nama_barang = $item['nama_barang'];
            $harga_jual = $item['harga_jual'];
            $qty = $item['qty'];
            $subtotal_item = $harga_jual * $qty;

            // Cek stok
            $query_cek = "SELECT stok FROM barang WHERE id_barang = ? FOR UPDATE";
            $stmt_cek = $conn->prepare($query_cek);
            $stmt_cek->bind_param("i", $id_barang);
            $stmt_cek->execute();
            $result_cek = $stmt_cek->get_result();
            $stok_tersedia = $result_cek->fetch_assoc()['stok'];

            if ($stok_tersedia < $qty) {
                throw new Exception("Stok $nama_barang tidak mencukupi");
            }

            // Insert detail transaksi
            $query_detail = "INSERT INTO detail_transaksi (id_transaksi, id_barang, kode_barang, nama_barang, harga_jual, jumlah, subtotal) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_detail = $conn->prepare($query_detail);
            $stmt_detail->bind_param("iissdid", $id_transaksi, $id_barang, $kode_barang, $nama_barang, $harga_jual, $qty, $subtotal_item);
            $stmt_detail->execute();

            // Update stok
            $stok_baru = $stok_tersedia - $qty;
            $query_update_stok = "UPDATE barang SET stok = ? WHERE id_barang = ?";
            $stmt_update_stok = $conn->prepare($query_update_stok);
            $stmt_update_stok->bind_param("ii", $stok_baru, $id_barang);
            $stmt_update_stok->execute();

            // Catat riwayat stok
            $keterangan = "Penjualan - $no_faktur";
            $query_riwayat = "INSERT INTO riwayat_stok (id_barang, tanggal, jenis, jumlah, stok_sebelum, stok_sesudah, keterangan, id_user) 
                              VALUES (?, ?, 'keluar', ?, ?, ?, ?, ?)";
            $stmt_riwayat = $conn->prepare($query_riwayat);
            $stmt_riwayat->bind_param("isiissi", $id_barang, $tanggal_transaksi, $qty, $stok_tersedia, $stok_baru, $keterangan, $id_user);
            $stmt_riwayat->execute();
        }

        // Commit
        $conn->commit();

        echo json_encode([
            'success' => true,
            'id_transaksi' => $id_transaksi,
            'no_faktur' => $no_faktur,
            'message' => 'Transaksi berhasil'
        ]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
