<?php


namespace KBS\Query;

use KBS\Entities\Entity;

class Builder
{

    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * @var Entity table.
     */
    protected $table;

    /**
     * @var string
     */
    protected $query;

    /**
     * @var array
     */
    protected $bindings = [];

    /**
     * @var \PDOStatement
     */
    protected $preparedQuery;

    /**
     * Builder constructor.
     *
     * @param \PDO|null            $connection
     * @param \KBS\Entities\Entity $entity
     *
     * @throws \ReflectionException
     */
    public function __construct(Entity $entity, \PDO $connection = null)
    {
        $connection ? $this->connection = $connection :
            $this->connection = (new Connection())->getPdo();

        $this->setTable($entity);
    }

    /**
     * Sets the table of the entity.
     *
     * @param $entity
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function setTable(Entity $entity)
    {
        $entity->getTable() ? $this->table = $entity->getTable() :
            $this->table = strtolower((new \ReflectionClass($entity))
                                          ->getShortName());

        return $this;
    }

    /**
     * Creates the base for the select query.
     *
     * @param array $selected
     */
    public function select(array $selected)
    {
        $this->query = 'SELECT ' . $this->arrayToSql($selected) . ' FROM ' . $this->table;

        return $this;
    }

    /**
     * @return bool|\PDOStatement|string
     */
    public function get()
    {
        return $this->prepareQuery();
    }

    /**
     * Preapres the query.
     *
     * @return bool|\PDOStatement|string
     */
    protected function prepareQuery()
    {
        if($this->preparedQuery) return $this->preparedQuery;

        $this->preparedQuery = $this->connection
            ->prepare($this->query);

        return $this->preparedQuery;
    }

    /**
     * Returns the raw query string.
     *
     * @return string
     */
    public function getQueryString()
    {
        return $this->query;
    }

    /**
     * Returns an imploded array ready for SQL.
     *
     * @param array $values
     *
     * @return string
     */
    protected function arrayToSql(array $values)
    {
        return implode("', '", $values);
    }
}