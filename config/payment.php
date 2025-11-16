<?php

return [
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

    'payfast' => [
        'merchant_id' => env('PAYFAST_MERCHANT_ID'),
        'merchant_key' => env('PAYFAST_MERCHANT_KEY'),
        'sandbox' => env('PAYFAST_SANDBOX', true),
    ],

    'fees' => [
        'platform_commission' => 0.05, // 5%
        'gift_well_guest_fee' => 0.10, // 10%
        'gift_well_withdrawal_fee' => 0.0395, // 3.95%
    ],
];