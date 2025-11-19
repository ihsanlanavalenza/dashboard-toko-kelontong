<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko GenZ - Sistem Manajemen Toko Modern</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/landing.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <i class="fas fa-store"></i>
                    <span>Toko<strong>GenZ</strong></span>
                </div>
                <div class="nav-menu" id="navMenu">
                    <a href="#home" class="nav-link active">Home</a>
                    <a href="#features" class="nav-link">Fitur</a>
                    <a href="#benefits" class="nav-link">Keunggulan</a>
                    <a href="#pricing" class="nav-link">Harga</a>
                    <a href="#testimonials" class="nav-link">Testimoni</a>
                    <a href="login.php" class="btn-nav">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </div>
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg">
            <div class="hero-shape shape-1"></div>
            <div class="hero-shape shape-2"></div>
            <div class="hero-shape shape-3"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-left" data-aos="fade-right">
                    <span class="badge-new">🚀 Platform POS Terbaik 2025</span>
                    <h1 class="hero-title">
                        Kelola Toko Elektronik Anda dengan
                        <span class="gradient-text">Lebih Mudah & Efisien</span>
                    </h1>
                    <p class="hero-description">
                        Sistem manajemen toko modern yang membantu Anda mengatur inventory,
                        transaksi penjualan, dan laporan keuangan dalam satu platform yang powerful.
                    </p>
                    <div class="hero-buttons">
                        <a href="login.php" class="btn btn-primary">
                            <i class="fas fa-rocket"></i> Mulai Sekarang
                        </a>
                        <a href="#features" class="btn btn-outline">
                            <i class="fas fa-play-circle"></i> Lihat Demo
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <h3>1000+</h3>
                            <p>Pengguna Aktif</p>
                        </div>
                        <div class="stat-item">
                            <h3>99.9%</h3>
                            <p>Uptime</p>
                        </div>
                        <div class="stat-item">
                            <h3>24/7</h3>
                            <p>Support</p>
                        </div>
                    </div>
                </div>
                <div class="hero-right" data-aos="fade-left">
                    <div class="hero-image">
                        <svg viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                            <!-- Floating Cards -->
                            <g class="float-card">
                                <rect x="50" y="100" width="200" height="120" rx="15" fill="white" filter="url(#shadow)" />
                                <circle cx="90" cy="140" r="20" fill="#6366f1" />
                                <rect x="120" y="130" width="100" height="10" rx="5" fill="#e5e7eb" />
                                <rect x="120" y="150" width="80" height="8" rx="4" fill="#e5e7eb" />
                            </g>

                            <g class="float-card" style="animation-delay: 0.5s">
                                <rect x="350" y="150" width="200" height="120" rx="15" fill="white" filter="url(#shadow)" />
                                <circle cx="390" cy="190" r="20" fill="#8b5cf6" />
                                <rect x="420" y="180" width="100" height="10" rx="5" fill="#e5e7eb" />
                                <rect x="420" y="200" width="80" height="8" rx="4" fill="#e5e7eb" />
                            </g>

                            <!-- Main Dashboard -->
                            <rect x="150" y="250" width="300" height="280" rx="20" fill="white" filter="url(#shadow)" />

                            <!-- Header -->
                            <rect x="150" y="250" width="300" height="60" rx="20" fill="url(#gradient1)" />
                            <circle cx="180" cy="280" r="15" fill="white" opacity="0.3" />
                            <rect x="205" y="270" width="100" height="8" rx="4" fill="white" opacity="0.8" />
                            <rect x="205" y="285" width="70" height="6" rx="3" fill="white" opacity="0.6" />

                            <!-- Stats Cards -->
                            <rect x="170" y="330" width="120" height="80" rx="12" fill="#f0f9ff" />
                            <text x="190" y="360" font-size="24" font-weight="bold" fill="#6366f1">₹2.5M</text>
                            <text x="190" y="385" font-size="12" fill="#64748b">Total Sales</text>

                            <rect x="310" y="330" width="120" height="80" rx="12" fill="#f0fdf4" />
                            <text x="330" y="360" font-size="24" font-weight="bold" fill="#10b981">+23%</text>
                            <text x="330" y="385" font-size="12" fill="#64748b">Growth</text>

                            <!-- Chart -->
                            <path d="M 170 450 L 200 430 L 240 445 L 280 420 L 320 435 L 360 415 L 400 425 L 430 410"
                                stroke="#6366f1" stroke-width="3" fill="none" stroke-linecap="round" />

                            <!-- Filters -->
                            <defs>
                                <filter id="shadow">
                                    <feDropShadow dx="0" dy="10" stdDeviation="20" flood-opacity="0.1" />
                                </filter>
                                <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#6366f1;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">Fitur Unggulan</span>
                <h2>Semua yang Anda Butuhkan dalam Satu Platform</h2>
                <p>Kelola bisnis toko elektronik Anda dengan fitur-fitur canggih dan mudah digunakan</p>
            </div>
            <div class="features-grid">
                <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon gradient-1">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Dashboard Analytics</h3>
                    <p>Monitor performa bisnis secara real-time dengan visualisasi data yang interaktif dan mudah dipahami.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Real-time monitoring</li>
                        <li><i class="fas fa-check"></i> Grafik interaktif</li>
                        <li><i class="fas fa-check"></i> Export laporan</li>
                    </ul>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon gradient-2">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h3>Manajemen Inventory</h3>
                    <p>Kelola stok barang dengan sistem yang terintegrasi, tracking otomatis, dan notifikasi stok menipis.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Auto-generate kode barang</li>
                        <li><i class="fas fa-check"></i> Kategori produk</li>
                        <li><i class="fas fa-check"></i> Alert stok minimum</li>
                    </ul>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-icon gradient-3">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <h3>Point of Sale (POS)</h3>
                    <p>Proses transaksi penjualan dengan cepat, cetak invoice otomatis, dan perhitungan pajak akurat.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Interface user-friendly</li>
                        <li><i class="fas fa-check"></i> Print invoice thermal</li>
                        <li><i class="fas fa-check"></i> Multiple payment methods</li>
                    </ul>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon gradient-4">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <h3>Stok Management</h3>
                    <p>Pantau pergerakan stok barang dengan riwayat lengkap setiap transaksi masuk dan keluar.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Riwayat stok detail</li>
                        <li><i class="fas fa-check"></i> Stock opname</li>
                        <li><i class="fas fa-check"></i> Multi-warehouse</li>
                    </ul>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon gradient-5">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h3>Laporan Keuangan</h3>
                    <p>Analisis rugi laba bisnis dengan perhitungan HPP, margin, dan profit yang akurat dan detail.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Laporan laba rugi</li>
                        <li><i class="fas fa-check"></i> Perhitungan margin</li>
                        <li><i class="fas fa-check"></i> Filter periode custom</li>
                    </ul>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-icon gradient-6">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h3>Pengaturan Lengkap</h3>
                    <p>Kustomisasi sistem sesuai kebutuhan toko Anda dengan pengaturan yang fleksibel dan mudah.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Profile management</li>
                        <li><i class="fas fa-check"></i> Store settings</li>
                        <li><i class="fas fa-check"></i> Tax configuration</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits" id="benefits">
        <div class="container">
            <div class="benefits-wrapper">
                <div class="benefits-left" data-aos="fade-right">
                    <span class="section-badge">Keunggulan Kami</span>
                    <h2>Mengapa Memilih Toko GenZ?</h2>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>Mudah Digunakan</h4>
                            <p>Interface yang intuitif dan user-friendly, tidak perlu training khusus untuk menggunakannya.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>Keamanan Terjamin</h4>
                            <p>Data Anda aman dengan enkripsi tingkat enterprise dan backup otomatis setiap hari.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>Performa Cepat</h4>
                            <p>Sistem yang ringan dan responsif, proses transaksi lebih cepat dan efisien.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>Support 24/7</h4>
                            <p>Tim support kami siap membantu Anda kapan saja melalui berbagai channel komunikasi.</p>
                        </div>
                    </div>
                </div>
                <div class="benefits-right" data-aos="fade-left">
                    <div class="benefits-image">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800" alt="Team Work">
                        <div class="floating-card card-1">
                            <i class="fas fa-users"></i>
                            <h4>1000+</h4>
                            <p>Happy Customers</p>
                        </div>
                        <div class="floating-card card-2">
                            <i class="fas fa-star"></i>
                            <h4>4.9/5</h4>
                            <p>User Rating</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing" id="pricing">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">Harga Terjangkau</span>
                <h2>Pilih Paket yang Sesuai untuk Anda</h2>
                <p>Harga yang transparan tanpa biaya tersembunyi</p>
            </div>
            <div class="pricing-grid">
                <div class="pricing-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="pricing-header">
                        <h3>Starter</h3>
                        <p>Cocok untuk toko kecil</p>
                    </div>
                    <div class="pricing-price">
                        <span class="currency">Rp</span>
                        <span class="amount">199K</span>
                        <span class="period">/bulan</span>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> 1 User</li>
                        <li><i class="fas fa-check"></i> 100 Produk</li>
                        <li><i class="fas fa-check"></i> 500 Transaksi/bulan</li>
                        <li><i class="fas fa-check"></i> Basic Support</li>
                        <li><i class="fas fa-check"></i> Mobile Access</li>
                    </ul>
                    <a href="login.php" class="btn btn-outline">Mulai Gratis</a>
                </div>
                <div class="pricing-card featured" data-aos="fade-up" data-aos-delay="200">
                    <div class="popular-badge">POPULER</div>
                    <div class="pricing-header">
                        <h3>Professional</h3>
                        <p>Untuk toko menengah</p>
                    </div>
                    <div class="pricing-price">
                        <span class="currency">Rp</span>
                        <span class="amount">399K</span>
                        <span class="period">/bulan</span>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> 5 Users</li>
                        <li><i class="fas fa-check"></i> Unlimited Produk</li>
                        <li><i class="fas fa-check"></i> Unlimited Transaksi</li>
                        <li><i class="fas fa-check"></i> Priority Support</li>
                        <li><i class="fas fa-check"></i> Advanced Reports</li>
                    </ul>
                    <a href="login.php" class="btn btn-primary">Pilih Paket Ini</a>
                </div>
                <div class="pricing-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="pricing-header">
                        <h3>Enterprise</h3>
                        <p>Untuk bisnis besar</p>
                    </div>
                    <div class="pricing-price">
                        <span class="currency">Rp</span>
                        <span class="amount">799K</span>
                        <span class="period">/bulan</span>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Unlimited Users</li>
                        <li><i class="fas fa-check"></i> Unlimited Everything</li>
                        <li><i class="fas fa-check"></i> Multi-Branch</li>
                        <li><i class="fas fa-check"></i> 24/7 Support</li>
                        <li><i class="fas fa-check"></i> Custom Integration</li>
                    </ul>
                    <a href="login.php" class="btn btn-outline">Hubungi Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">Testimoni</span>
                <h2>Apa Kata Mereka?</h2>
                <p>Ribuan pengguna telah merasakan manfaatnya</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Sistem yang sangat membantu! Sejak pakai Toko GenZ, omzet naik 35% dan stok lebih terkontrol. Highly recommended!"</p>
                    <div class="testimonial-author">
                        <img src="https://i.pravatar.cc/100?img=1" alt="Ahmad">
                        <div>
                            <h4>Ahmad Fauzi</h4>
                            <span>Toko Elektronik Jaya</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Interface-nya mudah dipahami, staff saya langsung bisa pakai tanpa training lama. Fitur laporannya juga lengkap banget!"</p>
                    <div class="testimonial-author">
                        <img src="https://i.pravatar.cc/100?img=5" alt="Siti">
                        <div>
                            <h4>Siti Nurhaliza</h4>
                            <span>Electronic Store 88</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Support-nya responsif banget! Kalau ada masalah langsung dibantu. Sistem juga jarang error, sangat reliable!"</p>
                    <div class="testimonial-author">
                        <img src="https://i.pravatar.cc/100?img=3" alt="Budi">
                        <div>
                            <h4>Budi Santoso</h4>
                            <span>Budi Electronics</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2>Siap Meningkatkan Bisnis Anda?</h2>
                <p>Bergabunglah dengan ribuan pemilik toko yang sudah merasakan manfaatnya</p>
                <div class="cta-buttons">
                    <a href="login.php" class="btn btn-white">
                        <i class="fas fa-rocket"></i> Mulai Sekarang Gratis
                    </a>
                    <a href="#features" class="btn btn-outline-white">
                        <i class="fas fa-phone"></i> Hubungi Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <div class="footer-logo">
                        <i class="fas fa-store"></i>
                        <span>Toko<strong>GenZ</strong></span>
                    </div>
                    <p>Sistem manajemen toko elektronik modern yang membantu bisnis Anda berkembang lebih cepat.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Product</h4>
                    <ul>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#pricing">Harga</a></li>
                        <li><a href="#">Dokumentasi</a></li>
                        <li><a href="#">Update</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Toko GenZ. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('navMenu');

        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                }
            });
        });

        // Active nav link on scroll
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').slice(1) === current) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>