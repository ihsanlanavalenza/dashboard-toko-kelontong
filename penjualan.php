<?php
$page_title = 'Point of Sale';
$breadcrumb = 'Home / Penjualan';
require_once 'header.php';

// Get pengaturan pajak
$pengaturan = get_pengaturan_toko();
$persentase_pajak = $pengaturan['persentase_pajak'];

// Get barang yang ready stok
$query_barang = "SELECT b.*, k.nama_kategori 
                 FROM barang b
                 LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                 WHERE b.status = 'aktif' AND b.stok > 0
                 ORDER BY b.nama_barang ASC";
$result_barang = $conn->query($query_barang);
?>

<style>
    .product-card {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .product-card:hover {
        border-color: #667eea;
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }

    .cart-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s;
    }

    .cart-item:hover {
        background: #e9ecef;
    }

    .cart-summary {
        position: sticky;
        top: 80px;
    }

    .qty-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-control button {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 5px;
    }

    .qty-control input {
        width: 60px;
        text-align: center;
        border-radius: 5px;
    }
</style>

<div class="row">
    <!-- Product List -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-box"></i> Daftar Produk
                <div class="float-end">
                    <input type="text" id="searchProduct" class="form-control form-control-sm"
                        placeholder="🔍 Cari produk..." style="width: 250px;">
                </div>
            </div>
            <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                <div class="row" id="productList">
                    <?php while ($barang = $result_barang->fetch_assoc()): ?>
                        <div class="col-md-6 col-lg-4 mb-3 product-item"
                            data-name="<?php echo strtolower($barang['nama_barang']); ?>"
                            data-code="<?php echo strtolower($barang['kode_barang']); ?>">
                            <div class="product-card card h-100" onclick='addToCart(<?php echo json_encode($barang); ?>)'>
                                <div class="card-body">
                                    <span class="badge bg-info mb-2"><?php echo $barang['nama_kategori']; ?></span>
                                    <h6 class="card-title"><?php echo $barang['nama_barang']; ?></h6>
                                    <p class="text-muted mb-1" style="font-size: 12px;">
                                        <?php echo $barang['kode_barang']; ?> • <?php echo $barang['merk']; ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong style="color: #667eea; font-size: 16px;">
                                            <?php echo rupiah($barang['harga_jual']); ?>
                                        </strong>
                                        <span class="badge bg-success">Stok: <?php echo $barang['stok']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart -->
    <div class="col-lg-5">
        <div class="cart-summary">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="fas fa-shopping-cart"></i> Keranjang Belanja
                    <button class="btn btn-sm btn-light float-end" onclick="clearCart()">
                        <i class="fas fa-trash"></i> Kosongkan
                    </button>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;" id="cartItems">
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>Keranjang masih kosong</p>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select id="metodeBayar" class="form-select">
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="kartu_debit">Kartu Debit</option>
                            <option value="kartu_kredit">Kartu Kredit</option>
                            <option value="ewallet">E-Wallet</option>
                        </select>
                    </div>

                    <table class="table table-sm">
                        <tr>
                            <td>Subtotal:</td>
                            <td class="text-end"><strong id="subtotalDisplay">Rp 0</strong></td>
                        </tr>
                        <tr>
                            <td>Pajak (<?php echo $persentase_pajak; ?>%):</td>
                            <td class="text-end"><strong id="pajakDisplay">Rp 0</strong></td>
                        </tr>
                        <tr style="font-size: 18px; color: #667eea;">
                            <td><strong>Total:</strong></td>
                            <td class="text-end"><strong id="totalDisplay">Rp 0</strong></td>
                        </tr>
                    </table>

                    <div class="mb-3">
                        <label class="form-label">Uang Bayar</label>
                        <input type="number" id="uangBayar" class="form-control" placeholder="0" onkeyup="hitungKembalian()">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Uang Kembali</label>
                        <input type="text" id="uangKembali" class="form-control" readonly style="font-size: 18px; font-weight: bold; color: #11998e;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea id="catatan" class="form-control" rows="2" placeholder="Tambahkan catatan transaksi..."></textarea>
                    </div>

                    <button class="btn btn-primary w-100 btn-lg" onclick="prosesTransaksi()">
                        <i class="fas fa-check-circle"></i> Proses Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];
    const pajakPersen = <?php echo $persentase_pajak; ?>;

    // Search Product
    document.getElementById('searchProduct').addEventListener('keyup', function() {
        const search = this.value.toLowerCase();
        const items = document.querySelectorAll('.product-item');

        items.forEach(item => {
            const name = item.dataset.name;
            const code = item.dataset.code;
            if (name.includes(search) || code.includes(search)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Add to Cart
    function addToCart(barang) {
        const existing = cart.find(item => item.id_barang === barang.id_barang);

        if (existing) {
            if (existing.qty < barang.stok) {
                existing.qty++;
            } else {
                alert('Stok tidak mencukupi!');
                return;
            }
        } else {
            cart.push({
                id_barang: barang.id_barang,
                kode_barang: barang.kode_barang,
                nama_barang: barang.nama_barang,
                harga_jual: parseFloat(barang.harga_jual),
                stok: parseInt(barang.stok),
                qty: 1
            });
        }

        updateCart();
    }

    // Update Cart Display
    function updateCart() {
        const cartItems = document.getElementById('cartItems');

        if (cart.length === 0) {
            cartItems.innerHTML = `
                <div class="text-center text-muted py-5">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <p>Keranjang masih kosong</p>
                </div>
            `;
            updateSummary();
            return;
        }

        let html = '';
        cart.forEach((item, index) => {
            const subtotal = item.harga_jual * item.qty;
            html += `
                <div class="cart-item">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong>${item.nama_barang}</strong><br>
                            <small class="text-muted">${item.kode_barang}</small><br>
                            <span style="color: #667eea;">${formatRupiah(item.harga_jual)}</span>
                        </div>
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="qty-control">
                            <button class="btn btn-sm btn-secondary" onclick="updateQty(${index}, -1)">-</button>
                            <input type="number" class="form-control form-control-sm" value="${item.qty}" 
                                   onchange="setQty(${index}, this.value)" min="1" max="${item.stok}">
                            <button class="btn btn-sm btn-secondary" onclick="updateQty(${index}, 1)">+</button>
                        </div>
                        <strong>${formatRupiah(subtotal)}</strong>
                    </div>
                </div>
            `;
        });

        cartItems.innerHTML = html;
        updateSummary();
    }

    // Update Quantity
    function updateQty(index, change) {
        const item = cart[index];
        const newQty = item.qty + change;

        if (newQty < 1) {
            removeFromCart(index);
            return;
        }

        if (newQty > item.stok) {
            alert('Stok tidak mencukupi!');
            return;
        }

        item.qty = newQty;
        updateCart();
    }

    // Set Quantity
    function setQty(index, qty) {
        qty = parseInt(qty);
        const item = cart[index];

        if (qty < 1 || isNaN(qty)) {
            removeFromCart(index);
            return;
        }

        if (qty > item.stok) {
            alert('Stok tidak mencukupi!');
            qty = item.stok;
        }

        item.qty = qty;
        updateCart();
    }

    // Remove from Cart
    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCart();
    }

    // Clear Cart
    function clearCart() {
        if (confirm('Kosongkan keranjang?')) {
            cart = [];
            updateCart();
            document.getElementById('uangBayar').value = '';
            document.getElementById('uangKembali').value = '';
        }
    }

    // Update Summary
    function updateSummary() {
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.harga_jual * item.qty;
        });

        const pajak = subtotal * (pajakPersen / 100);
        const total = subtotal + pajak;

        document.getElementById('subtotalDisplay').textContent = formatRupiah(subtotal);
        document.getElementById('pajakDisplay').textContent = formatRupiah(pajak);
        document.getElementById('totalDisplay').textContent = formatRupiah(total);

        hitungKembalian();
    }

    // Hitung Kembalian
    function hitungKembalian() {
        const total = parseFloat(document.getElementById('totalDisplay').textContent.replace(/[^0-9]/g, ''));
        const bayar = parseFloat(document.getElementById('uangBayar').value) || 0;
        const kembalian = bayar - total;

        document.getElementById('uangKembali').value = formatRupiah(kembalian >= 0 ? kembalian : 0);
    }

    // Format Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + Math.round(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Proses Transaksi
    function prosesTransaksi() {
        if (cart.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }

        const subtotal = parseFloat(document.getElementById('subtotalDisplay').textContent.replace(/[^0-9]/g, ''));
        const pajak = parseFloat(document.getElementById('pajakDisplay').textContent.replace(/[^0-9]/g, ''));
        const total = parseFloat(document.getElementById('totalDisplay').textContent.replace(/[^0-9]/g, ''));
        const uangBayar = parseFloat(document.getElementById('uangBayar').value) || 0;

        if (uangBayar < total) {
            alert('Uang bayar kurang!');
            return;
        }

        const kembalian = uangBayar - total;
        const metodeBayar = document.getElementById('metodeBayar').value;
        const catatan = document.getElementById('catatan').value;

        // Kirim ke server
        const formData = new FormData();
        formData.append('cart', JSON.stringify(cart));
        formData.append('subtotal', subtotal);
        formData.append('pajak', pajak);
        formData.append('total_bayar', total);
        formData.append('uang_bayar', uangBayar);
        formData.append('uang_kembali', kembalian);
        formData.append('metode_bayar', metodeBayar);
        formData.append('catatan', catatan);
        formData.append('proses_transaksi', '1');

        fetch('proses_penjualan.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaksi berhasil!\nNo. Faktur: ' + data.no_faktur);

                    // Cetak faktur
                    window.open('cetak_faktur.php?id=' + data.id_transaksi, '_blank');

                    // Reset
                    cart = [];
                    updateCart();
                    document.getElementById('uangBayar').value = '';
                    document.getElementById('catatan').value = '';
                    document.getElementById('metodeBayar').value = 'tunai';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan: ' + error);
            });
    }
</script>

<?php require_once 'footer.php'; ?>