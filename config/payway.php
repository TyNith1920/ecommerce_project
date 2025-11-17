<?php
return [
    'env' => env('PAYWAY_ENV', 'sandbox'),
    'urls' => [
        'sandbox' => env('PAYWAY_API_URL_SANDBOX', 'https://checkout-sandbox.payway.com.kh'),
        'prod'    => env('PAYWAY_API_URL_PROD', 'https://checkout.payway.com.kh'),
    ],
    'endpoint_path' => env('PAYWAY_ENDPOINT_PATH', '/api/payment-gateway/v1/payments/purchase'),

    'merchant_id' => env('PAYWAY_MERCHANT_ID', ''),
    'currency'    => env('PAYWAY_CURRENCY', 'USD'),
    'key_id'      => env('PAYWAY_KEY_ID', ''),

    'rsa_private_path' => env('PAYWAY_PRIVATE_PEM_PATH', base_path('keys/private.pem')),
    'rsa_public_path'  => env('PAYWAY_PUBLIC_PEM_PATH',  base_path('keys/public.pem')),
    'rsa_private_pem'  => env('PAYWAY_PRIVATE_PEM', ''),
    'rsa_private'      => env('PAYWAY_PRIVATE_B64', ''),
    'rsa_public_pem'   => env('PAYWAY_PUBLIC_PEM', ''),
    'rsa_public'       => env('PAYWAY_PUBLIC_B64', ''),
    'rsa_pass'         => env('PAYWAY_RSA_PASS', ''),

    // legacy HMAC (optional)
    'public_key' => env('PAYWAY_API_KEY', ''),

    // URLs must come from .env (កុំប្រើ url() នៅទីនេះ)
    'return_url'           => env('PAYWAY_RETURN_URL', 'http://127.0.0.1:8000/payway/return'),
    'cancel_url'           => env('PAYWAY_CANCEL_URL', 'http://127.0.0.1:8000/'),
    'continue_success_url' => env('PAYWAY_CONTINUE_SUCCESS_URL', 'http://127.0.0.1:8000/'),
];
