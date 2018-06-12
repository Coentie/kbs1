<?php


namespace KBS\Providers;


use KBS\Config\Config;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ConfigServiceProvider extends AbstractServiceProvider
{

    /**
     * Array of what the service provides.
     *
     * @var array
     */
    protected $provides = [
        'config',
    ];

    /**
     * Register function to register the service.
     */
    public function register()
    {
        $this->getContainer()->share('config', function() {
            $loader = new \KBS\Config\Loader\ArrayLoader([
                                                             'app'   => config_path('app.php'),
                                                             'cache' => config_path('cache.php'),
                                                             'db' => config_path('database.php')
                                                         ]);

            return (new \KBS\Config\Config())->from([$loader]);
        });
    }
}