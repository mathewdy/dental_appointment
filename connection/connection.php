<?php

$conn = new mysqli ("localhost", "root" , "", "dental_system");

if($conn == false){
    echo "not connected". $conn->error;
}

?>