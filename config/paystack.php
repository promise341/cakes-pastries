<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paystack Keys
    |--------------------------------------------------------------------------
    | Get these from your Paystack dashboard: https://dashboard.paystack.com
    */

    'publicKey'  => env('PAYSTACK_PUBLIC_KEY'),
    'secretKey'  => env('PAYSTACK_SECRET_KEY'),
    'paymentUrl' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
    'merchantEmail' => env('MERCHANT_EMAIL'),
];
