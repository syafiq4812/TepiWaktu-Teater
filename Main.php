


<?php
// Memulai session di awal sebelum ada output HTML apa pun
if (!isset($_SESSION)) {
    session_start();
}

// Memanggil header yang berisi <head>, <nav>, dan pembuka <main>
include "header.php"; 

// Memanggil koneksi database
include "inc.koneksi.php"; 
?>

<div class="content-wrapper py-4">
    <?php
    // Logika sistem dinamis menggunakan parameter URL (Routing sederhana)
    if (isset($_GET['Pages'])) {
        $page = $_GET['Pages'];

        switch ($page) {
            case 'Home':
                include "Pages/Home.php";
                break;
            case 'About':
                include "Pages/About.php";
                break;
            case 'Gallery':
                include "Pages/Gallery.php";
                break;
            case 'Produk':
                include "Pages/Produk.php";
                break;
            case 'proses_beli':
                include "Pages/proses_beli.php";
                break;
            

            // --- Fitur User & Profil ---
            case 'profile':
                include "Pages/profile.php";
                break;
            case 'ticket':
                include "Pages/ticket_transaction.php";
                break;
            case 'riwayat':
                include "Pages/riwayat.php";
                break;
            
            // --- Autentikasi ---
            case 'register':
                include "Pages/register.php";
                break;
            case 'login':
                include "Pages/login.php";
                break;
            
            // Logika Keluar Akun
            case 'logout':
                session_destroy();
                echo "<script>alert('Berhasil Logout'); window.location='Main.php?Pages=Home';</script>";
                break;

            // --- Dashboard Khusus ---
            case 'dashboardemployee':
                include "dashboardemployee.php";
                break;
            case 'dashboardAdmin':
                include "dashboardadmin.php";
                break;

            case 'Contact':
                include "Pages/Contact.php";
                break;

            // Halaman jika parameter Pages tidak dikenal
            default:
                echo "
                <div class='container mt-5'>
                    <div class='alert alert-danger text-center shadow border-0'>
                        <h3 class='fw-bold'>404 Not Found</h3>
                        <p class='mb-0'>Maaf, halaman yang Anda cari tidak tersedia di Tepi Waktu Teater.</p>
                        <a href='Main.php?Pages=Home' class='btn btn-outline-danger btn-sm mt-3'>Kembali ke Home</a>
                    </div>
                </div>";
                break;
        }
    } else {
        // Jika tidak ada parameter Pages di URL, tampilkan Home secara default
        include "Pages/Home.php";
    }
    ?>
</div>




<?php
// Memanggil footer yang berisi <footer>, penutup </main>, dan Bootstrap JS
include "footer.php"; 
?>