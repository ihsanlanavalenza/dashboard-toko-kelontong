<?php
require_once 'config.php';
check_login();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo APP_NAME; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-store"></i> <?php echo APP_NAME; ?></h3>
                <small>Sistem Manajemen Toko</small>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="barang.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'barang.php' ? 'active' : ''; ?>">
                        <i class="fas fa-box"></i>
                        <span>Data Barang</span>
                    </a>
                </li>
                <li>
                    <a href="stok.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'stok.php' ? 'active' : ''; ?>">
                        <i class="fas fa-warehouse"></i>
                        <span>Stok Barang</span>
                    </a>
                </li>
                <li>
                    <a href="penjualan.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'penjualan.php' ? 'active' : ''; ?>">
                        <i class="fas fa-cash-register"></i>
                        <span>Penjualan (POS)</span>
                    </a>
                </li>
                <li>
                    <a href="transaksi.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'active' : ''; ?>">
                        <i class="fas fa-receipt"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="laporan.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Laporan Rugi Laba</span>
                    </a>
                </li>
                <li>
                    <a href="pengaturan.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'pengaturan.php' ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['nama_lengkap']); ?>&background=667eea&color=fff" alt="User">
                    <div class="user-info">
                        <h5><?php echo $_SESSION['nama_lengkap']; ?></h5>
                        <small><?php echo ucfirst($_SESSION['role']); ?></small>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="navbar-left">
                    <h4><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h4>
                    <div class="breadcrumb">
                        <i class="fas fa-home"></i>
                        <?php echo isset($breadcrumb) ? $breadcrumb : 'Home'; ?>
                    </div>
                </div>
                <div class="navbar-right">
                    <span style="color: #666; font-size: 13px;">
                        <i class="far fa-clock"></i> <?php echo date('d M Y, H:i'); ?>
                    </span>
                    <a href="logout.php" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </nav>

            <!-- Content Area -->
            <div class="content-area">