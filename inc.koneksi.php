<?php

require_once dirname(__FILE__) . '/inc.config.php';

class Connection
{
    public $connection;

    function __construct()
    {
        $host = app_config('db_host');
        $user = app_config('db_user');
        $pass = app_config('db_password');
        $name = app_config('db_name');

        $conn = new mysqli($host, $user, $pass);

        if ($conn->connect_error) {
            die("Koneksi database gagal: " . htmlspecialchars($conn->connect_error));
        }

        mysqli_select_db($conn, $name);

        // Pakai UTF-8 supaya karakter Indonesia/emoji aman
        mysqli_set_charset($conn, 'utf8mb4');

        $this->connection = $conn;
    }
}
