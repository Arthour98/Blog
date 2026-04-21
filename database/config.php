<?php class Database
{
    private $username = null;
    private $password = null;
    private $host = null;
    private $dbname = null;

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
