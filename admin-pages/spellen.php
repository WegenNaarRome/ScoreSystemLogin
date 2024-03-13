<?php
    include("../includes/connection.php");
    include("../includes/breadcrumbs.php");

    $games = array();
    $sql = "SELECT Id, Titel, Regels FROM games";
    $query = mysqli_prepare($connection, $sql);
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $Id, $Title, $Rules);
    while (mysqli_stmt_fetch($query)) {
        $row = array(
            'Id' => $Id,
            'Title' => $Title,
            'Rules' => $Rules,
        );

        $games[] = $row;
    }
    mysqli_stmt_close($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spellen beheren</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/root.css">
    <link rel="stylesheet" href="css/spellen.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
      <h1>
        Spellen beheren
      </h1>
    </header>
    <main>
    <section>
        <div class="content">
        <?php
            foreach($games as $game){
                echo "<div class='game'>";
                echo "<div class='TitleContainer'>";
                echo "<input type='checkbox' id='{$game['Id']}'>";
                echo "<p class='Title'>{$game['Title']}</p>"; 
                echo "<span class=\"material-symbols-outlined edit\">
                edit</span>";
                echo "</div>";
                echo "<div class='Description' style='display: none;'>";
                echo "<p class='Rules'>{$game['Rules']}</p>"; 
                echo "</div>";
                echo "</div>";
            }
        ?>
        </div>
        </section>
    </main>
    <footer></footer>
</body>
</html>

<script>
    let Title = document.querySelector(".Title");
    Title.addEventListener("click", (event)=>{
    let trigger = event.target;
    let description = trigger.parentNode.nextElementSibling;

    if(description.style.display == "none"){
        description.style.display = "flex";
    }
    else{
        description.style.display = "none";
    }

    //object.style.cssproperty = value;
    });

    document.addEventListener("DOMContentLoaded", () =>{
    // let checkboxes = document.querySelectorAll("input[type='checkbox']");
    // for(let checkbox of checkboxes){
    //     checkbox.addEventListener("click", selectUser);
    // }
    let edits = document.querySelectorAll(".edit");
    for(let edit of edits){
        edit.addEventListener("click", showUpdateGameForm);
    }
});

function hideUpdateGameForm(){
    if (document.getElementById("updateGameForm")){
        document.getElementById("updateGameForm").remove();
    }
}

function showUpdateGameForm(event){
    if(!document.getElementById("updateGameForm")){
        let edit = event.target;
        let form = document.createElement("form");
        form.setAttribute("action", "../operations/games/updateGame.php");
        form.setAttribute("method", "POST");
        form.setAttribute("id", "updateGameForm");

        let p = document.createElement("p");
        p.textContent = "Game Bijwerken";

        form.appendChild(p);

        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "game");
        input.value = edit.parentNode.querySelector("input[type='checkbox']").id;
        
        form.appendChild(input);

        let fields = ["Title", "Rules"];
        let fieldTexts = ["Titel", "Spelregels"];
        let label;

        for (let x = 0; x < fields.length; x++){
            label = document.createElement("label");
            label.setAttribute("for", fields[x]);
            label.textContent = fieldTexts[x];
            form.appendChild(label);

            input = document.createElement("input");
            input.setAttribute("id", fields[x]);
            input.setAttribute("name", fields[x]);
            input.value = edit.parentNode.parentNode.querySelector(`.${fields[x]}`).textContent;
            form.appendChild(input);
        }

        let div = document.createElement("div");
        let button = document.createElement("button");
        button.textContent = "Annuleren";
        button.addEventListener("click", () =>{
            form.remove();
        });

        input = document.createElement("input");
        input.setAttribute("type", "submit");
        div.appendChild(button);
        div.appendChild(input);

        form.appendChild(div);
        document.body.appendChild(form);
    }
}
</script>