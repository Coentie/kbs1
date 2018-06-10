<?php

/**
 * Requiring in the bootstrapping of the application.
 */
require_once __DIR__ . '/../bootstrap/app.php';

$container->get('emitter')->emit($response);