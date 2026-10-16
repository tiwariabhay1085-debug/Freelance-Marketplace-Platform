<? php

require_once __DIR__ . '/config.php';

class Database 
{
    private string $host = 'loacalhost';
    private string $database = 'prolance';
    private string $username = 'root';
    private string $password = '';

    private ?PDO $connection = null

    public function connect(): PDO
    {
        if ($this->connection !== null) {
            return $this->connection
        }

        try{
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4"

            $this->connection = new PDO(
                $dsn,
                $this->username,
                $this->password
            );

            $this->connection-setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->connection->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            $this->connection->setAttribute(
                PDO::ATTR_EMULATE_PREPARES,
                false
            );

            return $this->connection;
        } catch (PDOException $e) {
            http_response_code(500);

            die(
                "Database connection failed"
            );
        }
    }
}