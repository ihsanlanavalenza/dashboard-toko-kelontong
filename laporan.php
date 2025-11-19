<?php
$page_title = 'Laporan Rugi Laba';
$breadcrumb = 'Home / Laporan';
require_once 'header.php';

// Filter periode
$periode = isset($_GET['periode']) ? $_GET['periode'] : 'bulan_ini';
$tanggal_dari = '';
$tanggal_sampai = '';

switch ($periode) {
    case 'hari_ini':
        $tanggal_dari = date('Y-m-d');
        $tanggal_sampai = date('Y-m-d');
        break;
    case 'minggu_ini':
        $tanggal_dari = date('Y-m-d', strtotime('monday this week'));
        $tanggal_sampai = date('Y-m-d');
        break;
    case 'bulan_ini':
        $tanggal_dari = date('Y-m-01');
        $tanggal_sampai = date('Y-m-d');
        break;
    case 'tahun_ini':
        $tanggal_dari = date('Y-01-01');
        $tanggal_sampai = date('Y-m-d');
        break;
    case 'custom':
        $tanggal_dari = isset($_GET['dari']) ? $_GET['dari'] : date('Y-m-01');
        $tanggal_sampai = isset($_GET['sampai']) ? $_GET['sampai'] : date('Y-m-d');
        break;
}

// Total Penjualan (Omzet)
$query_penjualan = "SELECT 
                    COUNT(*) as total_transaksi,
                    SUM(total_item) as total_item_terjual,
                    SUM(subtotal) as total_penjualan,
                    SUM(pajak) as total_pajak,
                    SUM(total_bayar) as total_omzet
                    FROM transaksi 
                    WHERE DATE(tanggal_transaksi) BETWEEN ? AND ? 
                    AND status = 'selesai'";
$stmt_penjualan = $conn->prepare($query_penjualan);
$stmt_penjualan->bind_param("ss", $tanggal_dari, $tanggal_sampai);
$stmt_penjualan->execute();
$data_penjualan = $stmt_penjualan->get_result()->fetch_assoc();

// Hitung HPP (Harga Pokok Penjualan)
$query_hpp = "SELECT SUM(b.harga_beli * dt.jumlah) as total_hpp
              FROM detail_transaksi dt
              JOIN barang b ON dt.id_barang = b.id_barang
              JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
              WHERE DATE(t.tanggal_transaksi) BETWEEN ? AND ?
              AND t.status = 'selesai'";
$stmt_hpp = $conn->prepare($query_hpp);
$stmt_hpp->bind_param("ss", $tanggal_dari, $tanggal_sampai);
$stmt_hpp->execute();
$data_hpp = $stmt_hpp->get_result()->fetch_assoc();
$total_hpp = $data_hpp['total_hpp'] ?? 0;

// Hitung Laba Kotor
$laba_kotor = $data_penjualan['total_penjualan'] - $total_hpp;

// Hitung Laba Bersih (setelah pajak)
$laba_bersih = $laba_kotor - $data_penjualan['total_pajak'];

// Persentase margin
$margin_persen = $data_penjualan['total_penjualan'] > 0 ? ($laba_kotor / $data_penjualan['total_penjualan']) * 100 : 0;

// Produk Terlaris
$query_terlaris = "SELECT b.nama_barang, b.kode_barang, 
                   SUM(dt.jumlah) as qty_terjual,
                   SUM(dt.subtotal) as total_penjualan,
                   SUM(b.harga_beli * dt.jumlah) as total_hpp,
                   SUM(dt.subtotal) - SUM(b.harga_beli * dt.jumlah) as laba
                   FROM detail_transaksi dt
                   JOIN barang b ON dt.id_barang = b.id_barang
                   JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
                   WHERE DATE(t.tanggal_transaksi) BETWEEN ? AND ?
                   AND t.status = 'selesai'
                   GROUP BY dt.id_barang
                   ORDER BY qty_terjual DESC
                   LIMIT 10";
$stmt_terlaris = $conn->prepare($query_terlaris);
$stmt_terlaris->bind_param("ss", $tanggal_dari, $tanggal_sampai);
$stmt_terlaris->execute();
$result_terlaris = $stmt_terlaris->get_result();

// Penjualan per Kategori
$query_kategori = "SELECT k.nama_kategori,
                   SUM(dt.jumlah) as qty,
                   SUM(dt.subtotal) as total_penjualan
                   FROM detail_transaksi dt
                   JOIN barang b ON dt.id_barang = b.id_barang
                   JOIN kategori k ON b.id_kategori = k.id_kategori
                   JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
                   WHERE DATE(t.tanggal_transaksi) BETWEEN ? AND ?
                   AND t.status = 'selesai'
                   GROUP BY k.id_kategori
                   ORDER BY total_penjualan DESC";
$stmt_kategori = $conn->prepare($query_kategori);
$stmt_kategori->bind_param("ss", $tanggal_dari, $tanggal_sampai);
$stmt_kategori->execute();
$result_kategori = $stmt_kategori->get_result();

$kategori_labels = [];
$kategori_data = [];
while ($row = $result_kategori->fetch_assoc()) {
    $kategori_labels[] = $row['nama_kategori'];
    $kategori_data[] = $row['total_penjualan'];
}
?>

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Periode</label>
                        <select name="periode" id="periode" class="form-select" onchange="toggleCustom()">
                            <option value="hari_ini" <?php echo $periode == 'hari_ini' ? 'selected' : ''; ?>>Hari Ini</option>
                            <option value="minggu_ini" <?php echo $periode == 'minggu_ini' ? 'selected' : ''; ?>>Minggu Ini</option>
                            <option value="bulan_ini" <?php echo $periode == 'bulan_ini' ? 'selected' : ''; ?>>Bulan Ini</option>
                            <option value="tahun_ini" <?php echo $periode == 'tahun_ini' ? 'selected' : ''; ?>>Tahun Ini</option>
                            <option value="custom" <?php echo $periode == 'custom' ? 'selected' : ''; ?>>Custom</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="customDari" style="<?php echo $periode == 'custom' ? '' : 'display:none;'; ?>">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control" value="<?php echo $tanggal_dari; ?>">
                    </div>
                    <div class="col-md-3" id="customSampai" style="<?php echo $periode == 'custom' ? '' : 'display:none;'; ?>">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control" value="<?php echo $tanggal_sampai; ?>">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Tampilkan
                        </button>
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="stats-card blue">
            <div class="stats-info">
                <h3><?php echo rupiah($data_penjualan['total_omzet']); ?></h3>
                <p>Total Omzet</p>
            </div>
            <div class="stats-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card green">
            <div class="stats-info">
                <h3><?php echo rupiah($laba_kotor); ?></h3>
                <p>Laba Kotor</p>
            </div>
            <div class="stats-icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card orange">
            <div class="stats-info">
                <h3><?php echo rupiah($laba_bersih); ?></h3>
                <p>Laba Bersih</p>
            </div>
            <div class="stats-icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card red">
            <div class="stats-info">
                <h3><?php echo number_format($margin_persen, 2); ?>%</h3>
                <p>Margin Keuntungan</p>
            </div>
            <div class="stats-icon">
                <i class="fas fa-percentage"></i>
            </div>
        </div>
    </div>
</div>

<!-- Detail Laporan -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-invoice-dollar"></i> Laporan Rugi Laba Detail
                <span class="float-end"><strong>Periode: <?php echo tanggal_indonesia($tanggal_dari); ?> - <?php echo tanggal_indonesia($tanggal_sampai); ?></strong></span>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td colspan="3"><strong style="font-size: 16px;">PENDAPATAN</strong></td>
                    </tr>
                    <tr>
                        <td width="50%">Penjualan</td>
                        <td width="30%"><?php echo $data_penjualan['total_transaksi']; ?> transaksi (<?php echo $data_penjualan['total_item_terjual']; ?> item)</td>
                        <td width="20%" class="text-end"><?php echo rupiah($data_penjualan['total_penjualan']); ?></td>
                    </tr>
                    <tr style="border-top: 2px solid #dee2e6;">
                        <td colspan="2"><strong>Total Pendapatan</strong></td>
                        <td class="text-end"><strong><?php echo rupiah($data_penjualan['total_penjualan']); ?></strong></td>
                    </tr>

                    <tr>
                        <td colspan="3" style="padding-top: 30px;"><strong style="font-size: 16px;">HARGA POKOK PENJUALAN (HPP)</strong></td>
                    </tr>
                    <tr>
                        <td>Harga Pokok Penjualan</td>
                        <td></td>
                        <td class="text-end"><?php echo rupiah($total_hpp); ?></td>
                    </tr>
                    <tr style="border-top: 2px solid #dee2e6;">
                        <td colspan="2"><strong>Total HPP</strong></td>
                        <td class="text-end"><strong><?php echo rupiah($total_hpp); ?></strong></td>
                    </tr>

                    <tr style="background: #e8f5e9; border-top: 2px solid #4caf50;">
                        <td colspan="2"><strong style="font-size: 16px;">LABA KOTOR</strong></td>
                        <td class="text-end"><strong style="font-size: 16px; color: #4caf50;"><?php echo rupiah($laba_kotor); ?></strong></td>
                    </tr>

                    <tr>
                        <td colspan="3" style="padding-top: 30px;"><strong style="font-size: 16px;">BEBAN & PAJAK</strong></td>
                    </tr>
                    <tr>
                        <td>Pajak Penjualan (<?php echo get_pengaturan_toko()['persentase_pajak']; ?>%)</td>
                        <td></td>
                        <td class="text-end"><?php echo rupiah($data_penjualan['total_pajak']); ?></td>
                    </tr>
                    <tr style="border-top: 2px solid #dee2e6;">
                        <td colspan="2"><strong>Total Beban & Pajak</strong></td>
                        <td class="text-end"><strong><?php echo rupiah($data_penjualan['total_pajak']); ?></strong></td>
                    </tr>

                    <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-top: 3px solid #667eea;">
                        <td colspan="2"><strong style="font-size: 18px;">LABA BERSIH</strong></td>
                        <td class="text-end"><strong style="font-size: 18px;"><?php echo rupiah($laba_bersih); ?></strong></td>
                    </tr>
                </table>

                <div class="alert alert-info mt-3">
                    <strong><i class="fas fa-info-circle"></i> Catatan:</strong><br>
                    - Margin Keuntungan: <?php echo number_format($margin_persen, 2); ?>%<br>
                    - Laba per Transaksi: <?php echo $data_penjualan['total_transaksi'] > 0 ? rupiah($laba_bersih / $data_penjualan['total_transaksi']) : 'Rp 0'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-pie"></i> Penjualan per Kategori
            </div>
            <div class="card-body">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Ringkasan
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Total Transaksi</td>
                        <td class="text-end"><strong><?php echo $data_penjualan['total_transaksi']; ?></strong></td>
                    </tr>
                    <tr>
                        <td>Total Item Terjual</td>
                        <td class="text-end"><strong><?php echo $data_penjualan['total_item_terjual']; ?></strong></td>
                    </tr>
                    <tr>
                        <td>Rata-rata Transaksi</td>
                        <td class="text-end"><strong><?php echo $data_penjualan['total_transaksi'] > 0 ? rupiah($data_penjualan['total_omzet'] / $data_penjualan['total_transaksi']) : 'Rp 0'; ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Top Products -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-trophy"></i> Top 10 Produk Terlaris
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Qty Terjual</th>
                                <th>Total Penjualan</th>
                                <th>HPP</th>
                                <th>Laba</th>
                                <th>Margin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result_terlaris->fetch_assoc()):
                                $margin = $row['total_penjualan'] > 0 ? ($row['laba'] / $row['total_penjualan']) * 100 : 0;
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['kode_barang']; ?></td>
                                    <td><?php echo $row['nama_barang']; ?></td>
                                    <td><span class="badge bg-primary"><?php echo $row['qty_terjual']; ?></span></td>
                                    <td><?php echo rupiah($row['total_penjualan']); ?></td>
                                    <td><?php echo rupiah($row['total_hpp']); ?></td>
                                    <td><strong style="color: #4caf50;"><?php echo rupiah($row['laba']); ?></strong></td>
                                    <td><?php echo number_format($margin, 2); ?>%</td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleCustom() {
        const periode = document.getElementById('periode').value;
        if (periode === 'custom') {
            document.getElementById('customDari').style.display = 'block';
            document.getElementById('customSampai').style.display = 'block';
        } else {
            document.getElementById('customDari').style.display = 'none';
            document.getElementById('customSampai').style.display = 'none';
        }
    }

    // Kategori Chart
    const ctx = document.getElementById('kategoriChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($kategori_labels); ?>,
            datasets: [{
                data: <?php echo json_encode($kategori_data); ?>,
                backgroundColor: [
                    '#667eea', '#764ba2', '#f093fb', '#4facfe',
                    '#43e97b', '#fa709a', '#30cfd0', '#a8edea',
                    '#feb692', '#ea5455'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

<style>
    @media print {

        .no-print,
        .sidebar,
        .top-navbar,
        .btn,
        .card-header .float-end {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
    }
</style>

<?php require_once 'footer.php'; ?>