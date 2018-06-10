<?php

namespace KBS\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * Array with attributes that the service provider provides.
     *
     * @var array
     */
    protected $provides = [
        //
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();
    }
}