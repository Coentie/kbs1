<?php


namespace KBS\Query;


class Connection
{

    /**
     * Returns a new PDO instance.
     *
     * @return \PDO
     */
    public function getPdo()
    {
        try
        {
            $pdo =  new \PDO(config('database.driver') . ':host=' . config('database.host') . ';dbname=' . config('database.database_name'),
                            config('database.user'),
                            config('database.password'));
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            return $pdo;
        }
        catch (\PDOException $e)
        {
            echo var_dump($e->getMessage());
        }
    }
}