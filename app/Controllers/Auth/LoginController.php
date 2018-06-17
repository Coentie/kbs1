<?php


namespace KBS\Controllers\Auth;

use KBS\Controllers\BaseController;
use KBS\Entities\User;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoginController extends BaseController
{

    /**
     * Index page of the login
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, 'auth/login.twig');
    }

    /**
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \ReflectionException
     */
    public function signin(RequestInterface $request, ResponseInterface $response)
    {
        if($this->signIn()) {
            return $this->view->render($response, 'admin/dashboard');
        }

        return $this->view->render($response, 'auth/login', [
            'errors' => $errors
        ]);
    }
}