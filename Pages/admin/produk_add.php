<?php
// Logic Proses Tambah Data
if (isset($_POST['btnTambah'])) {
    $nama     = $_POST['nama_acara'];
    $kategori = $_POST['kategori'];
    $desk     = $_POST['deskripsi'];
    $harga    = $_POST['harga'];
    $tgl      = $_POST['tanggal'];
    $waktu    = $_POST['waktu'];

    // --- Validasi input ---
    if (empty($nama) || empty($kategori) || empty($desk) || empty($harga) || empty($tgl) || empty($waktu)) {
        echo "<script>alert('Semua field wajib diisi!');</script>";
    } else if (!is_numeric($harga) || $harga < 0) {
        echo "<script>alert('Harga harus berupa angka yang valid!');</script>";
    } else {
        // --- Validasi file upload poster ---
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $allowed_mime = ['image/jpeg', 'image/png', 'image/webp'];

        $file_name = $_FILES['poster']['name'] ?? '';
        $tmp       = $_FILES['poster']['tmp_name'] ?? '';
        $ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $mime      = mime_content_type($tmp);

        if (!in_array($ext, $allowed_ext) || !in_array($mime, $allowed_mime)) {
            echo "<script>alert('File poster harus berupa gambar (JPG, PNG, atau WEBP)!');</script>";
        } else if ($_FILES['poster']['size'] > 2 * 1024 * 1024) {
            echo "<script>alert('Ukuran gambar maksimal 2 MB!');</script>";
        } else {
            // Penanganan file upload (nama unik + tanpa spasi/karakter aneh)
            $poster = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($file_name));

            if (move_uploaded_file($tmp, dirname(__FILE__) . '/../../img/' . $poster)) {
                $insert = $objProd->AddProduk($nama, $kategori, $desk, $harga, $tgl, $waktu, $poster);
                if ($insert) {
                    echo "<script>alert('Pertunjukan baru berhasil ditambahkan!'); window.location='dashboardadmin.php?page=produk';</script>";
                    exit;
                } else {
                    echo "<script>alert('Gagal menyimpan data ke database.');</script>";
                }
            } else {
                echo "<script>alert('Gagal mengunggah berkas gambar poster ke server.');</script>";
            }
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <p class="section-eyebrow mb-1">Katalog</p>
        <h5 class="fw-bold mb-0" style="font-family: var(--font-display);">+ Tambah Pertunjukan Baru</h5>
    </div>
    <a href="dashboardadmin.php?page=produk" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card p-4 p-md-5">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-3 col-md-8">
                <label class="form-label">Nama Acara / Pertunjukan</label>
                <input type="text" class="form-control" name="nama_acara" maxlength="100" placeholder="Masukkan nama acara..." required>
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Kategori Event</label>
                <select class="form-select" name="kategori" required>
                    <option value="" disabled selected>Pilih Kategori...</option>
                    <option value="Teater">Teater</option>
                    <option value="Konser">Konser</option>
                    <option value="Drama">Drama</option>
                    <option value="Musical">Musical</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Harga Satuan (Rp)</label>
                <input type="number" class="form-control" name="harga" min="0" placeholder="Contoh: 150000" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jadwal Tanggal</label>
                <input type="date" class="form-control" name="tanggal" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Waktu / Jam Pertunjukan</label>
                <input type="time" class="form-control" name="waktu" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Poster Tiket</label>
            <input type="file" class="form-control" name="poster" accept="image/jpeg,image/png,image/webp" required>
            <div class="form-text text-secondary">Format: JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
        </div>
        <div class="mb-4">
            <label class="form-label">Deskripsi Acara</label>
            <textarea class="form-control" name="deskripsi" rows="4" maxlength="2000" placeholder="Tulis deskripsi atau sinopsis pertunjukan di sini..." required></textarea>
        </div>
        <div class="text-end">
            <a href="dashboardadmin.php?page=produk" class="btn btn-ghost px-4 me-2">Batal</a>
            <button type="submit" name="btnTambah" class="btn btn-gold px-4">
                <i class="bi bi-plus-lg me-1"></i>Tambah Produk
            </button>
        </div>
    </form>
</div>