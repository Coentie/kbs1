<?php


namespace KBS\Entities;

class User extends Entity
{

    protected $table = 'user';

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