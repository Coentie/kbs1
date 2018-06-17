<?php

namespace KBS\Providers;

use Zend\Diactoros\Response;
use League\Route\RouteCollection;
use Zend\Diactoros\ServerRequestFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * Array with attributes that the service provider provides.
     *
     * @var array
     */
    protected $provides = [
        RouteCollection::class,
        'response',
        'request',
        'emitter'
    ];

    /**
     * Registers the router, response, request and the emitter.
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(RouteCollection::class, function() use($container) {
            return new RouteCollection($container);
        });

        $container->share('response', Response::class);

        $container->share('request', function() {
           return ServerRequestFactory::fromGlobals(
               $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        $container->share('emitter', Response\SapiEmitter::class);
    }
}