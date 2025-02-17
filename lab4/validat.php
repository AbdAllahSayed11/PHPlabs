<?php
// Include the database connection file (config.php)
include_once('config.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $student_id=$_POST['student_id'];
    $f_name = $_POST['f_name'];
    $email = $_POST['email'];
    $l_name = $_POST['l_name'];

    // Prepare the SQL insert query
    $query = "INSERT INTO student (student_id,f_name, email, l_name) 
              VALUES (:student_id,:f_name, :email, :l_name)"; // Remove the extra comma

    try {
        // Prepare the statement
        $stmt = $db->conn->prepare($query);

        // Bind the parameters to the query
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        $stmt->bindParam(':f_name', $f_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':l_name', $l_name, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Check if data was inserted successfully
        if ($stmt->rowCount() > 0) {
            echo "Data inserted successfully!";
        } else {
            echo "Failed to insert data.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
