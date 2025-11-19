<?php
$page_title = 'Stok Barang';
$breadcrumb = 'Home / Stok Barang';
require_once 'header.php';

// Get Barang
$query_barang = "SELECT b.*, k.nama_kategori 
                 FROM barang b
                 LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                 WHERE b.status = 'aktif'
                 ORDER BY b.nama_barang ASC";
$result_barang = $conn->query($query_barang);
?>

<div class="row">
    <!-- Summary Cards -->
    <div class="col-md-4">
        <div class="card text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="card-body">
                <h6><i class="fas fa-check-circle"></i> Stok Aman</h6>
                <?php
                $query_aman = "SELECT COUNT(*) as total FROM barang WHERE stok > stok_minimum AND status = 'aktif'";
                $result_aman = $conn->query($query_aman);
                $total_aman = $result_aman->fetch_assoc()['total'];
                ?>
                <h2><?php echo $total_aman; ?> Produk</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <h6><i class="fas fa-exclamation-triangle"></i> Stok Menipis</h6>
                <?php
                $query_menipis = "SELECT COUNT(*) as total FROM barang WHERE stok <= stok_minimum AND stok > 0 AND status = 'aktif'";
                $result_menipis = $conn->query($query_menipis);
                $total_menipis = $result_menipis->fetch_assoc()['total'];
                ?>
                <h2><?php echo $total_menipis; ?> Produk</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="card-body">
                <h6><i class="fas fa-times-circle"></i> Stok Habis</h6>
                <?php
                $query_habis = "SELECT COUNT(*) as total FROM barang WHERE stok = 0 AND status = 'aktif'";
                $result_habis = $conn->query($query_habis);
                $total_habis = $result_habis->fetch_assoc()['total'];
                ?>
                <h2><?php echo $total_habis; ?> Produk</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-warehouse"></i> Monitoring Stok Barang
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Stok Min</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result_barang->fetch_assoc()):
                                if ($row['stok'] == 0) {
                                    $status = '<span class="badge bg-danger">Habis</span>';
                                } elseif ($row['stok'] <= $row['stok_minimum']) {
                                    $status = '<span class="badge bg-warning">Menipis</span>';
                                } else {
                                    $status = '<span class="badge bg-success">Aman</span>';
                                }
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><strong><?php echo $row['kode_barang']; ?></strong></td>
                                    <td><?php echo $row['nama_barang']; ?></td>
                                    <td><?php echo $row['nama_kategori']; ?></td>
                                    <td><strong><?php echo $row['stok']; ?> <?php echo $row['satuan']; ?></strong></td>
                                    <td><?php echo $row['stok_minimum']; ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="tambahStok(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="kurangiStok(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                            <i class="fas fa-minus"></i> Kurangi
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="riwayatStok(<?php echo $row['id_barang']; ?>)">
                                            <i class="fas fa-history"></i> Riwayat
                                        </button>
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

<!-- Modal Tambah Stok -->
<div class="modal fade" id="modalTambahStok" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Tambah Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_stok.php">
                <input type="hidden" name="id_barang" id="tambah_id">
                <input type="hidden" name="jenis" value="masuk">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" id="tambah_nama" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok Saat Ini</label>
                        <input type="text" id="tambah_stok_now" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Tambah *</label>
                        <input type="number" name="jumlah" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Pembelian, retur, dsb"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update_stok" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Kurangi Stok -->
<div class="modal fade" id="modalKurangiStok" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <h5 class="modal-title"><i class="fas fa-minus"></i> Kurangi Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_stok.php">
                <input type="hidden" name="id_barang" id="kurang_id">
                <input type="hidden" name="jenis" value="keluar">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" id="kurang_nama" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok Saat Ini</label>
                        <input type="text" id="kurang_stok_now" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Kurangi *</label>
                        <input type="number" name="jumlah" id="kurang_jumlah" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Rusak, hilang, dsb"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update_stok" class="btn btn-warning">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Riwayat Stok -->
<div class="modal fade" id="modalRiwayat" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-history"></i> Riwayat Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="riwayatContent">
                <div class="text-center">
                    <div class="spinner-border" role="status"></div>
                    <p>Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function tambahStok(data) {
        document.getElementById('tambah_id').value = data.id_barang;
        document.getElementById('tambah_nama').value = data.nama_barang;
        document.getElementById('tambah_stok_now').value = data.stok + ' ' + data.satuan;

        const modal = new bootstrap.Modal(document.getElementById('modalTambahStok'));
        modal.show();
    }

    function kurangiStok(data) {
        document.getElementById('kurang_id').value = data.id_barang;
        document.getElementById('kurang_nama').value = data.nama_barang;
        document.getElementById('kurang_stok_now').value = data.stok + ' ' + data.satuan;
        document.getElementById('kurang_jumlah').max = data.stok;

        const modal = new bootstrap.Modal(document.getElementById('modalKurangiStok'));
        modal.show();
    }

    function riwayatStok(id_barang) {
        const modal = new bootstrap.Modal(document.getElementById('modalRiwayat'));
        modal.show();

        fetch('get_riwayat_stok.php?id=' + id_barang)
            .then(response => response.text())
            .then(data => {
                document.getElementById('riwayatContent').innerHTML = data;
            });
    }
</script>

<?php require_once 'footer.php'; ?>