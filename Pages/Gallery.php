<div class="container py-4">

    <div class="text-center mb-5">
        <p class="section-eyebrow mb-2">Dokumentasi</p>
        <h2 class="section-title display-4 mb-3">Gallery Teater Tepi Waktu</h2>
        <p class="text-secondary mx-auto" style="max-width: 600px;">
            Potongan momen dari balik layar hingga panggung utama.
        </p>
    </div>

    <?php
    // Data kutipan + gambar (sinkron dengan file di folder img/)
    $galeri = [
        ['foto1.JPG', 'Keringat di ruang latihan adalah bayaran mahal untuk tepuk tangan di atas panggung.'],
        ['foto2.JPG', 'Bukan tentang menghafal naskah, tapi bagaimana naskah itu hidup di dalam diri kita.'],
        ['foto3.JPG', 'Satu panggung, puluhan ego, disatukan oleh satu cerita.'],
        ['foto4.JPG', 'Cahaya lampu panggung tak akan terang tanpa kerja keras dalam gelapnya backstage.'],
        ['foto5.JPG', 'Setiap karakter punya rahasia, tugas kitalah untuk membongkarnya di depan penonton.'],
        ['foto6.JPG', 'Wajah baru di depan cermin, jiwa lama yang siap meresapi peran.'],
        ['foto7.JPG', 'Setiap arahan adalah jembatan antara imajinasi dan realitas panggung.'],
        ['foto8.JPG', 'Keheningan di balik panggung sebelum tirai terbuka adalah musik yang paling mendebarkan.'],
        ['foto9.JPG', 'Bukan tentang siapa yang paling bersinar, tapi bagaimana kita saling menerangi.'],
    ];

    foreach ($galeri as $index => $item):
        $foto = $item[0];
        $kutipan = $item[1];
        $balik = ($index % 2 === 1); // baris genap dibalik
    ?>
    <div class="row align-items-stretch g-0 mb-4 gallery-row <?php echo $balik ? 'flex-row-reverse' : ''; ?>"
         style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-subtle); min-height: 320px;">

        <!-- Sisi kutipan -->
        <div class="col-lg-6 d-flex align-items-center p-4 p-md-5"
             style="background: linear-gradient(135deg, rgba(11,61,145,0.55), rgba(10,14,23,0.9));">
            <div class="<?php echo $balik ? 'text-md-end' : ''; ?>">
                <i class="bi bi-quote fs-1 text-accent d-block mb-2" style="opacity: 0.7;"></i>
                <h3 class="fw-bold mb-3" style="font-family: var(--font-display); font-style: italic; line-height: 1.4; font-size: 1.5rem;">
                    &ldquo;<?php echo htmlspecialchars($kutipan); ?>&rdquo;
                </h3>
                <p class="mb-0 small text-uppercase text-secondary" style="letter-spacing: 2px;">&mdash; Tepi Waktu Teater</p>
            </div>
        </div>

        <!-- Sisi gambar -->
        <div class="col-lg-6">
            <div class="img-wrapper h-100" style="border-radius: 0;">
                <img src="img/<?php echo htmlspecialchars($foto); ?>"
                     class="w-100 h-100 img-interactive"
                     style="object-fit: cover; min-height: 320px;"
                     alt="Dokumentasi <?php echo $index + 1; ?>"
                     loading="lazy">
            </div>
        </div>

    </div>
    <?php endforeach; ?>

    <div class="text-center mt-5">
        <a href="Main.php?Pages=Produk" class="btn btn-gold px-5">Lihat Jadwal Pertunjukan</a>
    </div>

</div>
