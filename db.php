<?php
class Database 
{
    public $connection;

    public function __construct($config, $username, $password)
    {
        $dsn = 'mysql:' . http_build_query($config, "", ";");


        try {
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Failed to connect Database");
        }
    }

    public function query($query)
    {
        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement->fetchAll();
    }
}