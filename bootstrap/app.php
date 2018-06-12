<?php

/**
 * Bootstrapping the applications.
 *
 * Starting the session.
 * Requiring in the autoloader from Composer.
 * Load the env variables through vlucas/phpdontenv.
 * Load in the application container through thephpleague/container.
 */
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try
{
    (new \Dotenv\Dotenv(base_path()))->load();
}
catch (\Dotenv\Exception\InvalidPathException $e)
{
    // Do nothing
}

require_once base_path('bootstrap/container.php');

$route = $container->get(\League\Route\RouteCollection::class);

require_once route_path('web.php');

$response = $route->dispatch(
    $container->get('request'), $container->get('response')
);

