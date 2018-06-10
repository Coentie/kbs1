<?php

/**
 * Bootstrapping the applications.
 *
 * Starting the session.
 * Requiring in the autoloader from Composer.
 * Load the env variables through vlucas/phpdontenv.
 */
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new \Dotenv\Dotenv(__DIR__ . '/..//'))->load();
}catch (\Dotenv\Exception\InvalidPathException $e) {
    // Do nothing
}

var_dump(getenv('APP_NAME'));

