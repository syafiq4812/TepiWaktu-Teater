<?php
class Transaction extends Connection {

    private $lastInsertId = 0;

    public function getLastInsertId() {
        return $this->lastInsertId;
    }

    // Admin: Melihat riwayat semua transaksi (JOIN user & produk)
    public function ShowAllTransactions() {
        $sql = "SELECT t.*, p.nama_acara, u.name as nama_pembeli
                FROM transaction t
                JOIN produk_tiket p ON t.id_produk = p.id_produk
                JOIN user u ON t.userid = u.userid
                ORDER BY t.tanggal_transaksi DESC";
        return mysqli_query($this->connection, $sql);
    }

    // User: Melihat riwayat pribadi
    public function GetUserHistory($userid) {
        $userid = (int) $userid;

        $sql = "SELECT t.*, p.nama_acara, p.poster
                FROM transaction t
                JOIN produk_tiket p ON t.id_produk = p.id_produk
                WHERE t.userid = ?
                ORDER BY t.tanggal_transaksi DESC";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $userid);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    // Simpan transaksi baru (status pending), kembalikan transaction_id
    public function CreateTransaction($userid, $id_produk, $jumlah, $total_harga, $metode, $status) {
        $userid    = (int) $userid;
        $id_produk = (int) $id_produk;
        $jumlah    = (int) $jumlah;
        $total_harga = (int) $total_harga;

        $sql = "INSERT INTO transaction (userid, id_produk, jumlah, total_harga, metode_bayar, status)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'iiiiss', $userid, $id_produk, $jumlah, $total_harga, $metode, $status);

        $hasil = mysqli_stmt_execute($stmt);

        if ($hasil) {
            $this->lastInsertId = mysqli_insert_id($this->connection);
        }

        mysqli_stmt_close($stmt);

        return $hasil;
    }

    // Update status pembayaran dari webhook Midtrans
    public function UpdateStatus($transaction_id, $status, $metode_bayar = null) {
        $transaction_id = (int) $transaction_id;

        if ($metode_bayar !== null) {
            $sql = "UPDATE transaction SET status = ?, metode_bayar = ? WHERE transaction_id = ?";
            $stmt = mysqli_prepare($this->connection, $sql);
            mysqli_stmt_bind_param($stmt, 'ssi', $status, $metode_bayar, $transaction_id);
        } else {
            $sql = "UPDATE transaction SET status = ? WHERE transaction_id = ?";
            $stmt = mysqli_prepare($this->connection, $sql);
            mysqli_stmt_bind_param($stmt, 'si', $status, $transaction_id);
        }

        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }

    // Ambil detail transaksi + data pembeli & produk (untuk email e-ticket)
    public function GetDetail($transaction_id) {
        $transaction_id = (int) $transaction_id;

        $sql = "SELECT t.*, u.name, u.email, p.nama_acara
                FROM transaction t
                JOIN user u ON t.userid = u.userid
                JOIN produk_tiket p ON t.id_produk = p.id_produk
                WHERE t.transaction_id = ?";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $transaction_id);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }
}
