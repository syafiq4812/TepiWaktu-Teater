<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once(__DIR__ . '/../Class/class.user.php');

if (isset($_POST['btnLogin'])) {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid!');</script>";
    } else {
        $objUser = new User();
        $objUser->ValidateEmail($email);

        if ($objUser->hasil) {
            $ismatch = password_verify($password, $objUser->password);

            if ($ismatch) {
                // Regenerate session ID mencegah session fixation
                session_regenerate_id(true);

                $_SESSION['userid'] = $objUser->userid;
                $_SESSION['email']  = $objUser->email;
                $_SESSION['name']   = $objUser->name;
                $_SESSION['role']   = $objUser->role;

                $namaLogin = htmlspecialchars($_SESSION['name'], ENT_QUOTES);
                echo "<script>alert('Login Berhasil! Selamat Datang, $namaLogin');</script>";

                // Redirection berdasarkan role
                if ($_SESSION['role'] == 'admin') {
                    echo "<script>window.location.href = 'dashboardadmin.php';</script>";
                } else if ($_SESSION['role'] == 'employee') {
                    echo "<script>window.location.href = 'Main.php?Pages=Home';</script>";
                } else {
                    echo "<script>window.location.href = 'Main.php?Pages=Home';</script>";
                }

            } else {
                echo "<script>alert('Password Salah!');</script>";
            }
        } else {
            echo "<script>alert('Email Tidak Ditemukan!');</script>";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card glass-card overflow-hidden">
            <div class="text-center p-4 pb-0">
                <p class="section-eyebrow mb-2">Selamat Datang Kembali</p>
                <h3 class="fw-bold" style="font-family: var(--font-display);">Login Akun</h3>
                <p class="text-secondary small mb-0">Masuk untuk memesan tiket pertunjukan</p>
            </div>
            <div class="card-body p-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="btnLogin" class="btn btn-gold py-2 fw-bold">Login</button>
                        <a href="Main.php?Pages=Home" class="btn btn-ghost py-2">Batal</a>
                    </div>
                </form>
            </div>
            <div class="text-center px-4 pb-4">
                <p class="small text-secondary mb-0">Belum punya akun? <a href="Main.php?Pages=register" class="fw-semibold text-decoration-none">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>
</div>
