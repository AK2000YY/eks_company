<?php


namespace core;

use PDO;
use PDOException;

class Database
{

    public $connection;
    public $statement;

    public function __construct($config)
    {
        try {
            $dsn = 'mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'] . ';charset=' . $config['charset'];
            $this->connection = new PDO($dsn, $config['user'], $config['password'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function lastIndex()
    {
        return $this->connection->lastInsertId();
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
