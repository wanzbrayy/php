<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    $response = createPayPalPayment($amount);

    if (!empty($response['links'])) {
        foreach ($response['links'] as $link) {
            if ($link['rel'] === 'approval_url') {
                header("Location: " . $link['href']);
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Integration</title>
</head>
<body>
    <h1>PayPal Integration</h1>
    <form method="POST" action="">
        <label for="amount">Amount (USD):</label>
        <input type="number" name="amount" id="amount" required>
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
