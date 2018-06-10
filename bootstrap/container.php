<?php

$container = new League\Container\Container;

$container->delegate(
    new \League\Container\ReflectionContainer
);

$container->addServiceProvider(new \KBS\Providers\AppServiceProvider());
$container->addServiceProvider(new \KBS\Providers\ViewServiceProvider());