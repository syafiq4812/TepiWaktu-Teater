<?php
require_once(__DIR__ . '/../Class/class.Produk.php');

$objProduk = new Produk();
$result = $objProduk->ShowAllProduk();
?>

<div class="container py-3">
    <div class="text-center mb-5">
        <p class="section-eyebrow mb-2">Katalog Pertunjukan</p>
        <h2 class="section-title display-4 mb-3">Jadwal Pertunjukan</h2>
        <p class="text-secondary mx-auto" style="max-width: 560px;">
            Pilih pertunjukan favoritmu dan amankan tiketnya sekarang juga.
        </p>
    </div>

    <div class="row g-4 justify-content-center">
        <?php
        if ($result && mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="col-12">
            <div class="card card-interactive overflow-hidden">
                <div class="row g-0 align-items-stretch">

                    <div class="col-md-4 position-relative">
                        <img src="img/<?php echo htmlspecialchars($row['poster']); ?>"
                             class="w-100 h-100"
                             style="object-fit: cover; min-height: 260px; max-height: 340px;"
                             alt="Poster <?php echo htmlspecialchars($row['nama_acara']); ?>"
                             loading="lazy">
                    </div>

                    <div class="col-md-8">
                        <div class="card-body p-4 d-flex flex-column h-100 justify-content-between">

                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2 gap-3">
                                    <div>
                                        <span class="badge mb-2" style="background: rgba(56,189,248,0.15); color: var(--info);">
                                            <?php echo htmlspecialchars($row['kategori']); ?>
                                        </span>
                                        <h3 class="card-title fw-bold mb-0" style="font-family: var(--font-display);">
                                            <?php echo htmlspecialchars($row['nama_acara']); ?>
                                        </h3>
                                    </div>
                                    <div class="text-end flex-shrink-0">
                                        <h4 class="fw-bold mb-0 text-accent">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></h4>
                                        <small class="text-secondary">Per Tiket</small>
                                    </div>
                                </div>

                                <p class="card-text text-secondary mt-3 mb-0" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.7;">
                                    <?php echo htmlspecialchars($row['deskripsi']); ?>
                                </p>
                            </div>

                            <div class="mt-4">
                                <hr class="border-secondary opacity-25 mb-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                                    <div class="d-flex align-items-center gap-4">
                                        <div>
                                            <small class="text-secondary d-block">Tanggal</small>
                                            <span class="fw-semibold">
                                                <i class="bi bi-calendar3 me-1 text-accent"></i>
                                                <?php echo date('d M Y', strtotime($row['tanggal'])); ?>
                                            </span>
                                        </div>
                                        <div class="border-start border-secondary ps-4" style="height: 32px; opacity: 0.3;"></div>
                                        <div>
                                            <small class="text-secondary d-block">Waktu</small>
                                            <span class="fw-semibold">
                                                <i class="bi bi-clock me-1 text-accent"></i>
                                                <?php echo date('H:i', strtotime($row['waktu'])); ?> WIB
                                            </span>
                                        </div>
                                    </div>

                                    <?php if (isset($_SESSION['userid'])): ?>
                                        <a href="Main.php?Pages=ticket&id=<?php echo (int) $row['id_produk']; ?>"
                                           class="btn btn-gold px-5 py-2">
                                            <i class="bi bi-ticket me-2"></i>Beli Tiket
                                        </a>
                                    <?php else: ?>
                                        <a href="Main.php?Pages=login"
                                           class="btn btn-gold px-5 py-2"
                                           onclick="alert('Silakan login terlebih dahulu untuk membeli tiket!');">
                                            <i class="bi bi-ticket me-2"></i>Beli Tiket
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
            endwhile;
        else:
        ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-secondary d-block mb-3"></i>
            <p class="text-secondary">Belum ada jadwal pertunjukan tersedia saat ini.</p>
            <a href="Main.php?Pages=Home" class="btn btn-ghost btn-sm">Kembali ke Home</a>
        </div>
        <?php endif; ?>
    </div>
</div>
