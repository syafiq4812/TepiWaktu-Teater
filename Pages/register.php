<?php
require_once(__DIR__ . '/../Class/class.user.php');
require_once(__DIR__ . '/../Class/class.Mail.php');

if (isset($_POST['btnSubmit'])) {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // --- Validasi input ---
    $errors = [];

    if (strlen($name) < 2 || strlen($name) > 30) {
        $errors[] = 'Nama harus berisi 2-30 karakter.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 30) {
        $errors[] = 'Format email tidak valid (maks 30 karakter).';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password minimal 8 karakter.';
    }

    if (!empty($errors)) {
        $pesan = implode('\\n', $errors);
        echo "<script>alert('$pesan');</script>";
    } else {
        $objUser = new User();
        $objUser->ValidateEmail($email);

        if ($objUser->hasil) {
            echo "<script>alert('Email sudah terdaftar');</script>";
        } else {
            $objUser->email    = $email;
            $objUser->password = password_hash($password, PASSWORD_DEFAULT);
            $objUser->name     = $name;
            $objUser->role     = 'employee'; // Role default saat registrasi

            $tambah = $objUser->AddUser();

            if ($tambah) {
                // Email konfirmasi TANPA menyertakan password (keamanan akun)
                $message = "
                    <h2>Registrasi Berhasil</h2>
                    <p>Selamat <b>" . htmlspecialchars($name) . "</b>, anda telah terdaftar pada Web <b>TEPI WAKTU PRODUCTION</b>.</p>
                    <p>Berikut informasi akun Anda:</p>
                    <ul>
                        <li>Email: " . htmlspecialchars($email) . "</li>
                    </ul>
                    <p>Silakan login dengan email dan password yang Anda buat saat mendaftar.</p>
                    ";

                try {
                    Mail::SendMail($email, $name, 'Registrasi berhasil', $message);
                } catch (Exception $e) {
                    // Email gagal kirim tidak menggagalkan registrasi
                }

                echo "<script>alert('Registrasi berhasil, Silahkan Login');</script>";
                echo "<script>window.location='Main.php?Pages=login';</script>";
            } else {
                echo "<script>alert('Registrasi gagal, silakan coba lagi.');</script>";
            }
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card glass-card overflow-hidden">
            <div class="text-center p-4 pb-0">
                <p class="section-eyebrow mb-2">Bergabung Bersama Kami</p>
                <h3 class="fw-bold" style="font-family: var(--font-display);">Daftar Akun</h3>
                <p class="text-secondary small mb-0">Lengkapi data untuk bergabung dengan Tepi Waktu</p>
            </div>
            <div class="card-body p-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama Anda" maxlength="30" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="nama@email.com" maxlength="30" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter" minlength="8" required>
                        <div class="form-text text-secondary">Gunakan minimal 8 karakter.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="btnSubmit" class="btn btn-gold py-2 fw-bold">Daftar Sekarang</button>
                        <a href="Main.php?Pages=Home" class="btn btn-ghost py-2">Batal</a>
                    </div>
                </form>
            </div>
            <div class="text-center px-4 pb-4">
                <p class="small text-secondary mb-0">Sudah punya akun? <a href="Main.php?Pages=login" class="fw-semibold text-decoration-none">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>
