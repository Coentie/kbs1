<?php


namespace KBS\Controllers\Auth\Login;


use KBS\Entities\User;
use KBS\Hash\Hash;

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
             ->userFound() ?: $this->passwordMatch($request);

        if($this->loggedIn) {
            $this->saveToSession();
        }

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
        $this->user = (new User())->getUserWithName($request->name);

        return $this;
    }

    /**
     * Checks if the user is found.
     *
     * @return $this
     */
    private function userFound()
    {
        if(! property_exists($this->user, 'name'))
        {
            $this->loginFailed();
        }

        return $this;
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
        $hash = new Hash();

        if(! $hash->equals($this->user->password, $request->password)) {
            $this->loginFailed();
        }
    }

    protected function saveToSession()
    {
        session('username', $this->user->name);
    }

}