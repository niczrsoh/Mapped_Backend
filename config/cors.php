<?php

return [
    // Apply CORS to API routes and our sample endpoint
    'paths' => ['api/*', 'sample'],

    // Allow all methods/headers during development
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],

    // Allow any origin during development (tighten for production)
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],

    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];