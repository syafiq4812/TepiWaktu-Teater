<?php
// Terima notifikasi pembayaran dari Midtrans
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../inc.config.php';
require_once dirname(__FILE__) . '/../inc.koneksi.php';
require_once dirname(__FILE__) . '/../Class/class.Transaction.php';
require_once dirname(__FILE__) . '/../Class/class.Mail.php';

// Konfigurasi Midtrans dari config.php
\Midtrans\Config::$serverKey = app_config('midtrans_server_key');
\Midtrans\Config::$isProduction = (bool) app_config('midtrans_is_production');

// 1. Terima notifikasi dari Midtrans
try {
    $notif = new \Midtrans\Notification();
} catch (\Exception $e) {
    exit($e->getMessage());
}

$transaction_status = $notif->transaction_status;
$payment_type       = $notif->payment_type;
$order_id           = $notif->order_id; // Bentuknya "TKT-15"

// 2. Ambil angka ID transaksi dari order_id (hapus prefix "TKT-")
$id_transaksi_db = (int) str_replace('TKT-', '', $order_id);

// 3. Tentukan status untuk database kita
$status_db = 'pending';
if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
    $status_db = 'success'; // LUNAS
} else if ($transaction_status == 'cancel' || $transaction_status == 'deny' || $transaction_status == 'expire') {
    $status_db = 'failed'; // GAGAL/BATAL
} else if ($transaction_status == 'pending') {
    $status_db = 'pending'; // BELUM DIBAYAR
}

// 4. Update database (pakai prepared statement dari class Transaction)
$objTrans = new Transaction();
$objTrans->UpdateStatus($id_transaksi_db, $status_db, $payment_type);

// 5. Jika LUNAS, kirim email e-ticket
if ($status_db == 'success') {

    // Logging sederhana ke folder Pages (sudah masuk .gitignore)
    $log_file = dirname(__FILE__) . '/log_email_webhook.txt';
    file_put_contents($log_file, "[" . date('Y-m-d H:i:s') . "] Memulai proses kirim email untuk ID: $id_transaksi_db \n", FILE_APPEND);

    $res_detail = $objTrans->GetDetail($id_transaksi_db);

    if ($res_detail && mysqli_num_rows($res_detail) > 0) {
        $data_pesanan = mysqli_fetch_assoc($res_detail);

        $email_pembeli = $data_pesanan['email'];
        $nama_pembeli  = $data_pesanan['name'];
        $jumlah        = $data_pesanan['jumlah'];
        $total_harga   = $data_pesanan['total_harga'];
        $nama_acara    = $data_pesanan['nama_acara'];

        file_put_contents($log_file, "Data ditemukan. Mencoba kirim ke email: $email_pembeli \n", FILE_APPEND);

        $message = "
        <html>
        <body>
            <h2>Pembayaran Tiket Berhasil!</h2>
            <p>Halo <b>" . htmlspecialchars($nama_pembeli) . "</b>,</p>
            <p>Terima kasih, pembayaran tiket acara <b>" . htmlspecialchars($nama_acara) . "</b> telah kami terima.</p>
            <table border='0' cellpadding='8'>
                <tr><td><b>Nama Acara</b></td><td>: " . htmlspecialchars($nama_acara) . "</td></tr>
                <tr><td><b>Jumlah Tiket</b></td><td>: " . (int) $jumlah . "</td></tr>
                <tr><td><b>Total Harga</b></td><td>: Rp " . number_format($total_harga, 0, ',', '.') . "</td></tr>
                <tr><td><b>Metode Bayar</b></td><td>: " . htmlspecialchars($payment_type) . "</td></tr>
            </table>
            <br>
            <p>Simpan email ini sebagai bukti E-Ticket Anda untuk ditukarkan di loket pementasan.</p>
            <hr>
            <small>Tepi Waktu Teater</small>
        </body>
        </html>
        ";

        try {
            Mail::SendMail($email_pembeli, $nama_pembeli, 'E-Ticket Teater: Lunas', $message);
            file_put_contents($log_file, "SUKSES: Email berhasil dikirim!\n\n", FILE_APPEND);
        } catch (Exception $e) {
            file_put_contents($log_file, "GAGAL KIRIM EMAIL: " . $e->getMessage() . "\n\n", FILE_APPEND);
        }

    } else {
        file_put_contents($log_file, "GAGAL: Data transaksi tidak ditemukan atau kosong saat di-JOIN.\n\n", FILE_APPEND);
    }
}
