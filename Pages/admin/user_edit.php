<?php
// Proteksi: pastikan ID tersedia
if (!isset($_GET['id'])) {
    echo "<script>alert('ID User tidak ditemukan!'); window.location='dashboardadmin.php?page=user';</script>";
    exit;
}

$id_user = (int) $_GET['id'];
$result = $objUser->GetUserByID($id_user);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('User tidak ditemukan!'); window.location='dashboardadmin.php?page=user';</script>";
    exit;
}

// Proses simpan edit
if (isset($_POST['btnSimpanEdit'])) {
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role  = $_POST['role'] ?? '';

    $allowedRoles = ['user', 'employee', 'manager', 'admin'];

    if (strlen($nama) < 2 || strlen($nama) > 30) {
        echo "<script>alert('Nama harus berisi 2-30 karakter.');</script>";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 30) {
        echo "<script>alert('Format email tidak valid (maks 30 karakter).');</script>";
    } else if (!in_array($role, $allowedRoles, true)) {
        echo "<script>alert('Role tidak valid.');</script>";
    } else {
        $update = $objUser->UpdateUser($id_user, $nama, $email, $role);

        if ($update) {
            echo "<script>alert('Data user berhasil diperbarui!'); window.location='dashboardadmin.php?page=user';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal memperbarui data user.');</script>";
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <p class="section-eyebrow mb-1">Pengguna</p>
        <h5 class="fw-bold mb-0" style="font-family: var(--font-display);">
            <i class="bi bi-pencil-square me-1"></i>Edit Data User
        </h5>
    </div>
    <a href="dashboardadmin.php?page=user" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card p-4 p-md-5">
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" maxlength="30"
                       value="<?php echo htmlspecialchars($data['name']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" class="form-control" name="email" maxlength="30"
                       value="<?php echo htmlspecialchars($data['email']); ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label">Hak Akses (Role)</label>
                <select class="form-select" name="role" required>
                    <option value="user" <?php echo ($data['role'] == 'user') ? 'selected' : ''; ?>>User (Customer)</option>
                    <option value="employee" <?php echo ($data['role'] == 'employee') ? 'selected' : ''; ?>>Employee</option>
                    <option value="manager" <?php echo ($data['role'] == 'manager') ? 'selected' : ''; ?>>Manager</option>
                    <option value="admin" <?php echo ($data['role'] == 'admin') ? 'selected' : ''; ?>>Admin (Super User)</option>
                </select>
            </div>
        </div>

        <div class="text-end">
            <a href="dashboardadmin.php?page=user" class="btn btn-ghost px-4 me-2">Batal</a>
            <button type="submit" name="btnSimpanEdit" class="btn btn-gold px-4">
                <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>
