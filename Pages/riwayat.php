<?php
require_once(__DIR__ . '/../Class/class.Transaction.php');

// Proteksi: wajib login
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Silahkan login untuk melihat riwayat'); window.location='Main.php?Pages=login';</script>";
    exit();
}

$objTrx = new Transaction();
$userid_login = (int) $_SESSION['userid'];
$result = $objTrx->GetUserHistory($userid_login);
?>

<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <p class="section-eyebrow mb-1">Tiket Saya</p>
            <h2 class="section-title display-5 mb-0">Riwayat Pesanan</h2>
        </div>
        <span class="badge" style="background: rgba(56,189,248,0.15); color: var(--info);">
            User ID: #<?php echo $userid_login; ?>
        </span>
    </div>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)):
                // Kelas badge berdasarkan status
                $status = strtolower($row['status']);
                if ($status === 'success') {
                    $badgeClass = 'badge-status-success';
                    $icon = 'bi-check-circle-fill';
                } else if ($status === 'pending') {
                    $badgeClass = 'badge-status-pending';
                    $icon = 'bi-hourglass-split';
                } else {
                    $badgeClass = 'badge-status-failed';
                    $icon = 'bi-x-circle-fill';
                }
            ?>
            <div class="col-12 col-md-6">
                <div class="card card-interactive h-100">
                    <div class="row g-0">
                        <div class="col-4 p-2">
                            <img src="img/<?php echo htmlspecialchars($row['poster']); ?>"
                                 class="img-fluid rounded h-100 w-100"
                                 style="object-fit: cover; min-height: 150px;"
                                 alt="<?php echo htmlspecialchars($row['nama_acara']); ?>"
                                 loading="lazy">
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title fw-bold text-accent mb-1" style="font-family: var(--font-display);">
                                        <?php echo htmlspecialchars($row['nama_acara']); ?>
                                    </h5>
                                    <small class="text-secondary">#<?php echo (int) $row['transaction_id']; ?></small>
                                </div>

                                <p class="small mb-2 text-secondary">
                                    <i class="bi bi-clock me-1"></i>
                                    Dipesan: <?php echo date('d M Y', strtotime($row['tanggal_transaksi'])); ?>
                                </p>

                                <p class="mb-2">
                                    <span class="badge" style="background: rgba(255,255,255,0.10); color: var(--text-secondary);">
                                        <?php echo (int) $row['jumlah']; ?> Tiket
                                    </span>
                                    <span class="ms-2 fw-bold">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></span>
                                </p>

                                <div class="pt-2 border-top border-secondary border-opacity-25 mt-2 d-flex justify-content-between align-items-center">
                                    <small class="text-secondary"><?php echo htmlspecialchars(strtoupper($row['metode_bayar'])); ?></small>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <i class="bi <?php echo $icon; ?> me-1"></i><?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-receipt-cutoff fs-1 text-secondary opacity-50"></i>
                <p class="text-secondary mt-3">Belum ada riwayat transaksi untuk akun ini.</p>
                <a href="Main.php?Pages=Produk" class="btn btn-gold btn-sm px-4">Beli Tiket Sekarang</a>
            </div>
        <?php endif; ?>
    </div>
</div>
