<?php class Database
{
    private $username = $env["DB_USERNAME"];
    private $password = $env["DB_PASSWORD"];
    private $host = $env["APP_URL"];
    private $dbname = "php_project2";

    private $connection;

    public function __construct()
    {
        $env = parse_ini_file(__DIR__ . '/../.env');

        $this->username = $env["DB_USERNAME"];
        $this->password = $env["DB_PASSWORD"];
        $this->host     = $env["DB_HOST"];
    }
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
