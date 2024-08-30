<?php
// config/midtrans.php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'is_production' => env('MIDTRANS_PRODUCTION', false), // false untuk sandbox/testing

    // Additional configuration options
    'is_sanitized' => env('MIDTRANS_SANITIZED', true),  // Optional: Sanitize request data
    'is_3ds' => env('MIDTRANS_3DS', true),  // Optional: Use 3D Secure for transaction
];
