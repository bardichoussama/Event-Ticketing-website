<?php

return [
  'paths' => ['api/*'],
  'allowed_origins' => [
      'https://event-ticketing-website-main-f1hgvp.laravel.cloud',
  ],
  'allowed_methods' => ['*'],
  'allowed_origins_patterns' => [],
  'allowed_headers' => ['*'],
  'exposed_headers' => [],
  'max_age' => 0,
  'supports_credentials' => true,
];
