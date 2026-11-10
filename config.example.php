<?php
/**
 * ============================================================
 *  TEMPLATE KONFIGURASI — Salin file ini menjadi config.php
 * ============================================================
 *  1. Copy file ini:  copy config.example.php config.php
 *  2. Isi nilai-nilai di bawah dengan data milik Anda.
 *  3. File config.php TIDAK di-commit (sudah masuk .gitignore).
 * ============================================================
 */

return [
    // --- Database (MySQL/MariaDB) ---
    'db_host'     => 'localhost',
    'db_user'     => 'root',
    'db_password' => '',
    'db_name'     => 'company',

    // --- SMTP (pengiriman email) ---
    // NOTE: Gunakan App Password Google, BUKAN password akun biasa.
    'smtp_host'       => 'smtp.gmail.com',
    'smtp_port'       => 587,
    'smtp_username'   => 'your-email@gmail.com',
    'smtp_password'   => 'xxxx xxxx xxxx xxxx',
    'smtp_from_email' => 'your-email@gmail.com',
    'smtp_from_name'  => 'TEPI WAKTU PRODUCTION',

    // --- Midtrans (payment gateway) ---
    // Dapatkan di https://dashboard.midtrans.com/ -> Settings -> Access Keys
    'midtrans_server_key' => 'YOUR_SERVER_KEY',
    'midtrans_client_key' => 'YOUR_CLIENT_KEY',
    'midtrans_is_production' => false,
];
