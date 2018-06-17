<?php

/** Home routes */
$route->get('', '\KBS\Controllers\HomeController::index')->setName('home');

/** Contact routes */
$route->get('/contact', '\KBS\Controllers\ContactController::index')->setName('contact');

/** Authentication routes */
$route->get('/login', '\KBS\Controllers\Auth\LoginController::index')->setName('login');
$route->post('/login', '\KBS\Controllers\Auth\LoginController::signin');