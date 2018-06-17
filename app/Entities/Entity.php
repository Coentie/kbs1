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
     * Gets the table of the entity.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Returns assosiative array of the row
     */
    public function get()
    {
        $result = $this->fetchQuery();

        if(count($result) == 1) {
            array_walk($result, [$this, 'bindKeysToEntity']);
        }

        return $this;
    }

    /**
     * Gets the first row in the table.
     */
    public function first()
    {
        $this->builder = $this->builder->limit(1);

        return $this->get();
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
     * Binds retreived keys to the object.
     *
     * @param $result
     */
    protected function bindKeysToEntity($result)
    {
        foreach($result as $attribute => $value)
        {
            $this->$attribute = $value;
        }
    }
}