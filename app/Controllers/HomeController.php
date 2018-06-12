<?php

namespace KBS\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController extends BaseController
{

    /**
     * Returns the index method of the home view.
     *
     * @param $request
     * @param $response
     *
     * @return mixed
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, 'home.twig', [
            'user' => [
                'id' => 1,
            ]
        ]);
    }
}