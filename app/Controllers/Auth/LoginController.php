<?php


namespace KBS\Controllers\Auth;

use KBS\Controllers\BaseController;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use KBS\Controllers\Auth\Login\canLogin;

class LoginController extends BaseController
{
    use canLogin;
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
    public function login(RequestInterface $request, ResponseInterface $response)
    {
        if($this->signIn($request)) {
            return $this->view->render($response, 'admin/dashboard');
        }

        return $this->view->render($response, 'auth/login', [
            'errors' => $errors
        ]);
    }
}