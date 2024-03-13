<?php
    session_start();
    if (isset($_SESSION["last_page"])){
        echo "<nav>";
        echo "<a href='../'><span class='material-symbols-outlined'>home</span></a>";
        echo "<a href='{$_SESSION['last_page']}'><span class='material-symbols-outlined'>arrow_back</span></a>";
        echo "</nav>";
    }

    $currentURL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $currentURL .= $_SERVER['HTTP_HOST'];
    $currentURL .= $_SERVER['REQUEST_URI'];

    $_SESSION["last_page"] = $currentURL;
?>



