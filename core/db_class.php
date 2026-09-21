<?php

// Pull in the connection settings (DATABASE, SERVER, USERNAME, PASSWD constants)
require_once "db_cred.php";

// Database is the base class every "model" class (like Customer) should extend.
// It knows how to connect to MySQL and how to run queries safely (using
// prepared statements, which protect against SQL injection). Child classes
// don't need to know any of this - they just call $this->fetchAll(), etc.
class Database
{
    // $conn holds the PDO connection object. It is private because only
    // this class needs to touch it directly - child classes use the
    // helper methods below instead.
    private $conn;

    // These properties are set from the constants defined in db_cred.php.
    // Using properties (instead of the constants directly) makes it easy
    // to override them later if a subclass ever needs a different database.
    private $host = SERVER;
    private $dbname = DATABASE;
    private $username = USERNAME;
    private $password = PASSWD;

    // The constructor runs automatically whenever `new Database()` (or
    // `new Customer()`, since Customer extends Database) is called.
    // It opens the connection so every child class is ready to query
    // the database as soon as it is created.
    public function __construct()
    {
        try {
            // PDO is PHP's built-in database access layer.
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            // Show database errors as exceptions
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Execute SELECT queries that can return many rows.
    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Execute a SELECT query that is only expected to return one row
    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Execute INSERT, UPDATE and DELETE statements.
    public function execute($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Get the raw PDO connection if a child class ever needs it
    public function getConnection()
    {
        return $this->conn;
    }

    // Compatibility methods for legacy code
    public function connect()
    {
        return $this->conn !== null;
    }

    public function db_query($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }

    public function db_fetch_one($sql)
    {
        return $this->fetchOne($sql);
    }

    public function db_fetch_all($sql)
    {
        return $this->fetchAll($sql);
    }
}

// Alias class for backward compatibility
if (!class_exists('db_class')) {
    class db_class extends Database {}
}

?>