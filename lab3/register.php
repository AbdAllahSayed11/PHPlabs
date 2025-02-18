<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // // Static values for username and password (use this for testing)
    // $username = "asd";
    // $password = "123"; 

    // // Fixing the password check logic
    // if ($username == 'asd' && $password = '123') {
    //     $_SESSION["username"] = "asd";    
    //     echo "Hello, " . $_SESSION["username"];  
    // }
    //     $_SESSION["username"] = "asd";    
          
    // Check if the required fields are set
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Define the regular expression pattern for a valid email
    $emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    
    // Validate the email using preg_match
    if (preg_match($emailPattern, $email)) {
        echo "The email address '$email' is valid.";
    } else {
        echo "The email address '$email' is not valid.";
    }
    $password = isset($_POST['password']) ? $_POST['password'] : ''; 
    $confirmPassword = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';
    $room = isset($_POST['room']) ? $_POST['room'] : '';
    $ext = isset($_POST['ext']) ? $_POST['ext'] : '';

    // // Password validation
    // if ($password !== $confirmPassword) {
    //     echo "Passwords do not match.";
    //     exit();
    // }

    // Handle profile picture upload
    if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] == 0) {
        $profilePic = $_FILES['profile-pic'];
        $uploadDir = 'images/';  // Save uploaded images in the 'images' directory
        $uploadFile = $uploadDir . basename($profilePic['name']);
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($profilePic['type'], $allowedTypes)) {
            // Move the file to the images dir
            if (move_uploaded_file($profilePic['tmp_name'], $uploadFile)) {
                $imagePath = $uploadFile;  
            } else {
                echo "Failed to upload image.";
                exit();
            }
        } else {
            echo "Invalid image format";
            exit();
        }
    } else {
        $imagePath = null; 
    }

    // Save the user data to the text file
    $userData = "Username: $username\nPassword: $password\nEmail: $email\nRoom: $room\nExtension: $ext\nProfile Picture: $imagePath\n\n";
    
    // Open the file and save the data
    $file = fopen('users.txt', 'a');  
    if ($file) {
        fwrite($file, $userData);  
        fclose($file);
        // echo "Registration successful! <a href='add_user.php'>Go to Add User</a>";
    } else {
        echo "Failed to save user data.";
    }
}
?>



<style>/* Global reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 20px;
    text-align: center;
}

/* Header and footer styles */
header, footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 15px;
    width: 100%;
}

/* Main content styling */
.main-content {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-grow: 1;
    width: 100%;
    margin-top: 20px;
}

/* Form container */
.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 500px;  /* Limit form width */echo "The email address '$email' is
    width: auto;
    text-align: left;  /* Align the text left inside the form */
}

/* Heading inside form */
.form-container h1 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

/* Form Group */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
    color: #555;
}

.form-group input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-group input:focus {
    outline: none;
    border-color: #4caf50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.2);
}

/* Button styling */
button {
    padding: 10px 20px;
    background-color: #4caf50;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049;
}

/* Reset button styling */
button[type="reset"] {
    background-color: #f44336;
}

button[type="reset"]:hover {
    background-color: #e53935;
}

/* Profile Picture input field */
input[type="file"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
}

/* Adjustments for small screens */
@media (max-width: 768px) {
    .form-container {
        padding: 15px;
        width: 100%;
        max-width: 400px; /* Adjust for smaller screens */
    }

    .form-group input {
        padding: 8px;
        font-size: 14px;
    }

    button {
        width: 100%;
        margin-bottom: 10px;
    }

    button[type="reset"] {
        width: 100%;
    }
}


</style>
<?php
include('header.php');
?>
<img src="images/cat.jpeg" alt="">
<form action="register.php" method="POST" enctype="multipart/form-data">
    <!-- Name Field -->
    <div class="form-group">
        <label for="username">Name</label>
        <input type="text" id="username" name="username" required>
    </div>

    <!-- Email Field -->
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>

    <!-- Password Field -->
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>

    <!-- Confirm Password Field -->
    <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
    </div>

    <!-- Room Field -->
    <div class="form-group">
        <label for="room">Room</label>
        <input type="text" id="room" name="room">
    </div>

    <!-- Extension Field -->
    <div class="form-group">
        <label for="ext">Extension</label>
        <input type="text" id="ext" name="ext">
    </div>

    <!-- Profile Picture -->
    <div class="form-group">
        <label for="profile-pic">Profile Picture</label>
        <input type="file" id="profile-pic" name="profile-pic" accept="image/*">
    </div>

    <!-- Submit and Reset Buttons -->
    <div class="form-group">
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </div>
<script>
    document.getElementById('sign-in-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // After successful login, show the profile picture
    document.getElementById('profile-pic').style.display = 'block';
    document.getElementById('profile-pic').innerHTML = '<img src="path/to/profile-picture.jpg" alt="Profile Picture">';
});
</script>
</form>

<?php
include('footer.php');
?>
