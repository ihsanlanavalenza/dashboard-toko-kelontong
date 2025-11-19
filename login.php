<?php
session_start();
require_once 'config.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];

    // Query untuk cek user
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['role'] = $user['role'];

            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Username tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Login CSS -->
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <!-- Animated Background Shapes -->
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <div class="login-container">
        <!-- Left Side - Illustration -->
        <div class="login-left">
            <!-- SVG Illustration -->
            <svg class="illustration" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                <!-- Background Circle -->
                <circle cx="250" cy="250" r="200" fill="rgba(255,255,255,0.1)" />

                <!-- Store Building -->
                <rect x="150" y="180" width="200" height="180" fill="white" rx="10" />
                <rect x="150" y="180" width="200" height="40" fill="rgba(255,255,255,0.9)" rx="10" />

                <!-- Awning -->
                <path d="M 140 180 Q 250 160 360 180" fill="none" stroke="white" stroke-width="8" stroke-linecap="round" />
                <rect x="145" y="175" width="210" height="15" fill="rgba(255,255,255,0.8)" rx="5" />

                <!-- Windows -->
                <rect x="170" y="240" width="60" height="60" fill="#6366f1" rx="5" opacity="0.8" />
                <rect x="270" y="240" width="60" height="60" fill="#6366f1" rx="5" opacity="0.8" />

                <!-- Door -->
                <rect x="210" y="320" width="80" height="40" fill="#8b5cf6" rx="5" />
                <circle cx="280" cy="340" r="3" fill="white" />

                <!-- Shopping Cart Icon -->
                <g transform="translate(320, 140)">
                    <circle cx="0" cy="0" r="35" fill="white" opacity="0.9" />
                    <path d="M -15 -10 L -10 10 L 10 10 L 13 -10 Z" fill="#6366f1" />
                    <circle cx="-5" cy="15" r="3" fill="#6366f1" />
                    <circle cx="5" cy="15" r="3" fill="#6366f1" />
                </g>

                <!-- Chart Icon -->
                <g transform="translate(180, 140)">
                    <circle cx="0" cy="0" r="35" fill="white" opacity="0.9" />
                    <rect x="-12" y="5" width="6" height="10" fill="#8b5cf6" rx="1" />
                    <rect x="-3" y="-5" width="6" height="20" fill="#8b5cf6" rx="1" />
                    <rect x="6" y="-10" width="6" height="25" fill="#8b5cf6" rx="1" />
                </g>

                <!-- Decorative Elements -->
                <circle cx="100" cy="150" r="8" fill="white" opacity="0.3">
                    <animate attributeName="r" values="8;12;8" dur="3s" repeatCount="indefinite" />
                </circle>
                <circle cx="400" cy="300" r="10" fill="white" opacity="0.3">
                    <animate attributeName="r" values="10;14;10" dur="4s" repeatCount="indefinite" />
                </circle>
                <circle cx="380" cy="380" r="6" fill="white" opacity="0.3">
                    <animate attributeName="r" values="6;10;6" dur="3.5s" repeatCount="indefinite" />
                </circle>
            </svg>

            <h2><?php echo APP_NAME; ?></h2>
            <p>Sistem Manajemen Toko Elektronik Modern</p>

            <!-- Features -->
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Dashboard Analytics</h4>
                        <p>Pantau penjualan real-time</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Manajemen Inventory</h4>
                        <p>Kelola stok barang dengan mudah</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Point of Sale</h4>
                        <p>Transaksi cepat dan akurat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="login-right">
            <div class="login-header">
                <h3>Selamat Datang! 👋</h3>
                <p>Silakan login untuk melanjutkan ke dashboard</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" id="loginForm">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <div class="input-wrapper">
                        <i class="input-icon fas fa-user"></i>
                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="Masukkan username Anda" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-wrapper">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Masukkan password Anda" required>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        // Add loading animation on submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnLogin');
            btn.classList.add('loading');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        });

        // Add focus animation to inputs
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.3s';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>