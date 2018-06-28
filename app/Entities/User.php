<?php


namespace KBS\Entities;

class User extends Entity
{

    /**
     * Table of the entity.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * Protected properties of the entity;
     *
     * @var array
     */
    protected $protected = [
        'password',
    ];

    /**
     * Retreives a user based on name
     *
     * @param $name
     *
     * @throws \ReflectionException
     */
    public function getUserWithName($name)
    {
        return $this->select()
                    ->where('name', '=', $name)
                    ->first();
    }


}