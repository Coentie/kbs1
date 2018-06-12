<?php
/**
 * Cache config
 */
return [
    'views' => [
        'enabled' => $enabled = env('VIEW_CACHE'),
        'path'    => $enabled ? base_path('cache/views') : false,
    ],
];