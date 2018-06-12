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
     * Renders the response.
     *
     * @param       $response
     * @param       $view
     * @param array $data
     *
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render($response, $view, array $data = [])
    {
       $response->getBody()->write(
           $this->twig->render($view, $data)
       );

       return $response;
    }
}