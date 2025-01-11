<?php
// Memasukkan file konfigurasi dan dependensi lainnya
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/endroid-qr-code.php';
include_once __DIR__ . '/functions.php';

$paypalLink = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $currency = 'USD';

    // Mengambil konfigurasi PayPal dari config.php
    $config = Config::getPayPalConfig();
    $clientId = $config['client_id'];
    $clientSecret = $config['client_secret'];

    // Generate PayPal link
    $paypalLink = Config::getPayPalLink($amount, $currency);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAY-WANZOFC</title>
    <!-- Memasukkan Bootstrap untuk desain tampilan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">PAY-WANZOFC</h1>

        <form id="payment-form" method="POST" action="" class="space-y-4">
            <div class="mb-3">
                <label for="amount" class="form-label">Amount (USD):</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-credit-card"></i> Pay Now
            </button>
        </form>

        <!-- Menampilkan link PayPal setelah pembayaran -->
        <?php if (!empty($paypalLink)): ?>
            <div class="mt-4 text-center">
                <h4>Proceed to PayPal Payment</h4>
                <a href="<?php echo $paypalLink; ?>" target="_blank" class="btn btn-success w-100">
                    Pay $<?php echo htmlspecialchars($amount); ?> USD via PayPal
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Menambahkan script untuk mencegah reload dan pengiriman form -->
    <script>
        $(document).ready(function() {
            // Mencegah halaman reload saat form disubmit
            $('#payment-form').submit(function(e) {
                e.preventDefault(); // Mencegah refresh
                var amount = $('#amount').val();
                if (amount) {
                    $.post('', { amount: amount }, function(response) {
                        // Jika berhasil, form akan mengembalikan link PayPal
                        $('#payment-form').hide();
                        $('#paypal-link').html(response);
                    });
                }
            });
        });
    </script>
</body>
</html>
