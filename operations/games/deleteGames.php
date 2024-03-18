<?php
    include("../../includes/connection.php");
    $games = json_decode($_POST['games'], true);
    
    foreach($games as $game){
        $query = mysqli_prepare($connection, "DELETE FROM games WHERE Id = ?");
        mysqli_stmt_bind_param($query, 's', $game);
        mysqli_stmt_execute($query);
        mysqli_stmt_close($query);
    }
    header("Location: ../../admin-pages/spellen.php");
?>