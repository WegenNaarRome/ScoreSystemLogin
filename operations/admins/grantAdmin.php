<?php
    session_start();
    include("../../includes/connection.php");
    $users = json_decode($_POST['users'], true);
    $role = $_POST['role'];
    
    foreach($users as $user){
        $query = mysqli_prepare($connection, "UPDATE users SET Rol = ? WHERE Id = ?");
        mysqli_stmt_bind_param($query, 'si', $role, $user);
        mysqli_stmt_execute($query);
        mysqli_stmt_close($query);
    }
    header("Location: {$_SESSION['last_page']}");
?>