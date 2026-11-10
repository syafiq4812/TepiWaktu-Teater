<?php
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];
    
    // Mencegah admin menghapus dirinya sendiri
    if ($id_user == $_SESSION['userid']) {
        echo "<script>alert('Error: Anda tidak dapat menghapus akun Anda sendiri saat sedang login!'); window.location='dashboardadmin.php?page=user';</script>";
        exit;
    }

    // Pastikan method DeleteUser ada di class.User.php kamu
    $delete = $objUser->DeleteUser($id_user);
    
    if ($delete) {
        echo "<script>alert('Data user berhasil dihapus!'); window.location='dashboardadmin.php?page=user';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data user.'); window.location='dashboardadmin.php?page=user';</script>";
    }
} else {
    echo "<script>window.location='dashboardadmin.php?page=user';</script>";
}
?>