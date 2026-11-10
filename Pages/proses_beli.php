<?php
// Pastikan session sudah dimulai jika menggunakan $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../inc.config.php';
require_once __DIR__ . '/../Class/class.Produk.php';
require_once __DIR__ . '/../Class/class.Transaction.php';

// Konfigurasi Midtrans dari config.php (jangan hardcode key di sini)
\Midtrans\Config::$serverKey = app_config('midtrans_server_key');
\Midtrans\Config::$isProduction = (bool) app_config('midtrans_is_production');
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Pastikan user sudah login
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='Main.php?Pages=login';</script>";
    exit;
}

// Pastikan tombol beli sudah diklik
if (isset($_POST['btnBeli'])) {
    $userid    = (int) $_SESSION['userid'];
    $id_produk = (int) ($_POST['id_produk'] ?? 0);
    $jumlah    = (int) ($_POST['jumlah_tiket'] ?? 1);

    // Validasi jumlah tiket (batas 1-10 sesuai form)
    if ($jumlah < 1 || $jumlah > 10) {
        echo "<script>alert('Jumlah tiket harus antara 1 sampai 10.'); window.history.back();</script>";
        exit;
    }

    // Metode default; nanti diganti oleh webhook sesuai metode asli dari Midtrans
    $metode = "Midtrans Gateway";
    $status = "pending";

    $objProduk  = new Produk();
    $objTrans   = new Transaction();

    // Ambil harga dari database (bukan dari input user!)
    $res_price = $objProduk->GetProdukByID($id_produk);
    $data_price = mysqli_fetch_assoc($res_price);

    if (!$data_price) {
        echo "<script>alert('Produk tidak ditemukan!'); window.location='Main.php?Pages=Produk';</script>";
        exit;
    }

    $total_harga = (int) $data_price['harga'] * $jumlah;

    // Simpan transaksi dulu dengan status pending
    $simpan = $objTrans->CreateTransaction($userid, $id_produk, $jumlah, $total_harga, $metode, $status);

    if ($simpan) {
        $transaction_id = $objTrans->getLastInsertId();

        // Jadikan transaction_id sebagai order_id Midtrans (unik & sinkron)
        $order_id_midtrans = "TKT-" . $transaction_id;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order_id_midtrans,
                'gross_amount' => $total_harga,
            ),
            'customer_details' => array(
                'first_name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
            ),
        );

        try {
            // Request Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $clientKey = htmlspecialchars(app_config('midtrans_client_key'), ENT_QUOTES);
            ?>
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Menunggu Pembayaran...</title>
                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $clientKey; ?>"></script>
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; background: #0b1220; color: #fff; }
                    .btn-pay { padding: 12px 24px; font-size: 16px; cursor: pointer; background-color: #007bff; color: white; border: none; border-radius: 5px; }
                </style>
            </head>
            <body>
                <h2>Sedang memproses pembayaran...</h2>
                <p>Klik tombol di bawah ini jika pop-up pembayaran tidak muncul secara otomatis.</p>
                <button id="pay-button" class="btn-pay">Bayar Sekarang</button>

                <script type="text/javascript">
                    document.getElementById('pay-button').onclick = function(){
                        snap.pay('<?php echo htmlspecialchars($snapToken, ENT_QUOTES); ?>', {
                            onSuccess: function(result){
                                window.location.href = 'Main.php?Pages=riwayat&status=success';
                            },
                            onPending: function(result){
                                window.location.href = 'Main.php?Pages=riwayat&status=pending';
                            },
                            onError: function(result){
                                alert("Pembayaran gagal!");
                                window.location.href = 'Main.php?Pages=riwayat';
                            },
                            onClose: function(){
                                alert('Anda menutup pop-up sebelum menyelesaikan pembayaran.');
                            }
                        });
                    };

                    window.onload = function() {
                        document.getElementById('pay-button').click();
                    }
                </script>
            </body>
            </html>
            <?php
            exit;

        } catch (Exception $e) {
            echo "<script>alert('Gagal terhubung ke Midtrans.'); window.history.back();</script>";
        }

    } else {
        echo "<script>alert('Gagal menyimpan pesanan.'); window.history.back();</script>";
    }
} else {
    // Akses langsung tanpa form -> kembali ke katalog
    header('Location: Main.php?Pages=Produk');
    exit;
}
