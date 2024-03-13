<?php
    session_start();
    include("../../includes/connection.php");

    $user = $_POST["user"];
    $FirstName = $_POST["FirstName"];
    $Infix = $_POST["Infix"];
    $LastName = $_POST["LastName"];
    $Email = $_POST["Email"];
    $Education = $_POST["Education"];

    $query = mysqli_prepare($connection, "UPDATE users SET Voornaam = ?, Tussenvoegsel = ?, Achternaam = ?, Email = ?, Opleiding = ? WHERE Id = ?");
    mysqli_stmt_bind_param($query, 'ssssss', $FirstName, $Infix, $LastName, $Email, $Education, $user);
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    header("Location: {$_SESSION['last_page']}");
?>