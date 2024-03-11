<?php
    $address = "localhost";
    $username = "root";
    $password = "";
    $database = "scoresystemlogin";

    $connection = mysqli_connect($address, $username, $password, $database);

    if (!$connection){
        echo "<script>console.log(".mysqli_connect_error().");</script>";
    }
    else{
        echo "<script>console.log('Connection successful');</script>";
    }
?>
