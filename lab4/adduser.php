

<?php 
include('header.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
</head>
<body>

    <h2>Register Form</h2>
    <form action="validat.php" method="POST" >
    <label for="student_id"> student ID:</label><br>
    <input type="text" id="student_id" name="student_id" required><br><br>
        <label for="f_name">first name:</label><br>
        <input type="text" id="f_name" name="f_name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="l_name">last name :</label><br>
        <input type="text" id="l_name" name="l_name" required><br><br>

        <!-- <label for="intake_id">Intake ID:</label><br>
        <input type="number" id="intake_id" name="intake_id" required><br><br> -->
        <br><br>
        <button type="submit">Submit</button>
    </form>

</body>
</html>


<?php 
include('header.php');


?>
