<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

$conn = new mysqli (DB_HOST, DB_USER , DB_PASS, DB_NAME);

if($conn == false){
    echo "not connected". $conn->error;
}

?>