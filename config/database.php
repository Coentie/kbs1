<?php

/**
 * Database configuration
 */

return [
    'driver'        => env('DB_DRIVER', 'mysql'),
    'host'          => env('DB_HOST', 'localhost'),
    'database_name' => env('DB_NAME', 'kbs'),
    'password'      => env('DB_PASSWORD', 'secret'),
    'user'          => env('DB_USER', 'root'),
];