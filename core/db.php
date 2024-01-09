<?php
class Database 
{
    public $connection;
    public $statement;

    public function __construct($config, $username, $password)
    {
        //Make data source name of db: localhost: localhost=locahost;port=3306;...
        $dsn = 'mysql:' . http_build_query($config, "", ";");

        //try to connect database
        try {
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            dd($e);
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