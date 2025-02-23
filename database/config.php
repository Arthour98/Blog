<?php class Database
{
    private $username = "root";
    private $password = "1234";
    private $host = "localhost";
    private $dbname = "php_project2";

    private $connection;

    public function connect()
    {
        $this->connection = null;

        try {

            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("ERROR:" . $e->getMessage());
        }
        return $this->connection;
    }
}
