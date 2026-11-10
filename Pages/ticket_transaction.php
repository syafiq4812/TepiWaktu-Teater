<?php
require_once(__DIR__ . '/../Class/class.Produk.php');

// Proteksi: wajib login untuk membeli
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Silakan login terlebih dahulu untuk membeli tiket!'); window.location='Main.php?Pages=login';</script>";
    exit();
}

$id_produk = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$objProduk = new Produk();
$result = $objProduk->GetProdukByID($id_produk);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location='Main.php?Pages=Produk';</script>";
    exit;
}
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="Main.php?Pages=Produk" class="text-secondary text-decoration-none">Produk</a></li>
                    <li class="breadcrumb-item active text-accent" aria-current="page">Pembelian Tiket</li>
                </ol>
            </nav>

            <div class="card glass-card overflow-hidden">
                <div class="row g-0">

                    <!-- Ringkasan pertunjukan -->
                    <div class="col-md-5 p-4 p-md-5" style="background: rgba(0,0,0,0.25); border-right: 1px solid var(--border-subtle);">
                        <p class="section-eyebrow mb-2">Detail Pesanan</p>

                        <div class="img-wrapper mb-4">
                            <img src="img/<?php echo htmlspecialchars($data['poster']); ?>"
                                 class="w-100"
                                 style="object-fit: cover; height: 200px; border-radius: var(--radius-md);"
                                 alt="<?php echo htmlspecialchars($data['nama_acara']); ?>"
                                 loading="lazy">
                        </div>

                        <h4 class="fw-bold mb-3" style="font-family: var(--font-display);">
                            <?php echo htmlspecialchars($data['nama_acara']); ?>
                        </h4>

                        <div class="mb-3">
                            <small class="text-secondary d-block">Kategori</small>
                            <span class="badge" style="background: rgba(56,189,248,0.15); color: var(--info);">
                                <?php echo htmlspecialchars($data['kategori']); ?>
                            </span>
                        </div>

                        <div class="mb-3">
                            <small class="text-secondary d-block">Jadwal</small>
                            <span class="fw-semibold">
                                <i class="bi bi-calendar3 me-1 text-accent"></i>
                                <?php echo date('d M Y', strtotime($data['tanggal'])); ?>
                                &bull; <?php echo date('H:i', strtotime($data['waktu'])); ?> WIB
                            </span>
                        </div>

                        <div class="mb-4">
                            <small class="text-secondary d-block">Harga per Tiket</small>
                            <span class="fs-4 fw-bold text-accent">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></span>
                        </div>

                        <div class="p-3 rounded-3" style="background: rgba(245,185,66,0.08); border: 1px solid rgba(245,185,66,0.2);">
                            <small class="text-secondary d-block mb-1"><i class="bi bi-info-circle me-1 text-accent"></i> Informasi</small>
                            <p class="small mb-0 text-secondary" style="line-height: 1.6;">
                                E-ticket akan dikirim ke email
                                <strong class="text-white"><?php echo htmlspecialchars($_SESSION['email']); ?></strong>
                                setelah pembayaran berhasil.
                            </p>
                        </div>
                    </div>

                    <!-- Form pembelian -->
                    <div class="col-md-7 p-4 p-md-5">
                        <p class="section-eyebrow mb-2">Langkah 1</p>
                        <h4 class="fw-bold mb-4" style="font-family: var(--font-display);">Formulir Pembelian</h4>

                        <form action="Main.php?Pages=proses_beli" method="POST">
                            <input type="hidden" name="id_produk" value="<?php echo (int) $data['id_produk']; ?>">

                            <div class="mb-4">
                                <label class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Email Penerima</label>
                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="jumlah_tiket" class="form-label">Jumlah Tiket (maks. 10)</label>
                                <div class="input-group">
                                    <button class="btn btn-ghost" type="button" id="btnMinus" aria-label="Kurangi">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                    <input type="number" name="jumlah_tiket" id="jumlah_tiket"
                                           class="form-control text-center" min="1" max="10" value="1" required
                                           style="max-width: 90px;">
                                    <button class="btn btn-ghost" type="button" id="btnPlus" aria-label="Tambah">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Total harga (live) -->
                            <div class="p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center"
                                 style="background: rgba(0,0,0,0.30); border: 1px solid var(--border-subtle);">
                                <span class="text-secondary small text-uppercase fw-bold" style="letter-spacing: 1px;">Total Bayar</span>
                                <span class="fs-4 fw-bold text-accent" id="totalHarga">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></span>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="btnBeli" class="btn btn-gold py-2 fw-bold">
                                    <i class="bi bi-credit-card me-2"></i>Lanjut ke Pembayaran
                                </button>
                                <a href="Main.php?Pages=Produk" class="btn btn-ghost py-2">Kembali Pilih Tiket</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    var hargaSatuan = <?php echo (int) $data['harga']; ?>;
    var input = document.getElementById('jumlah_tiket');
    var totalEl = document.getElementById('totalHarga');

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateTotal() {
        var jumlah = parseInt(input.value, 10);
        if (isNaN(jumlah) || jumlah < 1) jumlah = 1;
        if (jumlah > 10) jumlah = 10;
        input.value = jumlah;
        totalEl.textContent = formatRupiah(hargaSatuan * jumlah);
    }

    document.getElementById('btnMinus').addEventListener('click', function () {
        input.value = Math.max(1, parseInt(input.value, 10) - 1);
        updateTotal();
    });

    document.getElementById('btnPlus').addEventListener('click', function () {
        input.value = Math.min(10, parseInt(input.value, 10) + 1);
        updateTotal();
    });

    input.addEventListener('input', updateTotal);
})();
</script>
