<?php


namespace KBS\Controllers\Auth\Login;

use KBS\Hash\Hash;
use KBS\Entities\User;
use KBS\Request\Errors\Error;
use KBS\Session\SessionManager;

trait canLogin
{

    /**
     * @var \KBS\Entities\User
     */
    private $user;

    /**
     * @var bool
     */
    private $loggedIn = true;

    /**
     * @param $request
     *
     * @return bool
     * @throws \ReflectionException
     */
    public function signin($request)
    {
        $this->setUser($request)
             ->userFound() ? $this->passwordMatch($request) : Error::add('username', 'Username not found.');

        $this->loggedIn ?
            $this->saveToSession() : null;

        return $this->loggedIn;
    }

    /**
     * Logs the user out.
     */
    protected function signout()
    {
        SessionManager::remove('username');
    }

    /**
     * Sets the user.
     *
     * @param $request
     *
     * @throws \ReflectionException
     */
    private function setUser($request)
    {
        $this->user = (new User())->getUserWithName($request->getParsedBody()['username']);

        return $this;
    }

    /**
     * Checks if the user is found.
     *
     * @return bool
     */
    private function userFound()
    {
        if(! property_exists($this->user, 'name'))
        {
            $this->loginFailed();
        }

        return $this->loggedIn;
    }

    /**
     * Sets the logged in property to false.
     */
    private function loginFailed()
    {
        $this->loggedIn = false;
    }

    /**
     * Validates the password.
     *
     * @param $request
     */
    protected function passwordMatch($request)
    {
        if(! $this->user) return;

        $hash = new Hash();

        if(! $hash->equals($request->getParsedBody()['password'], $this->user->password)) {
            Error::add('password', 'Password does not match the username.');
            $this->loginFailed();
        }
    }

    /**
     * Saves the user to the session.
     */
    protected function saveToSession()
    {
        SessionManager::add('username', $this->user->name);
    }

}