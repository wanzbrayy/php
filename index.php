<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/endroid-qr-code.php';
include_once __DIR__ . '/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $currency = 'USD';
    $config = Config::getPayPalConfig();
    $clientId = $config['client_id'];
    $clientSecret = $config['client_secret'];
    $paypalLink = Config::getPayPalLink($amount, $currency);
    echo "<div class='flex justify-center mt-6'>
            <h2 class='text-lg font-semibold text-center mb-4'>Proceed to PayPal Payment</h2>
            <a href='$paypalLink' target='_blank' class='block w-full py-2 text-center bg-blue-600 text-white rounded-md hover:bg-blue-700'>Pay $amount $currency via PayPal</a>
          </div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pay-wanzofc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</head>
<body class="bg-light text-dark">
    <div x-data="{ open: false }" class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-white p-5 rounded shadow-lg w-100 w-md-50" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-3xl font-bold text-center text-primary mb-4">PAY-WANZOFC</h1>
            <form method="POST" action="" class="space-y-4" @submit="open = true">
                <div>
                    <label for="amount" class="form-label h5">Amount (USD):</label>
                    <input type="number" name="amount" id="amount" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="fas fa-credit-card"></i> Pay Now
                </button>
            </form>
            <div x-show="open" class="d-flex justify-content-center align-items-center mt-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
