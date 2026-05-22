<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:3000',
        'http://localhost:3001',
        'https://portal-cbt.my.id',
        'https://sistem-ujian-google-form-smatm-v2.vercel.app',
    ],

    'allowed_origins_patterns' => ['*.vercel.app'],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
