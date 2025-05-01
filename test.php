<?php

$conn = new mysqli ("localhost", "root" , "", "dental_system");

if($conn == false){
    echo "not connected". $conn->error;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php

    $query_name = "SELECT * FROM users LIMIT 1";
    $run_name = mysqli_query($conn,$query_name);
    if(mysqli_num_rows($run_name) > 0){
       foreach($run_name as $row){
        ?>
            <form action="sample.php" method="POST">
                <input type="text" name="first_name" value="<?php echo $row['first_name']?>">
                <input type="text" name="last_name" value="<?php echo $row['last_name']?>">
                <input type="text" name="mobile_number" value="<?php echo $row['mobile_number']?>">
                <input type="text" name="email" value="<?php echo $row['email']?>">
                <input type="text" name="default_device" value="<?php echo $row['default_device']?>">
                <input type="text" name="auth">
                <button type="submit">Pay Now</button>
            </form>

        <?php
       }
    }

    ?>

   
</body>
</html>