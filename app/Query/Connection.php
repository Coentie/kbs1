<?php


namespace KBS\Query;


class Connection
{

    /**
     * Returns a new PDO instance.
     *
     * @return \PDO
     */
    public static function getPdo()
    {
        return new \PDO(config('database.driver') . ':host=' . config('database.host') . ';dbname=' . config('database.database_name'),
                        config('database.user'),
                        config('database.password'));
    }
}