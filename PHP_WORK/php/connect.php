<?php
    $hostname = "localhost";
    $user = "root";
    $pwd = "";
    $db = "";
    $conn = mysqli_connect($hostname, $user ,$pwd ,$db)
        or die(mysqli_connect_error());
?>