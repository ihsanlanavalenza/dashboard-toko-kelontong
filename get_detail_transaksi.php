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
?>

<div class="row">
    <div class="col-md-6">
        <table class="table table-sm table-borderless">
            <tr>
                <td width="150"><strong>No. Faktur</strong></td>
                <td>: <?php echo $transaksi['no_faktur']; ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>: <?php echo tanggal_indonesia($transaksi['tanggal_transaksi']); ?> <?php echo date('H:i', strtotime($transaksi['tanggal_transaksi'])); ?></td>
            </tr>
            <tr>
                <td><strong>Kasir</strong></td>
                <td>: <?php echo $transaksi['nama_lengkap']; ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-sm table-borderless">
            <tr>
                <td width="150"><strong>Metode Bayar</strong></td>
                <td>: <?php echo ucfirst(str_replace('_', ' ', $transaksi['metode_bayar'])); ?></td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>: <span class="badge bg-success"><?php echo ucfirst($transaksi['status']); ?></span></td>
            </tr>
            <tr>
                <td><strong>Catatan</strong></td>
                <td>: <?php echo $transaksi['catatan'] ?: '-'; ?></td>
            </tr>
        </table>
    </div>
</div>

<hr>

<h6><strong>Detail Barang</strong></h6>
<table class="table table-sm table-bordered">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th class="text-end">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($detail = $result_detail->fetch_assoc()):
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $detail['kode_barang']; ?></td>
                <td><?php echo $detail['nama_barang']; ?></td>
                <td><?php echo rupiah($detail['harga_jual']); ?></td>
                <td><?php echo $detail['jumlah']; ?></td>
                <td class="text-end"><?php echo rupiah($detail['subtotal']); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
            <td class="text-end"><strong><?php echo rupiah($transaksi['subtotal']); ?></strong></td>
        </tr>
        <tr>
            <td colspan="5" class="text-end"><strong>Pajak:</strong></td>
            <td class="text-end"><strong><?php echo rupiah($transaksi['pajak']); ?></strong></td>
        </tr>
        <tr class="table-primary">
            <td colspan="5" class="text-end"><strong>TOTAL BAYAR:</strong></td>
            <td class="text-end"><strong><?php echo rupiah($transaksi['total_bayar']); ?></strong></td>
        </tr>
        <tr>
            <td colspan="5" class="text-end">Uang Bayar:</td>
            <td class="text-end"><?php echo rupiah($transaksi['uang_bayar']); ?></td>
        </tr>
        <tr>
            <td colspan="5" class="text-end">Uang Kembali:</td>
            <td class="text-end"><?php echo rupiah($transaksi['uang_kembali']); ?></td>
        </tr>
    </tfoot>
</table>