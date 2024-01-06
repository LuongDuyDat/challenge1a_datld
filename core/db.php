<?php
class Database 
{
    public $connection;
    public $statement;

    public function __construct($config, $username, $password)
    {
        $dsn = 'mysql:' . http_build_query($config, "", ";");


        try {
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            dd($e);
            die("Failed to connect Database");
        }
    }

    public function query($query, $params = [])
    {
        try {
            $this->statement = $this->connection->prepare($query);

            $this->statement->execute($params);

            return $this;
        } catch (PDOException $e) {
            dd($e);
        }
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll();
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();

        if (!$result) {
            return 'fail';
        }

        return $result;
    }
}