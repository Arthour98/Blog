<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

class Database
{

    private $username;
    private $password;
    private $host;
    private $dbname ;
    private $port;
    private $connection;
  
        

    public function __construct()
    {
$this->host = getenv("DB_HOST") ?: $_ENV["DB_HOST"] ?? null;
$this->port = getenv("DB_PORT") ?: $_ENV["DB_PORT"] ?? null;
$this->dbname = getenv("DB_NAME") ?: $_ENV["DB_NAME"] ?? null;
$this->username = getenv("DB_USERNAME") ?: $_ENV["DB_USERNAME"] ?? null;
$this->password = getenv("DB_PASSWORD") ?: $_ENV["DB_PASSWORD"] ?? null;
    }

    public function connect()
    {
        $this->connection = null;
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";

            $this->connection = new PDO(
                $dsn,
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            // return;
            die("DB ERROR: " . $e->getMessage());
        }

        return $this->connection;
    }
}?>