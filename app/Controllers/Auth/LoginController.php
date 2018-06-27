<?php


namespace KBS\Controllers\Auth;

use KBS\Controllers\BaseController;
use KBS\Request\Errors\Error;
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
     * Attempts to sign in the user.
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function login(RequestInterface $request, ResponseInterface $response)
    {
        if($this->signIn($request)) {
            Error::clear();

            return redirect('contact');
        }

        return $this->view->render($response, 'auth/login.twig', [
            'errorUsername' => Error::has('username') ? Error::get('username') : null,
            'errorPassword' => Error::has('password') ? Error::get('password') : null,
        ]);
    }

    /**
     * Logs the user out.
     *
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function logout(RequestInterface $request, ResponseInterface $response)
    {
        $this->signout();

        return $this->view->render($response, 'home.twig');
    }
}