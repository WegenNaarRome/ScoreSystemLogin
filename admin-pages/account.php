<?php
    include("../includes/connection.php");
    include("../includes/breadcrumbs.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts beheren</title>
    <link rel="stylesheet" href="css/account.css">
</head>
<body>
    <header>
        <h1>Accounts beheren</h1>
    </header>
    <main>
        <section>
            <h2>Admins</h2>
            <div id="headers">
                <h3>Voornaam</h3>
                <h3>Tussenvoegsel</h3>
                <h3>Achternaam</h3>
                <h3>Email</h3>
                <h3>Opleiding</h3>
                <h3>Aangemaakt</h3>
            </div>
            <div class="content">
            <?php
                $sql = "SELECT Voornaam, Tussenvoegsel, Achternaam, Email, Opleiding, Aangemaakt FROM beheerders";
                $query = mysqli_prepare($connection, $sql);
                mysqli_stmt_execute($query);
                mysqli_stmt_bind_result($query, $Voornaam, $Tussenvoegsel, $Achternaam, $Email, $Opleiding, $Aangemaakt);
                while (mysqli_stmt_fetch($query)) {
                    echo "<div class='admin'>";
                        echo "<p>{$Voornaam}</p>"; 
                        echo "<p>{$Tussenvoegsel}</p>"; 
                        echo "<p>{$Achternaam}</p>"; 
                        echo "<p>{$Email}</p>"; 
                        echo "<p>{$Opleiding}</p>"; 
                        echo "<p>{$Aangemaakt}</p>"; 
                    echo "</div>";
                }
                mysqli_stmt_close($query);
            ?>
            </div>
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>

<?php

?>