<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '389360993093111',
        'client_secret' => 'e8258dc6f5294434c14657b2d96d3c6a',
        'redirect' => 'http://127.0.0.1:8000/facebook/callback',
    ], //chưa chỉnh 

    'google' => [
        'client_id' => '685355693811-u4iq8b7f4t2lekpqo0c8bk5rkrjfv067.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/shophoa/google/callback',
    ], //đã chỉnh

];
