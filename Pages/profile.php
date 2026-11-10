<?php
// Proteksi: wajib login
if (!isset($_SESSION['role'])) {
    echo "<script>alert('Silahkan login untuk melihat profil'); window.location='Main.php?Pages=login';</script>";
    exit();
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card glass-card overflow-hidden">
            <!-- Header profil -->
            <div class="text-center pt-5 pb-4 px-4" style="background: linear-gradient(135deg, rgba(245,185,66,0.10), rgba(56,189,248,0.06)); border-bottom: 1px solid var(--border-subtle);">
                <div class="user-avatar mx-auto mb-3 shadow"
                     style="width: 96px; height: 96px; font-size: 38px; border: 3px solid var(--accent); background: var(--bg-solid); color: var(--accent);">
                    <?php echo htmlspecialchars(strtoupper(substr($_SESSION['name'], 0, 1))); ?>
                </div>
                <h3 class="fw-bold mb-1" style="font-family: var(--font-display);">
                    <?php echo htmlspecialchars($_SESSION['name']); ?>
                </h3>
                <span class="badge" style="background: rgba(245,185,66,0.15); color: var(--accent);">
                    <?php echo htmlspecialchars(strtoupper($_SESSION['role'])); ?> MEMBER
                </span>
            </div>

            <!-- Detail -->
            <div class="card-body p-4 p-md-5">
                <div class="row mb-4 align-items-center">
                    <div class="col-sm-4">
                        <label class="text-secondary small text-uppercase fw-bold" style="letter-spacing: 1px;">Email Address</label>
                    </div>
                    <div class="col-sm-8">
                        <p class="mb-0"><i class="bi bi-envelope me-2 text-accent"></i><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    </div>
                </div>

                <div class="row mb-4 align-items-center">
                    <div class="col-sm-4">
                        <label class="text-secondary small text-uppercase fw-bold" style="letter-spacing: 1px;">Account Status</label>
                    </div>
                    <div class="col-sm-8">
                        <p class="mb-0" style="color: var(--success);"><i class="bi bi-check-circle-fill me-2"></i>Verified Account</p>
                    </div>
                </div>

                <div class="row mb-4 align-items-center">
                    <div class="col-sm-4">
                        <label class="text-secondary small text-uppercase fw-bold" style="letter-spacing: 1px;">User ID</label>
                    </div>
                    <div class="col-sm-8">
                        <p class="mb-0">#<?php echo (int) $_SESSION['userid']; ?></p>
                    </div>
                </div>

                <hr class="border-secondary opacity-25">

                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 gap-3">
                    <a href="Main.php?Pages=Home" class="btn btn-ghost px-4">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="Main.php?Pages=riwayat" class="btn btn-gold px-4">
                        <i class="bi bi-receipt me-2"></i>Lihat Riwayat Tiket
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
