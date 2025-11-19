<?php
$page_title = 'Pengaturan';
$breadcrumb = 'Home / Pengaturan';
require_once 'header.php';

$user_data = get_user_data($_SESSION['user_id']);
$toko = get_pengaturan_toko();

// Handle success message
$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i>
        <?php
        if ($success == 'profil') echo 'Profil berhasil diperbarui!';
        if ($success == 'password') echo 'Password berhasil diubah!';
        if ($success == 'toko') echo 'Pengaturan toko berhasil diperbarui!';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user_data['nama_lengkap']); ?>&size=150&background=667eea&color=fff"
                    class="rounded-circle mb-3" alt="Profile" style="width: 150px; height: 150px;">
                <h5><?php echo $user_data['nama_lengkap']; ?></h5>
                <p class="text-muted">@<?php echo $user_data['username']; ?></p>
                <span class="badge bg-primary"><?php echo ucfirst($user_data['role']); ?></span>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Statistik Anda
            </div>
            <div class="card-body">
                <?php
                // Transaksi hari ini oleh user
                $query_user = "SELECT COUNT(*) as total FROM transaksi WHERE id_user = ? AND DATE(tanggal_transaksi) = CURDATE()";
                $stmt_user = $conn->prepare($query_user);
                $stmt_user->bind_param("i", $_SESSION['user_id']);
                $stmt_user->execute();
                $transaksi_user = $stmt_user->get_result()->fetch_assoc()['total'];

                // Total transaksi user
                $query_total = "SELECT COUNT(*) as total FROM transaksi WHERE id_user = ?";
                $stmt_total = $conn->prepare($query_total);
                $stmt_total->bind_param("i", $_SESSION['user_id']);
                $stmt_total->execute();
                $total_transaksi = $stmt_total->get_result()->fetch_assoc()['total'];
                ?>
                <table class="table table-sm">
                    <tr>
                        <td>Transaksi Hari Ini</td>
                        <td class="text-end"><strong><?php echo $transaksi_user; ?></strong></td>
                    </tr>
                    <tr>
                        <td>Total Transaksi</td>
                        <td class="text-end"><strong><?php echo $total_transaksi; ?></strong></td>
                    </tr>
                    <tr>
                        <td>Bergabung Sejak</td>
                        <td class="text-end"><strong><?php echo date('M Y', strtotime($user_data['created_at'])); ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#profil">
                    <i class="fas fa-user"></i> Profil Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#password">
                    <i class="fas fa-lock"></i> Ganti Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#toko">
                    <i class="fas fa-store"></i> Pengaturan Toko
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Profil Tab -->
            <div class="tab-pane fade show active" id="profil">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-edit"></i> Edit Profil
                    </div>
                    <div class="card-body">
                        <form method="POST" action="proses_pengaturan.php">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username *</label>
                                    <input type="text" name="username" class="form-control"
                                        value="<?php echo $user_data['username']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap *</label>
                                    <input type="text" name="nama_lengkap" class="form-control"
                                        value="<?php echo $user_data['nama_lengkap']; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?php echo $user_data['email']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="<?php echo $user_data['no_telepon']; ?>">
                                </div>
                            </div>

                            <button type="submit" name="update_profil" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Password Tab -->
            <div class="tab-pane fade" id="password">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-key"></i> Ganti Password
                    </div>
                    <div class="card-body">
                        <form method="POST" action="proses_pengaturan.php" onsubmit="return validatePassword()">
                            <div class="mb-3">
                                <label class="form-label">Password Lama *</label>
                                <input type="password" name="password_lama" id="password_lama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru *</label>
                                <input type="password" name="password_baru" id="password_baru" class="form-control" required>
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru *</label>
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Password default adalah: <strong>pasya17</strong>
                            </div>

                            <button type="submit" name="update_password" class="btn btn-warning">
                                <i class="fas fa-key"></i> Ganti Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Toko Tab -->
            <div class="tab-pane fade" id="toko">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-store-alt"></i> Pengaturan Toko
                    </div>
                    <div class="card-body">
                        <form method="POST" action="proses_pengaturan.php">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Toko *</label>
                                    <input type="text" name="nama_toko" class="form-control"
                                        value="<?php echo $toko['nama_toko']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" name="no_telepon_toko" class="form-control"
                                        value="<?php echo $toko['no_telepon']; ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2"><?php echo $toko['alamat']; ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_toko" class="form-control"
                                        value="<?php echo $toko['email']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Website</label>
                                    <input type="text" name="website" class="form-control"
                                        value="<?php echo $toko['website']; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NPWP</label>
                                    <input type="text" name="npwp" class="form-control"
                                        value="<?php echo $toko['npwp']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Persentase Pajak (%) *</label>
                                    <input type="number" step="0.01" name="persentase_pajak" class="form-control"
                                        value="<?php echo $toko['persentase_pajak']; ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Toko</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?php echo $toko['deskripsi']; ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Footer Faktur</label>
                                <textarea name="footer_faktur" class="form-control" rows="2"><?php echo $toko['footer_faktur']; ?></textarea>
                                <small class="text-muted">Teks yang akan muncul di bagian bawah faktur</small>
                            </div>

                            <button type="submit" name="update_toko" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pengaturan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validatePassword() {
        const passwordBaru = document.getElementById('password_baru').value;
        const passwordConfirm = document.getElementById('password_confirm').value;

        if (passwordBaru.length < 6) {
            alert('Password baru minimal 6 karakter!');
            return false;
        }

        if (passwordBaru !== passwordConfirm) {
            alert('Konfirmasi password tidak cocok!');
            return false;
        }

        return true;
    }
</script>

<?php require_once 'footer.php'; ?>