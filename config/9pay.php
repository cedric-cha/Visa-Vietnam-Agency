<?php

return [
    'sandbox' => env('_9_PAY_SANDBOX', true),

    'endpoint_sandbox' => env('_9_PAY_ENDPOINT_SANDBOX'),
    'merchant_key_sandbox' => env('_9_PAY_MERCHANT_KEY_SANDBOX'),
    'merchant_checksum_key_sandbox' => env('_9_PAY_MERCHANT_CHECKSUM_KEY_SANDBOX'),
    'merchant_secret_key_sandbox' => env('_9_PAY_MERCHANT_SECRET_KEY_SANDBOX'),

    'endpoint' => env('_9_PAY_ENDPOINT'),
    'merchant_key' => env('_9_PAY_MERCHANT_KEY'),
    'merchant_checksum_key' => env('_9_PAY_MERCHANT_CHECKSUM_KEY'),
    'merchant_secret_key' => env('_9_PAY_MERCHANT_SECRET_KEY'),
];
