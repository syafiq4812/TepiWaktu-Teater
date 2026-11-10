<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <p class="section-eyebrow mb-1">Transaksi</p>
        <h5 class="fw-bold mb-0" style="font-family: var(--font-display);">Semua Pembelian Tiket</h5>
    </div>
</div>

<?php
$trx = $objTrx->ShowAllTransactions();
if (mysqli_num_rows($trx) > 0):
?>
<div class="table-responsive">
    <table class="table table-dark table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>Pembeli</th>
                <th>Pertunjukan</th>
                <th class="text-center">Jumlah</th>
                <th>Total Harga</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($trx)):
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
            <tr>
                <td>
                    <div class="fw-semibold"><?php echo htmlspecialchars($row['nama_pembeli']); ?></div>
                </td>
                <td><?php echo htmlspecialchars($row['nama_acara']); ?></td>
                <td class="text-center"><?php echo (int) $row['jumlah']; ?></td>
                <td class="fw-semibold">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td>
                    <span class="badge" style="background: rgba(255,255,255,0.10); color: var(--text-secondary);">
                        <?php echo htmlspecialchars(strtoupper($row['metode_bayar'])); ?>
                    </span>
                </td>
                <td>
                    <span class="badge <?php echo $badgeClass; ?>">
                        <i class="bi <?php echo $icon; ?> me-1"></i><?php echo htmlspecialchars($row['status']); ?>
                    </span>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div class="text-center py-5">
    <i class="bi bi-receipt-cutoff fs-1 text-secondary opacity-50"></i>
    <p class="text-secondary mt-3 mb-0">Belum ada transaksi yang tercatat.</p>
</div>
<?php endif; ?>
