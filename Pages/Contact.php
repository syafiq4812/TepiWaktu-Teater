<div class="container py-4">
    <div class="text-center mb-5">
        <p class="section-eyebrow mb-2">Hubungi Kami</p>
        <h2 class="section-title display-4 mb-3">Contact</h2>
        <p class="text-secondary mx-auto" style="max-width: 560px;">
            Ada pertanyaan seputar tiket atau pertunjukan? Kami siap membantu Anda.
        </p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Informasi Kontak -->
        <div class="col-lg-5">
            <div class="card p-4 h-100">
                <h5 class="fw-bold mb-4" style="font-family: var(--font-display);">Informasi Kontak</h5>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center"
                         style="width: 46px; height: 46px; border-radius: 12px; background: rgba(245,185,66,0.12); color: var(--accent);">
                        <i class="bi bi-envelope fs-5"></i>
                    </div>
                    <div>
                        <small class="text-secondary d-block text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">Email</small>
                        <span class="fw-semibold">tepiwaktu@uag.ac.id</span>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center"
                         style="width: 46px; height: 46px; border-radius: 12px; background: rgba(56,189,248,0.12); color: var(--info);">
                        <i class="bi bi-telephone fs-5"></i>
                    </div>
                    <div>
                        <small class="text-secondary d-block text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">Telepon</small>
                        <span class="fw-semibold">(021) 7590-1650</span>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center"
                         style="width: 46px; height: 46px; border-radius: 12px; background: rgba(52,211,153,0.12); color: var(--success);">
                        <i class="bi bi-instagram fs-5"></i>
                    </div>
                    <div>
                        <small class="text-secondary d-block text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">Instagram</small>
                        <span class="fw-semibold">@tepiwaktu.teater</span>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="flex-shrink-0 me-3 d-flex align-items-center justify-content-center"
                         style="width: 46px; height: 46px; border-radius: 12px; background: rgba(248,113,113,0.12); color: var(--danger);">
                        <i class="bi bi-geo-alt fs-5"></i>
                    </div>
                    <div>
                        <small class="text-secondary d-block text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">Alamat</small>
                        <span class="fw-semibold">Menara 165, Jl. Simatupang,<br>Jakarta Selatan</span>
                    </div>
                </div>

                <hr class="border-secondary opacity-25 mt-4">

                <p class="small text-secondary mb-0" style="line-height: 1.7;">
                    <i class="bi bi-clock me-1"></i> Jam operasional: Senin &ndash; Jumat, 09.00 &ndash; 17.00 WIB
                </p>
            </div>
        </div>

        <!-- Form Pesan -->
        <div class="col-lg-7">
            <div class="card p-4 p-md-5 h-100">
                <h5 class="fw-bold mb-4" style="font-family: var(--font-display);">Kirim Pesan</h5>

                <?php
                // Penanganan form ( simulasi: tampilkan konfirmasi )
                if (isset($_POST['btnKirim'])) {
                    $nama   = trim($_POST['nama'] ?? '');
                    $email  = trim($_POST['email'] ?? '');
                    $pesan  = trim($_POST['pesan'] ?? '');

                    if ($nama === '' || $email === '' || $pesan === '') {
                        echo '<div class="alert alert-warning">Semua field wajib diisi.</div>';
                    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo '<div class="alert alert-warning">Format email tidak valid.</div>';
                    } else {
                        echo '<div class="alert alert-success"><i class="bi bi-check-circle me-1"></i>Terima kasih, pesan Anda sudah kami terima. Tim kami akan menghubungi Anda segera.</div>';
                    }
                }
                ?>

                <form action="Main.php?Pages=Contact" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Anda" maxlength="50" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" maxlength="50" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" class="form-control" rows="5" maxlength="1000" placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="btnKirim" class="btn btn-gold px-5">
                            <i class="bi bi-send me-2"></i>Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
