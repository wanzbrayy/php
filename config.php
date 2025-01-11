<?php
class Config {
    public static function getPayPalConfig() {
        return [
            'client_id' => 'AZeb4u8BMni9caWHIWS1pxMZLLgiArqWMv45dRLw0VN_8Qth8MyOqWmDMDZ4COeclZV7YjUzj72olXsF',
            'client_secret' => 'EFUN8zTG4CklE3fN8Lw8ygtsPNWS272GhRTj-VneTKkcOeGj5mYc4CfuGTSSJgJuEib7G5PepmtpfPit',
            'api_base_url' => 'https://api-m.sandbox.paypal.com',
            'return_url' => 'https://localhost/success.php',
            'cancel_url' => 'https://localhost/cancel.php',
        ];
    }
    public static function getPayPalLink($amount, $currency) {
        return "https://www.sandbox.paypal.com/checkoutnow?amount=$amount&currency=$currency";
    }
}
