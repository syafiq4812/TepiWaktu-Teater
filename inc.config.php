<?php
/**
 * Loader konfigurasi rahasia.
 * Mengembalikan array konfigurasi dari config.php (yang di-gitignore).
 */
function app_config($key = null)
{
    static $config = null;

    if ($config === null) {
        $configFile = dirname(__FILE__) . '/config.php';

        if (!file_exists($configFile)) {
            // Jika config.php belum dibuat, pakai nilai aman dari template.
            $configFile = dirname(__FILE__) . '/config.example.php';
        }

        $config = require $configFile;
    }

    if ($key === null) {
        return $config;
    }

    return isset($config[$key]) ? $config[$key] : null;
}
