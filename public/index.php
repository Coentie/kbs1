<?php

/**
 * Requiring in the bootstrapping of the application.
 */
require_once __DIR__ . '/../bootstrap/app.php';

dd($container->get('database')->query('SELECT * FROM user'));

$container->get('emitter')->emit($response);