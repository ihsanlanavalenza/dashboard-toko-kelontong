<?php
$page_title = 'Dashboard';
$breadcrumb = 'Home / Dashboard';
require_once 'header.php';

// Get today's date
$today = date('Y-m-d');
$this_month = date('Y-m');

// Total Barang
$query_barang = "SELECT COUNT(*) as total FROM barang WHERE status = 'aktif'";
$result_barang = $conn->query($query_barang);
$total_barang = $result_barang->fetch_assoc()['total'];

// Total Transaksi Hari Ini
$query_transaksi = "SELECT COUNT(*) as total FROM transaksi WHERE DATE(tanggal_transaksi) = '$today' AND status = 'selesai'";
$result_transaksi = $conn->query($query_transaksi);
$total_transaksi = $result_transaksi->fetch_assoc()['total'];

// Total Penjualan Hari Ini
$query_penjualan = "SELECT COALESCE(SUM(total_bayar), 0) as total FROM transaksi WHERE DATE(tanggal_transaksi) = '$today' AND status = 'selesai'";
$result_penjualan = $conn->query($query_penjualan);
$total_penjualan = $result_penjualan->fetch_assoc()['total'];

// Barang Stok Menipis
$query_stok = "SELECT COUNT(*) as total FROM barang WHERE stok <= stok_minimum AND status = 'aktif'";
$result_stok = $conn->query($query_stok);
$stok_menipis = $result_stok->fetch_assoc()['total'];

// Penjualan 7 Hari Terakhir
$query_chart = "SELECT DATE(tanggal_transaksi) as tanggal, COALESCE(SUM(total_bayar), 0) as total 
                FROM transaksi 
                WHERE tanggal_transaksi >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND status = 'selesai'
                GROUP BY DATE(tanggal_transaksi)
                ORDER BY tanggal ASC";
$result_chart = $conn->query($query_chart);
$chart_labels = [];
$chart_data = [];
while ($row = $result_chart->fetch_assoc()) {
    $chart_labels[] = date('d M', strtotime($row['tanggal']));
    $chart_data[] = $row['total'];
}

// Transaksi Terbaru
$query_recent = "SELECT t.*, u.nama_lengkap 
                 FROM transaksi t
                 LEFT JOIN users u ON t.id_user = u.id_user
                 WHERE t.status = 'selesai'
                 ORDER BY t.tanggal_transaksi DESC 
                 LIMIT 5";
$result_recent = $conn->query($query_recent);

// Barang Terlaris
$query_terlaris = "SELECT b.nama_barang, b.kode_barang, SUM(dt.jumlah) as total_terjual, b.stok
                   FROM detail_transaksi dt
                   JOIN barang b ON dt.id_barang = b.id_barang
                   JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
                   WHERE DATE(t.tanggal_transaksi) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                   AND t.status = 'selesai'
                   GROUP BY dt.id_barang
                   ORDER BY total_terjual DESC
                   LIMIT 5";
$result_terlaris = $conn->query($query_terlaris);

// Total Penjualan Bulan Ini
$query_bulan = "SELECT COALESCE(SUM(total_bayar), 0) as total FROM transaksi WHERE DATE_FORMAT(tanggal_transaksi, '%Y-%m') = '$this_month' AND status = 'selesai'";
$result_bulan = $conn->query($query_bulan);
$penjualan_bulan = $result_bulan->fetch_assoc()['total'];
?>

<div class="row">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card blue">
            <div class="stats-info">
                <h3><?php echo rupiah($total_penjualan); ?></h3>
                <p>Penjualan Hari Ini</p>
            </div>
            <div class="stats-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stats-card green">
            <div class="stats-info">
                <h3><?php echo $total_transaksi; ?></h3>
                <p>Transaksi Hari Ini</p>
            </div>
            <div class="stats-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stats-card orange">
            <div class="stats-info">
                <h3><?php echo $total_barang; ?></h3>
                <p>Total Produk Aktif</p>
            </div>
            <div class="stats-icon">
                <i class="fas fa-box"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stats-card red">
            <div class="stats-info">
                <h3><?php echo $stok_menipis; ?></h3>
                <p>Stok Menipis</p>
            </div>
            <div class="stats-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Penjualan Bulan Ini -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px;">
                <h5 style="margin: 0;"><i class="fas fa-chart-bar"></i> Total Penjualan Bulan Ini</h5>
                <h2 style="margin: 10px 0; font-size: 36px; font-weight: 700;"><?php echo rupiah($penjualan_bulan); ?></h2>
                <p style="margin: 0; opacity: 0.9;">Periode: <?php echo date('F Y'); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="row">
    <!-- Sales Chart -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Grafik Penjualan 7 Hari Terakhir
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-star"></i> Produk Terlaris (30 Hari)
            </div>
            <div class="card-body">
                <?php if ($result_terlaris->num_rows > 0): ?>
                    <div class="list-group">
                        <?php while ($row = $result_terlaris->fetch_assoc()): ?>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?php echo $row['nama_barang']; ?></h6>
                                        <small class="text-muted"><?php echo $row['kode_barang']; ?></small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary"><?php echo $row['total_terjual']; ?> terjual</span>
                                        <br><small class="text-muted">Stok: <?php echo $row['stok']; ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada data penjualan</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-receipt"></i> Transaksi Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Faktur</th>
                                <th>Tanggal</th>
                                <th>Kasir</th>
                                <th>Total Item</th>
                                <th>Total Bayar</th>
                                <th>Metode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result_recent->num_rows > 0): ?>
                                <?php while ($row = $result_recent->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?php echo $row['no_faktur']; ?></strong></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])); ?></td>
                                        <td><?php echo $row['nama_lengkap']; ?></td>
                                        <td><?php echo $row['total_item']; ?> item</td>
                                        <td><strong><?php echo rupiah($row['total_bayar']); ?></strong></td>
                                        <td>
                                            <span class="badge bg-success"><?php echo ucfirst($row['metode_bayar']); ?></span>
                                        </td>
                                        <td>
                                            <a href="cetak_faktur.php?id=<?php echo $row['id_transaksi']; ?>" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-print"></i> Cetak
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada transaksi hari ini</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: <?php echo json_encode($chart_data); ?>,
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            }
        }
    });
</script>

<?php require_once 'footer.php'; ?>