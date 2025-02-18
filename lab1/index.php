<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "<h1>Now, It’s </h1>";

$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$username = $_POST['username'] ?? '';
$gender = $_POST['gender'] ?? '';
$address = $_POST['address'] ?? '';
$dep = $_POST['Department'] ?? '';

$skill1 = $_POST['skill_1'] ?? null;
$skill2 = $_POST['skill_2'] ?? null;
$skill3 = $_POST['skill_3'] ?? null;
$skill4 = $_POST['skill_4'] ?? null;

// Handle missing first name
if (empty($firstname)) {
    echo "First name is required.";
} else {
    if ($gender == "male") {
        echo "MR " . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname);
    } else {
        echo "Miss " . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname);
    }
    echo "<br>";
    echo "Your name: " . htmlspecialchars($firstname);
    echo "<br>";
    echo "Address: " . htmlspecialchars($address);
    echo "<br>";
    echo "Department: " . htmlspecialchars($dep);
    echo "<br>";
    
    // echo "Skills: <br>" . htmlspecialchars($skill1) . "<br>" . htmlspecialchars($skill2) . "<br>" . htmlspecialchars($skill3) . "<br>" . htmlspecialchars($skill4);
}

if (isset($_GET['update'])) {
    $lineToUpdate = $_GET['update'];
    $lines = file("lab1.txt");
    $userData = explode(" ", $lines[$lineToUpdate]);

    $firstname = $userData[0] ?? '';
    $lastname = $userData[1] ?? '';
    $username = $userData[2] ?? '';
    $gender = $userData[3] ?? '';
    $address = $userData[4] ?? '';
    $dep = $userData[5] ?? '';
    $skill1 = $userData[6] ?? '';
    $skill2 = $userData[7] ?? '';
    $skill3 = $userData[8] ?? '';
    $skill4 = $userData[9] ?? '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $updatedData = $_POST['firstname'] . " " . $_POST['lastname'] . " " . $_POST['username'] . " " . $_POST['gender'] . " " . $_POST['address'] . " " . $_POST['Department'] . " " . $_POST['skill_1'] . " " . $_POST['skill_2'] . " " . $_POST['skill_3'] . " " . $_POST['skill_4'] . "\n";
    
    $lines = file("lab1.txt");
    $lines[$_POST['update_index']] = $updatedData;

    file_put_contents("lab1.txt", implode("", $lines));
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
// delete function 
if (isset($_GET['delete'])) {
    $lineToDelete = $_GET['delete'];
    $lines = file("lab1.txt");

    unset($lines[$lineToDelete]);
    
    file_put_contents("lab1.txt", implode("", $lines));
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

//  updating form 
if (isset($_GET['update'])) {
    echo "<form method='POST'>
            <input type='hidden' name='update_index' value='" . $_GET['update'] . "' />
            First Name: <input type='text' name='firstname' value='" . htmlspecialchars($firstname) . "' /><br>
            Last Name: <input type='text' name='lastname' value='" . htmlspecialchars($lastname) . "' /><br>
            Username: <input type='text' name='username' value='" . htmlspecialchars($username) . "' /><br>
            Gender: <input type='text' name='gender' value='" . htmlspecialchars($gender) . "' /><br>
            Address: <input type='text' name='address' value='" . htmlspecialchars($address) . "' /><br>
            Department: <input type='text' name='Department' value='" . htmlspecialchars($dep) . "' /><br>
            Skill 1: <input type='text' name='skill_1' value='" . htmlspecialchars($skill1) . "' /><br>
            Skill 2: <input type='text' name='skill_2' value='" . htmlspecialchars($skill2) . "' /><br>
            Skill 3: <input type='text' name='skill_3' value='" . htmlspecialchars($skill3) . "' /><br>
            Skill 4: <input type='text' name='skill_4' value='" . htmlspecialchars($skill4) . "' /><br>
            <input type='submit' name='update' value='Update' />
          </form>";
}

$mf = fopen("lab1.txt", "r");

echo "<table border='2'>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Username</th>
<th>Actions</th>
</tr>";

$index = 0; 
while ($line = fgets($mf)) {
    $userData = explode(" ", $line);
    
    if (count($userData) >= 3) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($userData[0]) . "</td>"; // First Name
        echo "<td>" . htmlspecialchars($userData[1]) . "</td>"; // Last Name
        echo "<td>" . htmlspecialchars($userData[2]) . "</td>"; // Username
        echo "<td><a href='?update=$index'>Update</a> | <a href='?delete=$index' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
        echo "</tr>";
    }
    $index++;
}

echo "</table>";

fclose($mf);
?>
