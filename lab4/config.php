<?php
class DB
{
    private $host = 'localhost';
    private $username = 'root'; 
    private $password = '!1Abody123'; 
    private $database = 'lab1_iti'; // Database name
    public $conn;

    public function __construct() {
        try {
            // Create the PDO connection
            $this->conn = new PDO("mysql:host=$this->host", $this->username, $this->password);
            // Set PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Select the database explicitly
            $this->conn->exec("USE $this->database");

            echo "Connected and database selected successfully."; // Debug message

        } catch (PDOException $e) {
            // Display any connection errors
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Optional method to close the connection
    public function closeConnection() {
        $this->conn = null;
    }
}

// Create an instance of the DB class
$db = new DB();  // Connection is stored in $db->conn
?>
