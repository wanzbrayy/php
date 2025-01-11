<?php
include 'functions.php';

if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payerId = $_GET['PayerID'];

    $response = executePayPalPayment($paymentId, $payerId);

    if (!empty($response['state']) && $response['state'] === 'approved') {
        echo "Payment successful!";
    } else {
        echo "Payment failed!";
    }
} else {
    echo "Invalid request.";
}
