<?php
if(empty($_SESSION['email'])){
   echo "<script>window.location.href='../../auth/login.php' </script>";
}

?>