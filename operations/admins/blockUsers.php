<?php
    session_start();
    include("../../includes/connection.php");
    $users = json_decode($_POST['users'], true);
    $status = $_POST['Status']; //Deblokkeren of Blokkeren -> 0 1

    if ($status == "Deblokkeren"){
        $status = 0;
    }
    else{
        $status = 1;
    }
    
    foreach($users as $user){
        $query = mysqli_prepare($connection, "UPDATE users SET Geblokkeerd = ? WHERE Id = ?");
        mysqli_stmt_bind_param($query, 'ii', $status, $user);
        mysqli_stmt_execute($query);
        mysqli_stmt_close($query);
    }
    header("Location: {$_SESSION['last_page']}");
?>