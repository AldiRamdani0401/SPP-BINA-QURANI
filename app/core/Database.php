<?php
require __DIR__ . "/../config/Database.php";

class Database {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli(hostname: DB_HOST, username: DB_USER, password: DB_PASS, database: DB_NAME);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection(): mysqli {
        return $this->connection;
    }

    public function closeConnection(): void {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
