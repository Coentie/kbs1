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
}