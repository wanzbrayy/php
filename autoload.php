<?php
// Fungsi autoloader sederhana untuk memuat class secara otomatis
spl_autoload_register(function ($class) {
    // Konversi namespace menjadi path file
    $classPath = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    // Periksa apakah file class ada
    if (file_exists($classPath)) {
        require_once $classPath;
    } else {
        die("Class file for '{$class}' not found at '{$classPath}'.");
    }
});

// Memuat file functions.php
if (file_exists(__DIR__ . '/functions.php')) {
    include_once __DIR__ . '/functions.php';
} else {
    die('functions.php not found. Please make sure the file exists.');
}

// Memuat file endroid-qr-code.php
if (file_exists(__DIR__ . '/endroid-qr-code.php')) {
    include_once __DIR__ . '/endroid-qr-code.php';
} else {
    die('endroid-qr-code.php not found. Please make sure the file exists.');
}
