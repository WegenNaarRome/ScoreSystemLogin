<?php
    session_start();
    include("../../includes/connection.php");

    $game = $_POST["game"];
    $Title = $_POST["Title"];
    $Rules = $_POST["Rules"];


    $query = mysqli_prepare($connection, "UPDATE games SET Titel = ?, Regels = ? WHERE Id = ?");
    mysqli_stmt_bind_param($query, 'ssi', $Title, $Rules, $game);
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    header("Location: {$_SESSION['last_page']}");
?>