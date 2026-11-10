<?php
class Produk extends Connection {

    public function ShowAllProduk() {
        $sql = "SELECT * FROM produk_tiket ORDER BY tanggal ASC";
        return mysqli_query($this->connection, $sql);
    }

    public function GetProdukByID($id) {
        $id = (int) $id;

        $sql = "SELECT * FROM produk_tiket WHERE id_produk = ?";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    // Update produk: mendukung Kategori, Waktu, dan Poster opsional
    public function UpdateProduk($id, $nama, $kategori, $deskripsi, $harga, $tanggal, $waktu, $poster = null) {
        $id = (int) $id;
        $harga = (int) $harga;

        if ($poster) {
            // Jika admin mengupload gambar poster baru
            $sql = "UPDATE produk_tiket
                    SET nama_acara = ?, kategori = ?, deskripsi = ?,
                        harga = ?, tanggal = ?, waktu = ?, poster = ?
                    WHERE id_produk = ?";
            $stmt = mysqli_prepare($this->connection, $sql);
            mysqli_stmt_bind_param($stmt, 'sssisssi', $nama, $kategori, $deskripsi, $harga, $tanggal, $waktu, $poster, $id);
        } else {
            // Jika admin tidak mengupload poster baru (pakai poster lama)
            $sql = "UPDATE produk_tiket
                    SET nama_acara = ?, kategori = ?, deskripsi = ?,
                        harga = ?, tanggal = ?, waktu = ?
                    WHERE id_produk = ?";
            $stmt = mysqli_prepare($this->connection, $sql);
            mysqli_stmt_bind_param($stmt, 'sssissi', $nama, $kategori, $deskripsi, $harga, $tanggal, $waktu, $id);
        }

        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }

    public function AddProduk($nama, $kategori, $deskripsi, $harga, $tanggal, $waktu, $poster) {
        $harga = (int) $harga;

        $sql = "INSERT INTO produk_tiket (nama_acara, kategori, deskripsi, harga, tanggal, waktu, poster)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'sssisss', $nama, $kategori, $deskripsi, $harga, $tanggal, $waktu, $poster);

        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }

    public function DeleteProduk($id) {
        $id = (int) $id;

        $sql = "DELETE FROM produk_tiket WHERE id_produk = ?";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);

        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }
}
