<?php
// 1. Inisialisasi Session
if (!isset($_SESSION)) {
    session_start();
}

// 2. Proteksi Halaman (Hanya Employee yang bisa akses)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Employee.'); window.location='Main.php?Pages=login';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Tepi Waktu Teater</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        /* Aksen khusus employee (biru) agar beda dari admin (emas) */
        .emp-nav { background: rgba(56, 189, 248, 0.10); border-color: rgba(56,189,248,0.25); }
        .emp-nav .nav-link.active { background: var(--info) !important; color: #06121c !important; box-shadow: 0 4px 12px rgba(56,189,248,0.35); }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <p class="section-eyebrow mb-1" style="color: var(--info);">Employee Portal</p>
            <h2 class="fw-bold m-0" style="font-family: var(--font-display);">Dashboard Employee</h2>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-secondary small">
                Login sebagai:
                <span class="fw-semibold" style="color: var(--info);"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
            </div>
            <a href="Main.php?Pages=Home" class="btn btn-ghost btn-sm">
                <i class="bi bi-house me-1"></i>Situs
            </a>
            <a href="dashboardemployee.php?Pages=logout" class="btn btn-sm" style="color: var(--danger); border: 1px solid rgba(248,113,113,0.4);">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
        </div>
    </div>

    <!-- Konten -->
    <div class="glass-card p-4 p-md-5">
        <?php
        if (isset($_GET['Pages'])) {
            $page = $_GET['Pages'];

            switch ($page) {
                case 'logout':
                    session_destroy();
                    echo "<script>alert('Logout berhasil'); window.location='Main.php?Pages=login';</script>";
                    break;
                default:
                    echo "<div class='alert alert-danger'>Halaman tidak ditemukan.</div>";
                    break;
            }
        } else {
            // Tampilan awal employee
            echo "<div class='row g-4'>";
            echo "<div class='col-lg-8'>";
            echo "<h3 class='mb-2' style='font-family: var(--font-display);'>Halo, " . htmlspecialchars($_SESSION['name']) . "!</h3>";
            echo "<p class='text-secondary mb-4' style='line-height: 1.8;'>Selamat datang di dashboard karyawan. Anda masuk dengan email: <strong class='text-white'>" . htmlspecialchars($_SESSION['email']) . "</strong>.</p>";
            echo "<div class='alert' style='background: rgba(56,189,248,0.10); border: 1px solid rgba(56,189,248,0.25); color: var(--text-primary);'>";
            echo "<i class='bi bi-info-circle me-2' style='color: var(--info);'></i>";
            echo "Gunakan menu di situs utama untuk melihat jadwal pertunjukan dan mengelola tiket.</div>";
            echo "</div>";

            // Kartu ringkasan
            echo "<div class='col-lg-4'>";
            echo "<div class='card p-4 text-center h-100'>";
            echo "<i class='bi bi-person-badge fs-1 mb-2' style='color: var(--info);'></i>";
            echo "<h6 class='text-secondary text-uppercase mb-2' style='letter-spacing: 1px;'>Role Aktif</h6>";
            echo "<span class='badge mx-auto' style='background: rgba(56,189,248,0.15); color: var(--info); font-size: 0.95rem;'>" . htmlspecialchars(strtoupper($_SESSION['role'])) . "</span>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
