<?php


namespace KBS\Providers;

use KBS\View\View;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_Extension_Debug;
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

        /** @var \KBS\Config\Config $config */
        $config = $this->container->get('config');

        $container->share(View::class, function() use ($config) {
            $loader = new Twig_Loader_Filesystem(resource_path('views'));

            $twig = new Twig_Environment($loader, [
                'cache' => $config->get('cache.views.path', false),
                'debug' => $config->get('app.debug', false),
            ]);

            if($config->get('app.debug')) {
                $twig->addExtension(new Twig_Extension_Debug());
            }

            return new View($twig);
        });
    }
}