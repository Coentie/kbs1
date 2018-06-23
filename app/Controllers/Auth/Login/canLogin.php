<?php


namespace KBS\Controllers\Auth\Login;

use KBS\Hash\Hash;
use KBS\Entities\User;
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
             ->userFound() ? $this->passwordMatch($request) : null;

        $this->loggedIn ?
            $this->saveToSession() : null;

        return $this->loggedIn;
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

    protected function passwordMatch($request)
    {
        if(! $this->user) return;

        $hash = new Hash();

        if(! $hash->equals($this->user->password, $request->password)) {
            $this->loginFailed();
        }
    }

    protected function saveToSession()
    {
        SessionManager::add('username', $this->user->name);
    }

}