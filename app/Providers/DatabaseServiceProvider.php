<?php


namespace KBS\Providers;


use KBS\Query\Builder;
use KBS\Query\Connection;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DatabaseServiceProvider extends AbstractServiceProvider
{

    /**
     * Array of what the service provider provides.
     *
     * @var array
     */
    protected $provides = [
        \PDO::class,
    ];

    /**
     * Registers the provider inside the container.
     */
    public function register()
    {
        $container = $this->getContainer();

        $config = $container->get('config');

        $container->share(\PDO::class, function () use ($config) {

            return new \PDO($config->get('db.driver') . ':host=' . $config->get('db.host') . ';dbname=' . $config->get('db.database_name'),
                            $config->get('db.user'),
                            $config->get('db.password'));
        });
    }
}