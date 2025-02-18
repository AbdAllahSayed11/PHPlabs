<?php
// Include DB connection
include_once 'DB.php';
$database = new Database();
$DB = $database->getConnection();

// Fetch all users from the student table
$query = "SELECT * FROM student";
$stmt = $DB->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Profile Picture</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['student_id']); ?></td>
                <td><?php echo htmlspecialchars($user['f_name']); ?></td>
                <td><?php echo htmlspecialchars($user['l_name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <img src="<?php echo htmlspecialchars($user['imag']); ?>" alt="Profile Picture" width="50" height="50">
                </td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> | 
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
