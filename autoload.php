<?php
class Config
{
    private static $config;
    public static function loadConfig()
    {
        if (self::$config === null) {
            self::$config = include __DIR__ . '/config.php';
        }
        return self::$config;
    }
    public static function getPayPalConfig()
    {
        return self::loadConfig();
    }
    public static function getPayPalLink($amount, $currency = 'USD')
    {
        $config = self::loadConfig();
        $clientId = $config['client_id'];
        $returnUrl = $config['return_url'];
        $cancelUrl = $config['cancel_url'];

        return "{$config['api_base_url']}/checkoutnow?amount=$amount&currency_code=$currency&client_id=$clientId&return_url=$returnUrl&cancel_url=$cancelUrl";
    }
}
