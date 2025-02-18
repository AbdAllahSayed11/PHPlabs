<?php
// Include the database connection file (config.php)

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $student_id = htmlspecialchars(trim($_POST['student_id']));
    $f_name = htmlspecialchars(trim($_POST['f_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $l_name = htmlspecialchars(trim($_POST['l_name']));
    $imagePath = null;

    // Handle profile picture upload
// Handle profile picture upload
if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] == 0) {
    $profilePic = $_FILES['profile-pic'];
    $uploadDir = 'imag';  // Save uploaded images in the 'images' directory
    $uploadFile = $uploadDir . uniqid() . '-' . basename($profilePic['name']); // Renaming to avoid conflicts
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (in_array($profilePic['type'], $allowedTypes)) {
        // Attempt to move the uploaded file to the images directory
        if (move_uploaded_file($profilePic['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile;  // Path to the uploaded image
            echo "File uploaded successfully!";
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Invalid image format.";
    }
} else {
    echo "Error with file upload: " . $_FILES['profile-pic']['error']; // Display error code
    exit();
}


    // Prepare the SQL insert query only if image upload was successful
    if ($imagePath !== null) {
        $query = "INSERT INTO student (student_id, f_name, email, l_name, imag) 
                  VALUES (:student_id, :f_name, :email, :l_name, :imag)";  // Corrected query

        try {
            // Prepare the statement
            $stmt = $db->conn->prepare($query);

            // Bind the parameters to the query
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $stmt->bindParam(':f_name', $f_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':l_name', $l_name, PDO::PARAM_STR);
            $stmt->bindParam(':imag', $imagePath, PDO::PARAM_STR); // Bind image path instead of image name

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
    } else {
        echo "Profile picture upload failed. Data was not inserted.";
    }

    // Save the user data to the text file
    $userData = "studentID: $student_id\nf_name: $f_name\nEmail: $email\nl_name: $l_name\nProfile Picture: $imagePath\n\n";
    
    // Open the file and save the data
    $file = fopen('data.txt', 'a');  
    if ($file) {
        fwrite($file, $userData);  
        fclose($file);
        echo "Data saved successfully!";
    } else {
        echo "Failed to save user data.";
    }
}
?>
