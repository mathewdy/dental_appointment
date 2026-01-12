<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Server is working.";
include 'config.php';
echo " Config loaded.";
include 'connection/connection.php';
echo " Connection loaded.";
?>