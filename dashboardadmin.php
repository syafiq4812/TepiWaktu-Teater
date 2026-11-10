<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak! Hanya untuk Admin.'); window.location='Main.php';</script>";
    exit;
}

require_once __DIR__ . '/inc.koneksi.php';
require_once __DIR__ . '/Class/class.user.php';
require_once __DIR__ . '/Class/class.Produk.php';
require_once __DIR__ . '/Class/class.Transaction.php';

$objUser = new User();
$objProd = new Produk();
$objTrx  = new Transaction();

$page = isset($_GET['page']) ? strtolower($_GET['page']) : 'transaksi';

// Halaman mana yang sedang aktif (untuk highlight nav)
$navAktif = 'transaksi';
if (strpos($page, 'produk') !== false) {
    $navAktif = 'produk';
} else if (strpos($page, 'user') !== false) {
    $navAktif = 'user';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tepi Waktu Teater</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <p class="section-eyebrow mb-1">Panel Pengelola</p>
            <h2 class="fw-bold m-0" style="font-family: var(--font-display); letter-spacing: -0.5px;">Admin Dashboard</h2>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-secondary small">
                Login sebagai:
                <span class="text-accent fw-semibold"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
            </div>
            <a href="Main.php?Pages=Home" class="btn btn-ghost btn-sm">
                <i class="bi bi-house me-1"></i>Situs
            </a>
            <a href="Main.php?Pages=logout" class="btn btn-sm" style="color: var(--danger); border: 1px solid rgba(248,113,113,0.4);">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
        </div>
    </div>

    <!-- Navigasi -->
    <div class="glass-card p-2 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <ul class="nav nav-pills flex-grow-1">
            <li class="nav-item">
                <a class="nav-link fw-medium <?php echo ($navAktif === 'transaksi') ? 'active' : ''; ?>"
                   href="dashboardadmin.php?page=transaksi">
                    <i class="bi bi-receipt me-1"></i>Riwayat Transaksi
                </a>
            </li>
            <li class="nav-item mx-lg-2">
                <a class="nav-link fw-medium <?php echo ($navAktif === 'produk') ? 'active' : ''; ?>"
                   href="dashboardadmin.php?page=produk">
                    <i class="bi bi-music-note-beamed me-1"></i>Kelola Produk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-medium <?php echo ($navAktif === 'user') ? 'active' : ''; ?>"
                   href="dashboardadmin.php?page=user">
                    <i class="bi bi-people me-1"></i>Daftar User
                </a>
            </li>
        </ul>
    </div>

    <!-- Konten -->
    <div class="glass-card p-4 p-md-5">
        <?php
        switch ($page) {
            case 'transaksi':
                include __DIR__ . '/Pages/admin/transaksi.php';
                break;
            case 'produk':
                include __DIR__ . '/Pages/admin/produk.php';
                break;
            case 'tambahproduk':
                include __DIR__ . '/Pages/admin/produk_add.php';
                break;
            case 'editproduk':
                include __DIR__ . '/Pages/admin/produk_edit.php';
                break;
            case 'hapusproduk':
                include __DIR__ . '/Pages/admin/produk_delete.php';
                break;
            case 'user':
                include __DIR__ . '/Pages/admin/user.php';
                break;
            case 'edituser':
                include __DIR__ . '/Pages/admin/user_edit.php';
                break;
            case 'hapususer':
                include __DIR__ . '/Pages/admin/user_delete.php';
                break;
            default:
                include __DIR__ . '/Pages/admin/transaksi.php';
                break;
        }
        ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
