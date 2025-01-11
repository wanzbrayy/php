<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    $response = createPayPalPayment($amount);

    if (!empty($response['links'])) {
        foreach ($response['links'] as $link) {
            if ($link['rel'] === 'approval_url') {
                echo '<script>
                        Swal.fire({
                            title: "Payment Created!",
                            text: "You will be redirected to PayPal.",
                            icon: "success",
                            confirmButtonText: "Okay"
                        }).then(() => {
                            window.location.href = "' . $link['href'] . '";
                        });
                      </script>';
                exit;
            }
        }
    } else {
        echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong. Please try again.",
                    icon: "error",
                    confirmButtonText: "Close"
                });
              </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Integration</title>
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
            <h1 class="text-3xl font-bold text-center text-blue-500 mb-6">PayPal Integration</h1>
            <form method="POST" action="" class="space-y-4" @submit="open = true">
                <div>
                    <label for="amount" class="block text-lg font-medium text-gray-700">Amount (USD):</label>
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
