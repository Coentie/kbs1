<?php


namespace KBS\Providers;

use KBS\View\View;
use Twig_Environment;
use Twig_Loader_Filesystem;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ViewServiceProvider extends AbstractServiceProvider
{
    /**
     * Array with attributes that the service provider provides.
     *
     * @var array
     */
    protected $provides = [
        View::class
    ];

    /**
     * Registers Twig for the view
     *
     * @return void
     */
    public function register() :void
    {
        $container = $this->getContainer();

        $container->share(View::class, function() {
            $loader = new Twig_Loader_Filesystem(resource_path('views'));

            $twig = new Twig_Environment($loader, [
                'cache' => false,
            ]);

            return new View($twig);
        });
    }
}