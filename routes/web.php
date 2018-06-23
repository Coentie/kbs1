<?php

/** Home routes */
$route->get('', '\KBS\Controllers\HomeController::index')->setName('home');

/** Contact routes */
$route->get('/contact', '\KBS\Controllers\ContactController::index')->setName('contact');

/** Authentication routes */
$route->get('/login', '\KBS\Controllers\Auth\LoginController::index')->setName('login');
$route->post('/login', '\KBS\Controllers\Auth\LoginController::login');
$route->post('/logout', '\KBS\Controllers\Auth\LoginController::logout');

/** Workexpierence routes */
$route->get('/workexpierence/edit', '\KBS\Controllers\WorkExpierenceController::create');
$route->post('/workexpierence/edit', '\KBS\Controllers\WorkExpierenceController::store');

$route->get('/test', function() {
    (new \KBS\Entities\User())->insert([
                                           'name'     => 'Admin',
                                           'password' => (new \KBS\Hash\Hash())->hash('secret'),
                                       ]);
});