<?php
// Memuat autoload.php yang berfungsi untuk autoload class dan file lainnya
require_once __DIR__ . '/autoload.php';
  // Pastikan autoload.php berada di lokasi yang benar

// Memuat functions.php untuk menggunakan fungsi-fungsi yang telah didefinisikan
include_once __DIR__ . '/functions.php';  // Pastikan functions.php berada di direktori yang benar

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    // Nomor DANA dan nama yang dituju
    $danaNumber = '0895402567224';
    $name = 'KEPO LOE';

    // Membuat URL DANA untuk pembayaran
    $danaPaymentUrl = "https://link.dana.id/qr/$danaNumber/$amount";  // Pastikan format URL sesuai dengan API DANA

    // Membuat QR Code dari URL DANA
    $qrCode = new QrCode($danaPaymentUrl);
    $writer = new PngWriter();
    $qrCode->setSize(300); // Ukuran QR code
    $image = $writer->write($qrCode);  // Menyimpan gambar QR Code

    // Menyimpan gambar QR ke file
    $qrFilePath = 'qrcode.png';
    file_put_contents($qrFilePath, $image->getString());

    echo "<div class='flex justify-center mt-6'>
            <h2 class='text-lg font-semibold text-center mb-4'>Scan QR Code for Payment</h2>
            <img src='$qrFilePath' alt='QR Code for payment' class='w-64 h-64'>
            <p class='text-center mt-2'>Pay to: $name ($danaNumber)</p>
          </div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal & DANA Integration</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AOS (Animate On Scroll) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

</head>
<body class="bg-gray-100 text-gray-900 font-sans">
    <div x-data="{ open: false }" class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-3xl font-bold text-center text-blue-500 mb-6">DANA Payment Integration</h1>
            <form method="POST" action="" class="space-y-4" @submit="open = true">
                <div>
                    <label for="amount" class="block text-lg font-medium text-gray-700">Amount (IDR):</label>
                    <input type="number" name="amount" id="amount" class="w-full p-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-credit-card"></i> Pay Now
                </button>
            </form>
            <div x-show="open" class="flex justify-center items-center">
                <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full text-blue-600" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        AOS.init();
    </script>
</body>
</html>
