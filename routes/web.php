<?php

$route->get('', '\KBS\Controllers\HomeController::index')->setName('home');
$route->get('/contact', '\KBS\Controllers\ContactController::index')->setName('contact');