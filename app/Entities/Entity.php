<?php


namespace KBS\Entities;

use KBS\Query\Builder;

class Entity
{

    /**
     * @var \KBS\Query\Builder
     */
    private $builder;

    /**
     * Entity constructor.
     */
    public function __construct()
    {
        $this->builder = new Builder();
    }
}