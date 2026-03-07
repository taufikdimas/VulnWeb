<?php
// =========================================
// Database Configuration
// IntraCorp Portal (Vulnerable Edition)
// =========================================

// Load .env file
function loadEnv($path)
{
    if (! file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name               = trim($name);
        $value              = trim($value);

        if (! array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}

// Load .env from project root
loadEnv(__DIR__ . '/../.env');

// Database constants from .env
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'vuln_web');
define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');

// =========================================
// Vulnerable Database Connection
// Sengaja tidak menggunakan prepared statement
// =========================================
class Database
{
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    // Vulnerable connection - no error handling
    private function connect()
    {
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if (! $this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($this->connection, "utf8");
    }

    // Vulnerable query execution - no prepared statement
    public function query($sql)
    {
        $result = mysqli_query($this->connection, $sql);

        if (! $result) {
            die("Query failed: " . mysqli_error($this->connection));
        }

        return $result;
    }

    // Fetch single row
    public function fetch($result)
    {
        return mysqli_fetch_assoc($result);
    }

    // Fetch all rows
    public function fetchAll($result)
    {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Get last inserted ID
    public function lastInsertId()
    {
        return mysqli_insert_id($this->connection);
    }

    // No real escaping - vulnerable
    public function escape($value)
    {
        return $value; // Deliberately vulnerable
    }

    // Get connection (untuk migration)
    public function getConnection()
    {
        return $this->connection;
    }

    // Close connection
    public function close()
    {
        mysqli_close($this->connection);
    }
}
