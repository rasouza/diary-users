<?php

return [
    'frontend' => env('FRONTEND_URL', 'http://localhost:3000'),
    'idp' => [
        'external' => env('IDP_EXTERNAL_URL', 'http://localhost:4444'),
        'admin' => env('IDP_ADMIN_URL', 'http://idp-svc:4445'),
        'common' => env('IDP_URL', 'http://idp-svc:4444'),
    ]
];
