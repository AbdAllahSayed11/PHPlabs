<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hardcoded username and password
    $username = "asd";
    $password = "123";

    // Get submitted values
    $submittedUsername = $_POST['username'];
    $submittedPassword = $_POST['password'];
// var_dump($submittedPassword);
// var_dump($password);
// var_dump($username);
// var_dump($submittedUsername);
    // Check if credentials match
    if ($submittedUsername == $username && $submittedPassword == $password) {
        $_SESSION['username'] = $submittedUsername;
        header('Location: home.php');
        exit();
    } else {
        echo "<p style='color:red;'>Invalid username or password. Please try again.</p>";
    }
}

include('header.php');
?>

<!-- Main content (registration form) -->
<div class="main-content">
    <div class="form-container">
        <h2>Login Form for cafetera</h2> <br><br>
        <form method="POST" > <!-- we dont -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</div>

<?php
// Include footer
include('footer.php');
?>
