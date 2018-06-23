<?php


namespace KBS\Controllers;

use KBS\View\View;
use KBS\Request\Errors\Error;

class BaseController
{

    /**
     * @var \KBS\View\View
     */
    protected $view;

    /**
     * BaseController constructor.
     *
     * @param \KBS\View\View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * Checks if the user is authenticated to use a controller method.
     */
    protected function authenticate()
    {
        if(! signedIn()) {
            header('Http/1.0 403 Forbidden');
            echo 'Sorry, this area is only for admins';
        }
    }
}