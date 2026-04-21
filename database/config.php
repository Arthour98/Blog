<?php

class Database
{
    private $username;
    private $password;
    private $host;
    private $dbname = "php_project2";

    private $connection;

    public function __construct()
    {
        $this->username = getenv("DB_USERNAME");
        $this->password = getenv("DB_PASSWORD");
        $this->host     = getenv("DB_HOST");
    }

    public function connect()
    {
        $this->connection = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

            $this->connection = new PDO(
                $dsn,
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }

        return $this->connection;
    }
}?>