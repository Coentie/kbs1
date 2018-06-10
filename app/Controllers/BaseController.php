<?php


namespace KBS\Controllers;


use KBS\View\View;

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