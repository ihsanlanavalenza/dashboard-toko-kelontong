<?php
require_once 'config.php';
check_login();

$id_barang = clean_input($_GET['id']);

// Get barang info
$query_barang = "SELECT nama_barang, kode_barang FROM barang WHERE id_barang = ?";
$stmt_barang = $conn->prepare($query_barang);
$stmt_barang->bind_param("i", $id_barang);
$stmt_barang->execute();
$barang = $stmt_barang->get_result()->fetch_assoc();

// Get riwayat
$query = "SELECT r.*, u.nama_lengkap 
          FROM riwayat_stok r
          LEFT JOIN users u ON r.id_user = u.id_user
          WHERE r.id_barang = ?
          ORDER BY r.tanggal DESC
          LIMIT 50";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_barang);
$stmt->execute();
$result = $stmt->get_result();
?>

<h6><strong><?php echo $barang['nama_barang']; ?></strong> (<?php echo $barang['kode_barang']; ?>)</h6>
<hr>

<div class="table-responsive">
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Stok</th>
                <th>Keterangan</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                        <td>
                            <?php if ($row['jenis'] == 'masuk'): ?>
                                <span class="badge bg-success">Masuk</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Keluar</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo $row['jumlah']; ?></strong></td>
                        <td><?php echo $row['stok_sebelum']; ?> → <?php echo $row['stok_sesudah']; ?></td>
                        <td><?php echo $row['keterangan']; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada riwayat stok</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>