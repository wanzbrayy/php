<?php

// Fungsi mendapatkan konfigurasi
function getConfig() {
    return include 'config.php';
}

// Fungsi mendapatkan token PayPal
function getPayPalToken() {
    $config = getConfig();
    $url = $config['api_base_url'] . '/v1/oauth2/token';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_USERPWD, $config['client_id'] . ":" . $config['client_secret']);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/x-www-form-urlencoded"
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($result, true);
    return $response['access_token'] ?? null;
}

// Fungsi membuat pembayaran
function createPayPalPayment($amount, $currency = "USD") {
    $config = getConfig();
    $token = getPayPalToken();

    if (!$token) {
        die("Failed to retrieve PayPal token");
    }

    $url = $config['api_base_url'] . '/v1/payments/payment';

    $paymentData = [
        "intent" => "sale",
        "payer" => [
            "payment_method" => "paypal"
        ],
        "transactions" => [
            [
                "amount" => [
                    "total" => $amount,
                    "currency" => $currency
                ],
                "description" => "Payment description"
            ]
        ],
        "redirect_urls" => [
            "return_url" => $config['return_url'],
            "cancel_url" => $config['cancel_url']
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

// Fungsi mengeksekusi pembayaran
function executePayPalPayment($paymentId, $payerId) {
    $config = getConfig();
    $token = getPayPalToken();

    if (!$token) {
        die("Failed to retrieve PayPal token");
    }

    $url = $config['api_base_url'] . "/v1/payments/payment/$paymentId/execute";

    $data = [
        "payer_id" => $payerId
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}
