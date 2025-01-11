<?php
// Autoloader manual untuk Endroid QR Code
spl_autoload_register(function ($class) {
    // Tentukan prefix namespace dan file path
    $prefix = 'Endroid\\QrCode\\';
    $base_dir = __DIR__ . '/';  // Gunakan direktori utama karena tidak ada folder

    // Cek apakah class berada dalam namespace yang sesuai
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Ambil class relatif tanpa namespace
    $relative_class = substr($class, $len);

    // Tentukan path ke file
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Jika file ditemukan, load
    if (file_exists($file)) {
        require $file;
    }
});
