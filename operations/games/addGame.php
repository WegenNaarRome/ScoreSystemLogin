<?php
    include("../../includes/connection.php");

    $title = $_POST['Title'];
    $rules = $_POST['Rules'];
    
    $query = mysqli_prepare($connection, "INSERT INTO games (Titel, Regels) VALUES (?, ?)");
    mysqli_stmt_bind_param($query, 'ss', $title, $rules);
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    header("Location: ../../admin-pages/spellen.php");
?>