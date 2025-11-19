<?php
$page_title = 'Riwayat Transaksi';
$breadcrumb = 'Home / Transaksi';
require_once 'header.php';

// Filter
$tanggal_dari = isset($_GET['dari']) ? $_GET['dari'] : date('Y-m-01');
$tanggal_sampai = isset($_GET['sampai']) ? $_GET['sampai'] : date('Y-m-d');

// Get transaksi
$query = "SELECT t.*, u.nama_lengkap 
          FROM transaksi t
          LEFT JOIN users u ON t.id_user = u.id_user
          WHERE DATE(t.tanggal_transaksi) BETWEEN ? AND ?
          ORDER BY t.tanggal_transaksi DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $tanggal_dari, $tanggal_sampai);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control" value="<?php echo $tanggal_dari; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control" value="<?php echo $tanggal_sampai; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="transaksi.php" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-receipt"></i> Daftar Transaksi
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Faktur</th>
                                <th>Tanggal</th>
                                <th>Kasir</th>
                                <th>Total Item</th>
                                <th>Subtotal</th>
                                <th>Pajak</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result->fetch_assoc()):
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><strong><?php echo $row['no_faktur']; ?></strong></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])); ?></td>
                                    <td><?php echo $row['nama_lengkap']; ?></td>
                                    <td><?php echo $row['total_item']; ?> item</td>
                                    <td><?php echo rupiah($row['subtotal']); ?></td>
                                    <td><?php echo rupiah($row['pajak']); ?></td>
                                    <td><strong><?php echo rupiah($row['total_bayar']); ?></strong></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo ucfirst(str_replace('_', ' ', $row['metode_bayar'])); ?></span>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 'selesai'): ?>
                                            <span class="badge bg-success">Selesai</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="detailTransaksi(<?php echo $row['id_transaksi']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="cetak_faktur.php?id=<?php echo $row['id_transaksi']; ?>" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-invoice"></i> Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <div class="text-center">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function detailTransaksi(id) {
        const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
        modal.show();

        fetch('get_detail_transaksi.php?id=' + id)
            .then(response => response.text())
            .then(data => {
                document.getElementById('detailContent').innerHTML = data;
            });
    }
</script>

<?php require_once 'footer.php'; ?>