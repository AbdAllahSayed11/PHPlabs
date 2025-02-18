<?php
include_once 'DB.php'; // Make sure DB is included to establish the connection

class User {
    private $conn;
    private $table_name = 'student';

    public function __construct($db) {
        // Check if the connection is valid
        if ($db) {
            $this->conn = $db;
        } else {
            echo "Database connection failed.";
            exit();
        }
    }

    // Add a user to the database
    public function addUser($data, $imagePath) {
        // Validate data
        if (!$this->validateFormData($data)) {
            return "Invalid form data.";
        }

        // SQL query to insert user into the database
        $query = "INSERT INTO " . $this->table_name . " (student_id, f_name, email, l_name, imag) 
                  VALUES (:student_id, :f_name, :email, :l_name, :imag)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':f_name', $data['f_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':l_name', $data['l_name']);
        $stmt->bindParam(':imag', $imagePath);

        // Execute and return result
        if ($stmt->execute()) {
            return "User added successfully!";
        } else {
            return "Failed to add user.";
        }
    }

    // Validate form data
    private function validateFormData($data) {
        if (empty($data['student_id']) || empty($data['f_name']) || empty($data['email']) || empty($data['l_name'])) {
            return false;
        }
        return true;
    }

    // Display all users from the database
    public function displayUsers() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update user information
    public function updateUser($data, $imagePath) {
        $query = "UPDATE " . $this->table_name . " SET 
                    f_name = :f_name, 
                    email = :email, 
                    l_name = :l_name, 
                    imag = :imag 
                  WHERE student_id = :student_id";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':f_name', $data['f_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':l_name', $data['l_name']);
        $stmt->bindParam(':imag', $imagePath);

        if ($stmt->execute()) {
            return "User updated successfully!";
        } else {
            return "Failed to update user.";
        }
    }

    // Delete user from the database
    public function deleteUser($student_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE student_id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        if ($stmt->execute()) {
            return "User deleted successfully!";
        } else {
            return "Failed to delete user.";
        }
    }
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'student_id' => $_POST['student_id'],
        'f_name' => $_POST['f_name'],
        'email' => $_POST['email'],
        'l_name' => $_POST['l_name']
    ];

    // Handle image upload and call addUser method
    if (isset($_FILES['profile-pic'])) {
        // Upload the image and get its path
        $profilePic = $_FILES['profile-pic'];
        $uploadDir = 'images';  // Change to images for clarity
        $uploadFile = $uploadDir . uniqid() . '-' . basename($profilePic['name']);

        if (move_uploaded_file($profilePic['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile;
            $message = $user->addUser($data, $imagePath);
        } else {
            $message = "Failed to upload image.";
        }
    }
}

?>

<!-- Form to add user -->
<form action="adduser.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="student_id" placeholder="Student ID" required>
    <input type="text" name="f_name" placeholder="First Name" required>
    <input type="text" name="l_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="file" name="profile-pic" required>
    <input type="submit" value="Add User">
</form>

<?php
if (isset($message)) {
    echo $message;
}
?>
