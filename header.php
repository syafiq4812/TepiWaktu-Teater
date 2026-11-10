<?php
if (!isset($_SESSION)) {
    session_start();
}

// Tentukan halaman aktif untuk highlight menu
$halamanAktif = $_GET['Pages'] ?? 'Home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tepi Waktu Teater</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Design system terpusat -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Navigasi Utama -->
<nav class="navbar navbar-expand-lg site-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="Main.php?Pages=Home">Tepi Waktu<span class="brand-dot">.</span></a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <!-- Menu Utama -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($halamanAktif === 'Home') ? 'active' : ''; ?>" href="Main.php?Pages=Home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($halamanAktif === 'Produk') ? 'active' : ''; ?>" href="Main.php?Pages=Produk">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($halamanAktif === 'Gallery') ? 'active' : ''; ?>" href="Main.php?Pages=Gallery">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($halamanAktif === 'About') ? 'active' : ''; ?>" href="Main.php?Pages=About">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($halamanAktif === 'Contact') ? 'active' : ''; ?>" href="Main.php?Pages=Contact">Contact</a>
                </li>
            </ul>

            <!-- Autentikasi & Profil -->
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['role'])): ?>
                    <!-- Sudah login: dropdown avatar -->
                    <div class="dropdown user-dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar me-2">
                                <?php echo htmlspecialchars(strtoupper(substr($_SESSION['name'], 0, 1))); ?>
                            </div>
                            <span class="d-none d-lg-inline text-white"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="Main.php?Pages=profile">Profil Saya</a></li>
                            <li><a class="dropdown-item" href="Main.php?Pages=riwayat">Riwayat Tiket</a></li>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="dashboardadmin.php">Admin Dashboard</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-bold" href="Main.php?Pages=logout">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Belum login -->
                    <a href="Main.php?Pages=register" class="btn btn-ghost btn-sm me-2">Daftar</a>
                    <a href="Main.php?Pages=login" class="btn btn-gold btn-sm px-4">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Pembuka konten utama -->
<main>
