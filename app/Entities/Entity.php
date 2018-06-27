<?php

namespace KBS\Entities;

use KBS\Query\Builder;

class Entity
{

    /**
     * Table of the entity.
     *
     * @var string
     */
    protected $table;

    /**
     * database of the entity.
     *
     * @var string
     */
    protected $database;

    /**
     * @var \KBS\Query\Builder
     */
    protected $builder;

    /**
     * Attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * @var array
     */
    protected $entityArray = [];

    /**
     * Creates the base for a select query.
     *
     * @param array $selected
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function select($selected = ['*'])
    {
        $this->builder = (new Builder($this))
            ->select($selected);

        return $this;
    }

    /**
     * left joins a table.
     *
     * @param $joiningTable
     * @param $columnToJoinOriginal
     * @param $operator
     * @param $columnToJoinJoiner
     *
     * @return $this
     */
    public function leftjoin($joiningTable, $columnToJoinOriginal, $operator, $columnToJoinJoiner)
    {
        $this->builder->leftjoin($joiningTable, $columnToJoinOriginal, $operator, $columnToJoinJoiner);

        return $this;
    }

    /**
     * Creates the base fo an insert query.
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function insert(array $insertable, $sort = 'insert')
    {
        $this->builder = (new Builder($this))
            ->insert($insertable, $sort)
            ->get()
            ->execute();

        return $this;
    }

    /**
     * Sets the builder to a delete query.
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function delete()
    {
        $this->builder = (new Builder($this))
            ->delete();

        return $this;
    }

    /**
     * Where statement for the query.
     *
     * @param $column
     * @param $operator
     * @param $value
     *
     * @return $this
     */
    public function where($column, $operator, $value)
    {
        $this->builder = $this->builder->where($column, $operator, $value);

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
        $this->builder = $this->builder->orderBy($column, $direction);

        return $this;
    }

    /**
     * Gets the table of the entity.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Returns instance or array of instances.
     *
     * @return $this|array
     */
    public function get()
    {
        $result = $this->fetchQuery();

        foreach ($result as $row)
        {
            $this->entityArray[] = $this->newInstanceAndBind($row);
        }

        return $this->entityArray;
    }

    /**
     * Gets the first row in the table.
     */
    public function first()
    {
        $this->builder = $this->builder->limit(1);

        return $this->get()[0];
    }

    /**
     * Fetches an associative array based on query.
     *
     * @return array
     */
    protected function fetchQuery()
    {
        return $this->executeQuery()
                    ->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return bool|\PDOStatement|string
     */
    protected function executeQuery()
    {
        $this->builder->get()->execute();

        return $this->builder->get();
    }

    /**
     * Extracts to a new instance of a model.
     *
     * @param $result
     *
     * @return mixed
     */
    protected function newInstanceAndBind($result)
    {
        $model = new $this;

        foreach ($result as $col => $value)
        {
            $model->$col = $value;
        }

        return $model;
    }
}