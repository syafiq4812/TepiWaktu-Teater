<?php
// Proteksi: Pastikan ID tersedia
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $delete = $objProd->DeleteProduk($id_produk);
    
    if ($delete) {
        echo "<script>alert('Pertunjukan berhasil dihapus!'); window.location='dashboardadmin.php?page=produk';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.'); window.location='dashboardadmin.php?page=produk';</script>";
    }
} else {
    // Jika diakses tanpa parameter id
    echo "<script>window.location='dashboardadmin.php?page=produk';</script>";
}
?>