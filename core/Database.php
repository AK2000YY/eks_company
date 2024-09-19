<?php


namespace core;

use PDO;

class Database
{

    public $connection;
    public $statement;

    public function __construct($config)
    {
        $dsn = 'mysql:' . http_build_query($config, '', ';');
        $this->connection = new PDO($dsn, options: [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    public function findOrFail($value = [])
    {
        $result = $this->find();
        if (! $result)
            wrong($value);
        return $result;
    }

    public function get() {
        return $this->statement->fetchAll();
    }
}
