<div align="center">

# 🛒 Toko GenZ

### Modern Electronic Store Management System

[![Version](https://img.shields.io/badge/version-1.0.0-blue?style=for-the-badge)](https://github.com)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE)

**A comprehensive point-of-sale and inventory management system designed for modern electronics retail businesses**

[Features](#-features) • [Installation](#-installation) • [Usage](#-usage) • [Documentation](#-documentation)

---

</div>

## 📖 Overview

Toko GenZ is a full-featured electronic store management system built with modern PHP and MySQL. It provides everything you need to run a successful retail business: from inventory tracking and point-of-sale to detailed financial reporting and analytics.


## ✨ Features

<table>
<tr>
<td width="50%">

### 🔐 Authentication & Security
- Secure login with session management
- Password hashing & encryption
- SQL injection protection
- XSS & CSRF protection
- Role-based access control ready

### 📊 Smart Dashboard
- Real-time sales statistics
- 7-day sales trend charts
- Live inventory monitoring
- Recent transactions feed
- Best-selling products analytics

### 📦 Inventory Management
- Complete CRUD operations
- Auto-generated product codes
- Category-based organization
- Buy/sell price tracking
- Product status management
- Stock level monitoring

</td>
<td width="50%">

### 💳 Point of Sale (POS)
- Modern, responsive interface
- Quick product search
- Interactive shopping cart
- Automatic tax calculation (5%)
- Multiple payment methods
- Auto change calculation
- Instant receipt generation

### 📈 Financial Reporting
- Comprehensive profit/loss reports
- COGS (Cost of Goods Sold) calculation
- Gross & net profit analysis
- Profit margin tracking
- Category-wise breakdown
- Flexible date filtering
- Printable reports

### ⚙️ System Settings
- User profile management
- Password change
- Store configuration
- Tax settings customization
- Receipt footer customization

</td>
</tr>
</table>

---

## 🚀 Tech Stack

<div align="center">

| Category | Technologies |
|----------|-------------|
| **Backend** | ![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php&logoColor=white) |
| **Database** | ![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat&logo=mysql&logoColor=white) |
| **Frontend** | ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white) ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black) |
| **Framework** | ![Bootstrap](https://img.shields.io/badge/Bootstrap_5.3-7952B3?style=flat&logo=bootstrap&logoColor=white) |
| **Libraries** | Chart.js • DataTables • Font Awesome 6.4 |
| **Server** | ![Apache](https://img.shields.io/badge/Apache-D22128?style=flat&logo=apache&logoColor=white) XAMPP Stack |

</div>

---


## 📋 Prerequisites

Before you begin, ensure you have the following installed:

```bash
✓ PHP >= 8.0
✓ MySQL >= 5.7
✓ Apache Web Server
✓ XAMPP/WAMP/LAMP Stack
✓ Modern Web Browser (Chrome, Firefox, Safari, Edge)
```

---

## 🔧 Installation

### Quick Start

```bash
# 1️⃣ Navigate to your XAMPP htdocs directory
cd /Applications/XAMPP/xamppfiles/htdocs/

# 2️⃣ Project is already in the Pasya folder
# If cloning from repository:
# git clone <repository-url> Pasya
```

### Database Setup

1. **Start XAMPP Services**
   ```
   Open XAMPP Control Panel
   → Start Apache
   → Start MySQL
   ```

2. **Create Database**
   - Open **phpMyAdmin**: `http://localhost/phpmyadmin`
   - Create new database: `toko_genz`
   - Import `database.sql` file:
     - Select database `toko_genz`
     - Click **Import** tab
     - Choose file `database.sql`
     - Click **Go**

3. **Configure Database Connection**
   
   File `config.php` is pre-configured for XAMPP defaults:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'toko_genz');
   ```
   *Modify if using different credentials*

### Launch Application

```
🌐 Browser: http://localhost/Pasya/login.php
```

### Default Credentials

```
👤 Username: pasyaganteng
🔑 Password: pasya17
```

> ⚠️ **Important**: Change default credentials after first login for security

---


## 📁 Project Structure

```
Pasya/
│
├── 📄 Core Files
│   ├── config.php                  # Database config & helper functions
│   ├── database.sql                # SQL import file
│   └── README.md                   # Documentation
│
├── 🔐 Authentication
│   ├── login.php                   # Login page
│   └── logout.php                  # Logout handler
│
├── 🎨 Templates
│   ├── header.php                  # Header & sidebar template
│   └── footer.php                  # Footer & scripts template
│
├── 📊 Main Modules
│   ├── dashboard.php               # Main dashboard
│   ├── barang.php                  # Product management
│   ├── stok.php                    # Stock monitoring
│   ├── penjualan.php              # Point of Sale (POS)
│   ├── transaksi.php              # Transaction history
│   ├── laporan.php                # Profit/loss reports
│   └── pengaturan.php             # System settings
│
├── ⚙️ Processing Scripts
│   ├── proses_barang.php          # Product CRUD handler
│   ├── proses_stok.php            # Stock update handler
│   ├── proses_penjualan.php       # Sales processing
│   └── proses_pengaturan.php      # Settings update handler
│
├── 🔌 API Endpoints
│   ├── get_detail_transaksi.php   # Transaction details API
│   ├── get_riwayat_stok.php       # Stock history API
│   └── cetak_faktur.php           # Receipt printing
│
└── 🎨 Assets
    └── css/
        ├── style.css               # Main stylesheet
        ├── login.css               # Login page styles
        └── landing.css             # Landing page styles
```

---

## 🗄️ Database Schema

<details>
<summary><b>Click to expand database structure</b></summary>

### Core Tables

| Table | Description |
|-------|-------------|
| `users` | User accounts and authentication |
| `kategori` | Product categories |
| `barang` | Product master data |
| `transaksi` | Sales transaction headers |
| `detail_transaksi` | Transaction line items |
| `riwayat_stok` | Stock movement history |
| `pengaturan_toko` | Store configuration settings |

### Sample Data Included

- ✅ 1 Admin user account
- ✅ 10 Electronic product categories
- ✅ 10 Sample products
- ✅ Default store settings

</details>

---


## 🎨 UI/UX Highlights

<div align="center">

| Feature | Description |
|---------|-------------|
| 🎨 **Modern Design** | Gradient colors & contemporary aesthetics |
| 📱 **Fully Responsive** | Optimized for mobile, tablet & desktop |
| 🌗 **Smart Contrast** | Dark sidebar with light content area |
| ✨ **Smooth Animations** | Hover effects & transitions |
| 🎯 **Icon-Based Nav** | Intuitive Font Awesome icons |
| 📊 **Interactive Tables** | DataTables with search & pagination |
| 🔔 **Toast Notifications** | Real-time feedback system |
| 🖨️ **Print-Friendly** | Optimized layouts for printing |

</div>

### Responsive Breakpoints

```css
📱 Mobile    : < 768px
📱 Tablet    : 768px - 1024px
💻 Desktop   : > 1024px
```

---

## 🔒 Security Features

```
✓ Password Hashing        → BCrypt algorithm
✓ SQL Injection Prevention → Prepared statements
✓ XSS Protection          → htmlspecialchars()
✓ Input Sanitization      → clean_input() helper
✓ Session Management      → Secure session handling
✓ CSRF Protection Ready   → Token-based validation
```

---


## 💡 Usage

### Adding New Products

```
1. Navigate to 📦 Data Barang
2. Click ➕ Tambah Barang button
3. Fill in product details (code auto-generated)
4. Click 💾 Simpan
```

### Processing Sales

```
1. Open 💳 Penjualan (POS)
2. Click products to add to cart
3. Adjust quantities as needed
4. Select payment method
5. Enter payment amount
6. Click ✅ Proses Transaksi
7. Receipt prints automatically
```

### Viewing Reports

```
1. Access 📈 Laporan Rugi Laba
2. Select period (today, this week, this month, custom)
3. Click 📊 Tampilkan
4. Click 🖨️ Cetak to print report
```

---

## 🚀 Advanced Features

<table>
<tr>
<td width="33%">

### 🧮 Auto Calculations
- Item subtotals
- Transaction totals
- Tax computation
- Change calculation
- COGS tracking
- Gross & net profit
- Margin percentages

</td>
<td width="33%">

### 📊 Reporting
- Sales trend charts
- Top products ranking
- Category analysis
- Flexible date filters
- Print-ready formats
- Real-time updates
- Visual dashboards

</td>
<td width="33%">

### 📦 Inventory
- Auto stock updates
- Low stock alerts
- Complete history
- Multiple units
- Multi-warehouse ready
- Batch tracking
- Expiry management ready

</td>
</tr>
</table>

---


## 🐛 Troubleshooting

<details>
<summary><b>❌ Database Connection Error</b></summary>

**Error Message:**
```
Error: Koneksi gagal
```

**Solutions:**
1. Ensure MySQL is running in XAMPP Control Panel
2. Verify database credentials in `config.php`
3. Confirm `toko_genz` database exists
4. Check MySQL port (default: 3306)

</details>

<details>
<summary><b>⚪ Blank/White Page</b></summary>

**Solutions:**
1. Enable error reporting in `php.ini`:
   ```ini
   display_errors = On
   error_reporting = E_ALL
   ```
2. Check Apache error logs
3. Verify PHP version >= 8.0
4. Clear browser cache

</details>

<details>
<summary><b>🔐 Session Issues</b></summary>

**Solutions:**
1. Clear browser cookies
2. Restart browser completely
3. Check PHP session folder permissions
4. Verify `session_start()` in code

</details>

<details>
<summary><b>📊 DataTables Not Working</b></summary>

**Solutions:**
1. Check browser console for JavaScript errors
2. Verify jQuery is loaded before DataTables
3. Clear browser cache
4. Check internet connection (CDN dependencies)

</details>

---

## 💾 Backup & Restore

### Backup Database

**Via phpMyAdmin:**
```
1. Select toko_genz database
2. Click Export tab
3. Choose Quick export method
4. Click Go
```

**Via Command Line:**
```bash
mysqldump -u root toko_genz > backup_$(date +%Y%m%d).sql
```

### Restore Database

**Via phpMyAdmin:**
```
1. Select toko_genz database
2. Click Import tab
3. Choose your backup file
4. Click Go
```

**Via Command Line:**
```bash
mysql -u root toko_genz < backup_20251119.sql
```

---


## 🗺️ Roadmap

### 🚧 Upcoming Features

- [ ] **Multi-user & Role Management** - Admin, cashier, manager roles
- [ ] **Barcode Scanner Integration** - Quick product lookup
- [ ] **PDF & Excel Export** - Advanced report exports
- [ ] **Email Notifications** - Transaction receipts via email
- [ ] **SMS Gateway** - Order notifications & alerts
- [ ] **Customer Management** - CRM functionality
- [ ] **Loyalty Program** - Points & rewards system
- [ ] **REST API** - Mobile app integration
- [ ] **Multi-Store Support** - Branch management
- [ ] **Advanced Analytics** - AI-powered insights
- [ ] **Dark Mode** - UI theme switching
- [ ] **Multilingual Support** - i18n implementation

---

## 🤝 Contributing

We welcome contributions! This project follows best practices:

- ✅ Clean, readable code
- ✅ PSR-12 coding standards
- ✅ Comprehensive comments
- ✅ Security-first approach
- ✅ User-centric design
- ✅ Performance optimization

---

## 📄 License

This project is licensed under the **MIT License** - free for commercial and non-commercial use.

```
MIT License - Copyright (c) 2025 Toko GenZ
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction.
```

---

## 📞 Support

Need help? Have questions?

- 📧 **Email**: support@tokogenz.com
- 💬 **Discord**: [Join our community](https://discord.gg/tokogenz)
- 🐛 **Issues**: [GitHub Issues](https://github.com/tokogenz/issues)
- 📚 **Docs**: [Full Documentation](https://docs.tokogenz.com)

---

<div align="center">

## ⚡ Quick Start Command

```bash
# Complete setup in one go
1. Start XAMPP (Apache + MySQL)
2. Import database.sql via phpMyAdmin
3. Navigate to http://localhost/Pasya/login.php
4. Login with: pasyaganteng / pasya17
5. Start selling! 🎉
```

---

### 🌟 Star this project if you find it helpful!

**Built with ❤️ for modern retail businesses**

---

**Version** `1.0.0` • **Updated** November 2025 • **Stack** PHP Native + Bootstrap 5 + MySQL

[![Made with PHP](https://img.shields.io/badge/Made%20with-PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Powered by Bootstrap](https://img.shields.io/badge/Powered%20by-Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Database MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)

</div>
# dashboard-toko-kelontong
