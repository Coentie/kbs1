<?php

namespace KBS\View;

use Twig_Environment;

class View
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * View constructor.
     *
     * @param \Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Renders the view.
     *
     * @param $response
     *
     * @return mixed
     */
    public function render($response)
    {
        $response->getBody()->write('Home');

        return $response;
    }
}