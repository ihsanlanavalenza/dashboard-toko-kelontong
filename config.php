<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'toko_genz');

// Konfigurasi Aplikasi
define('APP_NAME', 'Toko GenZ');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/Pasya/');

// Konfigurasi Timezone
date_default_timezone_set('Asia/Jakarta');

// Koneksi Database
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Fungsi Helper
function clean_input($data)
{
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

function tanggal_indonesia($tanggal)
{
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

    $pecahkan = explode('-', date('Y-m-d', strtotime($tanggal)));
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function generate_kode_barang()
{
    global $conn;
    $query = "SELECT kode_barang FROM barang ORDER BY id_barang DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_code = $row['kode_barang'];
        $number = intval(substr($last_code, 5)) + 1;
    } else {
        $number = 1;
    }

    return 'ELEC-' . str_pad($number, 3, '0', STR_PAD_LEFT);
}

function generate_no_faktur()
{
    global $conn;
    $tanggal = date('Ymd');
    $query = "SELECT no_faktur FROM transaksi WHERE DATE(tanggal_transaksi) = CURDATE() ORDER BY id_transaksi DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_no = substr($row['no_faktur'], -4);
        $number = intval($last_no) + 1;
    } else {
        $number = 1;
    }

    return 'INV-' . $tanggal . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
}

function check_login()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        header("Location: " . BASE_URL . "login.php");
        exit();
    }
}

function get_user_data($user_id)
{
    global $conn;
    $query = "SELECT * FROM users WHERE id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function get_pengaturan_toko()
{
    global $conn;
    $query = "SELECT * FROM pengaturan_toko LIMIT 1";
    $result = $conn->query($query);
    return $result->fetch_assoc();
}

// Auto-load session untuk halaman yang memerlukan login
if (basename($_SERVER['PHP_SELF']) != 'login.php') {
    session_start();
}
