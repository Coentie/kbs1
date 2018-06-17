<?php
/**
 * Application configurables.
 */
return [
    'name'      => [
        'short' => env('APP_NAME', 'KBS'),
        'long'  => 'Kenmerkende beroep sitautie',
    ],

    'debug'     => env('DEBUG_MODE', false),

    'providers' => [
        \KBS\Providers\AppServiceProvider::class,
        \KBS\Providers\ViewServiceProvider::class,
        \KBS\Providers\DatabaseServiceProvider::class,
    ]
];