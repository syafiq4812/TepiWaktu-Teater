<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <p class="section-eyebrow mb-1">Katalog</p>
        <h5 class="fw-bold mb-0" style="font-family: var(--font-display);">Manajemen Pertunjukan</h5>
    </div>
    <a href="dashboardadmin.php?page=tambahproduk" class="btn btn-gold btn-sm px-3">
        <i class="bi bi-plus-lg me-1"></i>Tambah Produk Baru
    </a>
</div>

<?php
$prod = $objProd->ShowAllProduk();
if (mysqli_num_rows($prod) > 0):
?>
<div class="table-responsive">
    <table class="table table-dark table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>Nama Acara</th>
                <th>Kategori</th>
                <th>Harga Satuan</th>
                <th>Jadwal</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = mysqli_fetch_assoc($prod)): ?>
            <tr>
                <td class="fw-semibold"><?php echo htmlspecialchars($p['nama_acara']); ?></td>
                <td>
                    <span class="badge" style="background: rgba(56,189,248,0.15); color: var(--info);">
                        <?php echo htmlspecialchars($p['kategori']); ?>
                    </span>
                </td>
                <td class="fw-semibold text-accent">Rp <?php echo number_format($p['harga'], 0, ',', '.'); ?></td>
                <td class="text-secondary">
                    <?php echo date('d M Y', strtotime($p['tanggal'])); ?>
                    &bull; <?php echo date('H:i', strtotime($p['waktu'])); ?>
                </td>
                <td class="text-end">
                    <a href="dashboardadmin.php?page=editproduk&id=<?php echo (int) $p['id_produk']; ?>"
                       class="btn btn-sm btn-outline-warning me-1">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                    </a>
                    <a href="dashboardadmin.php?page=hapusproduk&id=<?php echo (int) $p['id_produk']; ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Apakah Anda yakin ingin menghapus pertunjukan ini?')">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div class="text-center py-5">
    <i class="bi bi-calendar-x fs-1 text-secondary opacity-50"></i>
    <p class="text-secondary mt-3">Belum ada pertunjukan tersedia.</p>
    <a href="dashboardadmin.php?page=tambahproduk" class="btn btn-gold btn-sm">Tambah Sekarang</a>
</div>
<?php endif; ?>
