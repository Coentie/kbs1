<?php


namespace KBS\Controllers;


use KBS\Query\Builder;
use KBS\View\View;

class BaseController
{

    /**
     * @var \KBS\View\View
     */
    protected $view;

    /**
     * @var \KBS\Query\Builder
     */
    protected $builder;

    /**
     * BaseController constructor.
     *
     * @param \KBS\View\View $view
     */
    public function __construct(View $view, Builder $builder)
    {
        $this->view = $view;
        $this->builder = $builder;
    }
}