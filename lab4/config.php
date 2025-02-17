<?php
// Database connection details
class DB
{
    private $host = 'localhost';
    private $username = 'root'; 
    private $password = '!1Abody123'; 
    private $database = 'lab1_iti';
    public $conn;

    // Constructor to establish a connection
    public function __construct() {
        try {
            // Create the PDO connection using the class variables
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // echo "Connected successfully"; // If connection is successful (optional)
        } catch (PDOException $e) {
            // If connection fails, catch the error and display it
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
