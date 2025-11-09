<?php

return [
    // Apply CORS to API routes and sample endpoints
    'paths' => ['api/*', 'sample', 'sample/*'],
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],

    // Allow any origin in development (no cookies)
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],

    'exposed_headers' => [],
    'max_age' => 3600,

    // Disable credentials for wildcard origins; enable and set explicit origins if needed
    'supports_credentials' => false,
];