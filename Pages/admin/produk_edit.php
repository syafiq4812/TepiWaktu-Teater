<?php
// Proteksi: Pastikan ID Produk tersedia di URL
if (!isset($_GET['id'])) {
    echo "<script>alert('ID Produk tidak ditemukan!'); window.location='dashboardadmin.php?page=produk';</script>";
    exit;
}

$id_produk = $_GET['id'];
$result = $objProd->GetProdukByID($id_produk);
$data = mysqli_fetch_assoc($result);

// Logic Proses Simpan Edit
if (isset($_POST['btnSimpanEdit'])) {
    $nama     = $_POST['nama_acara'];
    $kategori = $_POST['kategori'];
    $desk     = $_POST['deskripsi'];
    $harga    = $_POST['harga'];
    $tgl      = $_POST['tanggal'];
    $waktu    = $_POST['waktu'];
    
    // Cek upload gambar poster baru
    $posterBaru = null;
    $uploadDitolak = false;

    if (isset($_FILES['poster']['name']) && $_FILES['poster']['name'] != "") {
        // --- Validasi file upload ---
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $allowed_mime = ['image/jpeg', 'image/png', 'image/webp'];

        $file_name = $_FILES['poster']['name'];
        $tmp       = $_FILES['poster']['tmp_name'];
        $ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $mime      = mime_content_type($tmp);

        if (!in_array($ext, $allowed_ext) || !in_array($mime, $allowed_mime)) {
            $uploadDitolak = true;
            echo "<script>alert('File poster harus berupa gambar (JPG, PNG, atau WEBP)!');</script>";
        } else if ($_FILES['poster']['size'] > 2 * 1024 * 1024) {
            $uploadDitolak = true;
            echo "<script>alert('Ukuran gambar maksimal 2 MB!');</script>";
        } else {
            $posterBaru = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($file_name));
            move_uploaded_file($tmp, dirname(__FILE__) . '/../../img/' . $posterBaru);
        }
    }

    // Jangan update data jika upload ditolak
    if (!$uploadDitolak) {
        $update = $objProd->UpdateProduk($id_produk, $nama, $kategori, $desk, $harga, $tgl, $waktu, $posterBaru);
        if ($update) {
            echo "<script>alert('Data pertunjukan berhasil diperbarui!'); window.location='dashboardadmin.php?page=produk';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal memperbarui data.');</script>";
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <p class="section-eyebrow mb-1">Katalog</p>
        <h5 class="fw-bold mb-0" style="font-family: var(--font-display);">
            <i class="bi bi-pencil-square me-1"></i>Edit Data Pertunjukan
        </h5>
    </div>
    <a href="dashboardadmin.php?page=produk" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card p-4 p-md-5">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label">Nama Acara / Pertunjukan</label>
                <input type="text" class="form-control" name="nama_acara" maxlength="100"
                       value="<?php echo htmlspecialchars($data['nama_acara']); ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Kategori</label>
                <select class="form-select" name="kategori" required>
                    <option value="Teater" <?php echo ($data['kategori'] == 'Teater') ? 'selected' : ''; ?>>Teater</option>
                    <option value="Konser" <?php echo ($data['kategori'] == 'Konser') ? 'selected' : ''; ?>>Konser</option>
                    <option value="Drama" <?php echo ($data['kategori'] == 'Drama') ? 'selected' : ''; ?>>Drama</option>
                    <option value="Musical" <?php echo ($data['kategori'] == 'Musical') ? 'selected' : ''; ?>>Musical</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Harga Satuan (Rp)</label>
                <input type="number" class="form-control" name="harga" min="0"
                       value="<?php echo (int) $data['harga']; ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jadwal Tanggal</label>
                <input type="date" class="form-control" name="tanggal"
                       value="<?php echo htmlspecialchars($data['tanggal']); ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Waktu / Jam Main</label>
                <input type="time" class="form-control" name="waktu"
                       value="<?php echo htmlspecialchars($data['waktu']); ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Poster Saat Ini: <span class="text-accent"><?php echo htmlspecialchars($data['poster']); ?></span></label>
            <input type="file" class="form-control" name="poster" accept="image/jpeg,image/png,image/webp">
            <div class="form-text text-secondary">Kosongkan jika tidak ingin memperbarui poster. Format: JPG/PNG/WEBP, maks 2 MB.</div>
        </div>
        <div class="mb-4">
            <label class="form-label">Deskripsi Acara</label>
            <textarea class="form-control" name="deskripsi" rows="4" maxlength="2000" required><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
        </div>
        <div class="text-end">
            <a href="dashboardadmin.php?page=produk" class="btn btn-ghost px-4 me-2">Batal</a>
            <button type="submit" name="btnSimpanEdit" class="btn btn-gold px-4">
                <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>