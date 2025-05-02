<?php
session_start();
ob_start();
$first_name = $_SESSION['first_name'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome patient</h1>
    <a href="logout.php">Logout</a>
    <a href="appointments.php">Appointments</a>
    <?php echo $first_name?>
</body>
</html>