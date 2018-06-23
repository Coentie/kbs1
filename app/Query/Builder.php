<?php


namespace KBS\Query;

use KBS\Entities\Entity;

// ToDo: Remove entity dependency.

class Builder
{

    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * @var string.
     */
    protected $table;

    /**
     * @var string
     */
    protected $select;

    /**
     * @var string
     */
    protected $query;

    /**
     * @var string
     */
    protected $insert;

    /**
     * @var array
     */
    protected $bindings = [];

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var \PDOStatement
     */
    protected $preparedQuery;

    /**
     * @var array
     */
    protected $whereStatement;

    /**
     * @var bool
     */
    protected $where = false;

    /**
     * @var string
     */
    protected $querySort;

    /**
     * @var string
     */
    protected $orderBy;

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
     * Sets the sort of query.
     *
     * @param $sort
     */
    protected function setQuerySort($sort)
    {
        $this->querySort = $sort;
    }

    /**
     * Creates the base for the select query.
     *
     * @param array $selected
     */
    public function select(array $selected)
    {
        $this->setQuerySort('select');

        $this->select = 'SELECT ' . $this->arrayToSql($selected) . ' FROM ' . $this->table;

        return $this;
    }

    /**
     * Creates the base for the insert query.
     *
     * @param array $array
     *
     * @return $this
     */
    public function insert(array $array)
    {
        $this->setQuerySort('insert');

        $this->insert = 'INSERT INTO ' .
            $this->table .
            '(' .
            $this->extractColumns($array) .
            ') VALUES (' .
            $this->getBindingString($array)
            . ')';

        return $this;
    }

    /**
     * Extracting columns into a query string.
     *
     * @param array $array
     *
     * @return string
     */
    protected function extractColumns(array $array)
    {
        return implode(', ', array_keys($array));
    }

    /**
     * Extract the bindings from an array.
     *
     * @param $array
     *
     * @return string
     */
    protected function getBindingString($array)
    {
        $appendable = '';

        foreach ($array as $col => $binding)
        {
            $appendable .= ':' . $col;

            if ($binding !== end($array))
            {
                $appendable .= ',';
            }

            $this->appendBindings($col, $binding);
        }

        return $appendable;
    }


    /**
     * Sets a where statement.
     *
     * @param $column
     * @param $operator
     * @param $value
     *
     * @return $this
     */
    public function where($column, $operator, $value)
    {
        $this->appendBindings($column, $value);

        $this->whereStatement .= $this->getWhere()
            . ' '
            . $column
            . ' '
            . $operator
            . ' '
            . ':'
            . $column;

        return $this;
    }

    /**
     * Orders the query.
     *
     * @param        $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = ' ORDER BY ' . $column . ' ' . $direction;

        return $this;
    }

    /**
     * Appends the bindings to the bindings array.
     *
     * @param $column
     * @param $value
     */
    protected function appendBindings($column, $value)
    {
        $this->bindings[] = [
            'column' => ':' . $column,
            'value'  => $value
        ];
    }

    /**
     * Retreives the set bindings.
     *
     * @return array
     */
    public function getBindings()
    {
        return $this->bindings;
    }

    /**
     * Gets the where statement.
     *
     * @return string
     */
    protected function getWhere()
    {
        $value = $this->where ? ' AND' : ' WHERE';

        if ( ! $this->where)
        {
            $this->whereStatementUsed();
        }

        return $value;
    }

    /**
     * Updates the where property
     */
    protected function whereStatementUsed()
    {
        $this->where = ! $this->where;
    }

    /**
     * Limits the search result of the query.
     *
     * @param int $amount
     *
     * @return $this
     */
    public function limit($amount = 1)
    {
        $this->limit = ' LIMIT ' . $amount;

        return $this;
    }

    /**
     * @return bool|\PDOStatement|string
     */
    public function get()
    {
        return $this->generateQuery()
                    ->prepareQuery();
    }

    /**
     * Generates the query in the right order.
     *
     * @return $this
     */
    public function generateQuery()
    {
        switch ($this->querySort)
        {
            case 'select':
                $this->query = $this->select
                    . $this->whereStatement
                    . $this->orderBy
                    . $this->limit;
                break;
            case 'insert':
                $this->query = $this->insert;
                break;
        }

        return $this;
    }

    /**
     * Preapres the query.
     *
     * @return bool|\PDOStatement|string
     */
    protected function prepareQuery()
    {
        if ($this->preparedQuery)
        {
            return $this->preparedQuery;
        }

        $this->preparedQuery = $this->connection
            ->prepare($this->query);

        if (count($this->bindings) > 0)
        {
            $this->bindParameters();
        }

        return $this->preparedQuery;
    }

    /**
     * Bind the parameters to the query.
     */
    protected function bindParameters()
    {
        foreach ($this->bindings as $binding)
        {
            $this->preparedQuery->bindParam($binding['column'], $binding['value'], \PDO::PARAM_STR);
        }
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