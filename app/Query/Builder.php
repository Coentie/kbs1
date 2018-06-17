<?php


namespace KBS\Query;

class Builder
{

    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * Builder constructor.
     *
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection = null)
    {
        $connection ? $this->connection = $connection :
            $this->connection = Connection::getPdo();
    }

    public function get()
    {
        //
    }
}