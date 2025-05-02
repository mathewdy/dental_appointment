<?php
include('../connection/connection.php');
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Dashboard admin</h2>

    <a href="add-dentist.php">Add Dentist</a>
    <a href="view-dentist.php">View Dentists</a>
    <a href="logout.php">Logout</a>
</body>
</html>