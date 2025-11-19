<?php
$page_title = 'Data Barang';
$breadcrumb = 'Home / Data Barang';
require_once 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = clean_input($_GET['delete']);
    $query = "UPDATE barang SET status = 'nonaktif' WHERE id_barang = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>showToast('Barang berhasil dihapus!', 'success');</script>";
    }
}

// Get Kategori
$query_kategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$result_kategori = $conn->query($query_kategori);

// Get Barang
$query_barang = "SELECT b.*, k.nama_kategori 
                 FROM barang b
                 LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                 WHERE b.status = 'aktif'
                 ORDER BY b.id_barang DESC";
$result_barang = $conn->query($query_barang);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-box"></i> Daftar Barang Elektronik</span>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fas fa-plus"></i> Tambah Barang
                </button>
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
                                <th>Merk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result_barang->fetch_assoc()):
                                $stok_class = $row['stok'] <= $row['stok_minimum'] ? 'bg-danger' : 'bg-success';
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><strong><?php echo $row['kode_barang']; ?></strong></td>
                                    <td><?php echo $row['nama_barang']; ?></td>
                                    <td><span class="badge bg-info"><?php echo $row['nama_kategori']; ?></span></td>
                                    <td><?php echo $row['merk']; ?></td>
                                    <td><?php echo rupiah($row['harga_beli']); ?></td>
                                    <td><strong><?php echo rupiah($row['harga_jual']); ?></strong></td>
                                    <td>
                                        <span class="badge <?php echo $stok_class; ?>">
                                            <?php echo $row['stok']; ?> <?php echo $row['satuan']; ?>
                                        </span>
                                    </td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editBarang(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="?delete=<?php echo $row['id_barang']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirmDelete()">
                                            <i class="fas fa-trash"></i>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_barang.php">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Barang *</label>
                            <input type="text" name="kode_barang" class="form-control" value="<?php echo generate_kode_barang(); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Barang *</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori *</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                $result_kategori->data_seek(0);
                                while ($kat = $result_kategori->fetch_assoc()):
                                ?>
                                    <option value="<?php echo $kat['id_kategori']; ?>"><?php echo $kat['nama_kategori']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Merk</label>
                            <input type="text" name="merk" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Spesifikasi</label>
                        <textarea name="spesifikasi" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Harga Beli *</label>
                            <input type="number" name="harga_beli" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Harga Jual *</label>
                            <input type="number" name="harga_jual" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Satuan</label>
                            <select name="satuan" class="form-select">
                                <option value="unit">Unit</option>
                                <option value="pcs">Pcs</option>
                                <option value="box">Box</option>
                                <option value="set">Set</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok Awal *</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok Minimum</label>
                            <input type="number" name="stok_minimum" class="form-control" value="5">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_barang.php">
                <input type="hidden" name="id_barang" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Barang *</label>
                            <input type="text" name="kode_barang" id="edit_kode" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Barang *</label>
                            <input type="text" name="nama_barang" id="edit_nama" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori *</label>
                            <select name="id_kategori" id="edit_kategori" class="form-select" required>
                                <?php
                                $result_kategori->data_seek(0);
                                while ($kat = $result_kategori->fetch_assoc()):
                                ?>
                                    <option value="<?php echo $kat['id_kategori']; ?>"><?php echo $kat['nama_kategori']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Merk</label>
                            <input type="text" name="merk" id="edit_merk" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Spesifikasi</label>
                        <textarea name="spesifikasi" id="edit_spesifikasi" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Harga Beli *</label>
                            <input type="number" name="harga_beli" id="edit_harga_beli" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Harga Jual *</label>
                            <input type="number" name="harga_jual" id="edit_harga_jual" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Satuan</label>
                            <select name="satuan" id="edit_satuan" class="form-select">
                                <option value="unit">Unit</option>
                                <option value="pcs">Pcs</option>
                                <option value="box">Box</option>
                                <option value="set">Set</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="number" name="stok" id="edit_stok" class="form-control" readonly>
                            <small class="text-muted">Untuk mengubah stok, gunakan menu Stok Barang</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok Minimum</label>
                            <input type="number" name="stok_minimum" id="edit_stok_minimum" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="edit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editBarang(data) {
        document.getElementById('edit_id').value = data.id_barang;
        document.getElementById('edit_kode').value = data.kode_barang;
        document.getElementById('edit_nama').value = data.nama_barang;
        document.getElementById('edit_kategori').value = data.id_kategori;
        document.getElementById('edit_merk').value = data.merk;
        document.getElementById('edit_spesifikasi').value = data.spesifikasi;
        document.getElementById('edit_harga_beli').value = data.harga_beli;
        document.getElementById('edit_harga_jual').value = data.harga_jual;
        document.getElementById('edit_satuan').value = data.satuan;
        document.getElementById('edit_stok').value = data.stok;
        document.getElementById('edit_stok_minimum').value = data.stok_minimum;

        const modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    }
</script>

<?php require_once 'footer.php'; ?>