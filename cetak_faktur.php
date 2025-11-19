<?php
require_once 'config.php';
check_login();

$id_transaksi = clean_input($_GET['id']);

// Get transaksi
$query = "SELECT t.*, u.nama_lengkap 
          FROM transaksi t
          LEFT JOIN users u ON t.id_user = u.id_user
          WHERE t.id_transaksi = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$transaksi = $stmt->get_result()->fetch_assoc();

// Get detail
$query_detail = "SELECT * FROM detail_transaksi WHERE id_transaksi = ?";
$stmt_detail = $conn->prepare($query_detail);
$stmt_detail->bind_param("i", $id_transaksi);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();

// Get pengaturan toko
$toko = get_pengaturan_toko();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Faktur - <?php echo $transaksi['no_faktur']; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            padding: 20px;
        }

        .faktur {
            width: 80mm;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .header h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .info {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 2px 0;
        }

        .items {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items th {
            border-bottom: 1px solid #000;
            padding: 5px 0;
            text-align: left;
        }

        .items td {
            padding: 5px 0;
        }

        .total {
            margin-bottom: 10px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }

        .total table {
            width: 100%;
        }

        .total td {
            padding: 3px 0;
        }

        .footer {
            text-align: center;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="faktur">
        <!-- Header -->
        <div class="header">
            <h2><?php echo $toko['nama_toko']; ?></h2>
            <div><?php echo $toko['alamat']; ?></div>
            <div>Telp: <?php echo $toko['no_telepon']; ?></div>
            <?php if ($toko['npwp']): ?>
                <div>NPWP: <?php echo $toko['npwp']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Info -->
        <div class="info">
            <table>
                <tr>
                    <td width="100">No. Faktur</td>
                    <td>: <?php echo $transaksi['no_faktur']; ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: <?php echo date('d/m/Y H:i', strtotime($transaksi['tanggal_transaksi'])); ?></td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>: <?php echo $transaksi['nama_lengkap']; ?></td>
                </tr>
                <tr>
                    <td>Pembayaran</td>
                    <td>: <?php echo ucfirst(str_replace('_', ' ', $transaksi['metode_bayar'])); ?></td>
                </tr>
            </table>
        </div>

        <!-- Items -->
        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($detail = $result_detail->fetch_assoc()): ?>
                        <tr>
                            <td colspan="4"><?php echo $detail['nama_barang']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $detail['kode_barang']; ?></td>
                            <td class="text-center"><?php echo $detail['jumlah']; ?></td>
                            <td class="text-right"><?php echo number_format($detail['harga_jual'], 0, ',', '.'); ?></td>
                            <td class="text-right"><?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="total">
            <table>
                <tr>
                    <td width="60%">Subtotal</td>
                    <td class="text-right"><?php echo rupiah($transaksi['subtotal']); ?></td>
                </tr>
                <tr>
                    <td>Pajak (<?php echo $toko['persentase_pajak']; ?>%)</td>
                    <td class="text-right"><?php echo rupiah($transaksi['pajak']); ?></td>
                </tr>
                <tr style="font-weight: bold; font-size: 14px;">
                    <td>TOTAL</td>
                    <td class="text-right"><?php echo rupiah($transaksi['total_bayar']); ?></td>
                </tr>
                <tr>
                    <td>Bayar</td>
                    <td class="text-right"><?php echo rupiah($transaksi['uang_bayar']); ?></td>
                </tr>
                <tr>
                    <td>Kembali</td>
                    <td class="text-right"><?php echo rupiah($transaksi['uang_kembali']); ?></td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><?php echo $toko['footer_faktur']; ?></p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
            <p style="margin-top: 10px;">*** TERIMA KASIH ***</p>
        </div>
    </div>

    <div class="text-center no-print" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 14px; cursor: pointer;">
            🖨️ Cetak Faktur
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 14px; cursor: pointer; margin-left: 10px;">
            ❌ Tutup
        </button>
    </div>

    <script>
        // Auto print saat halaman dimuat
        window.onload = function() {
            // window.print();
        }
    </script>
</body>

</html>