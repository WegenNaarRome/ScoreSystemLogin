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
        <nav>
            <?php
            require_once("../includes/breadcrumbs.php");
            ?>
        </nav>
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
            <span class="material-symbols-outlined add">add</span>
        </div>
        </section>
    </main>
    <footer></footer>
</body>
</html>

<script>
let games_selected = [];

let titles = document.querySelectorAll(".Title");
let last_description_visible;

for (let title of titles){
    title.addEventListener("click", (event)=>{
        let trigger = event.target;
        let description = trigger.parentNode.nextElementSibling;
    
        if(description.style.display == "none"){
            if(last_description_visible){
                last_description_visible.style.display = "none";
            }
            description.style.display = "flex";
            last_description_visible = description;
        }
        else{
            description.style.display = "none";
        }
    });
}

document.addEventListener("DOMContentLoaded", () =>{
    let checkboxes = document.querySelectorAll("input[type='checkbox']");
    for(let checkbox of checkboxes){
        checkbox.addEventListener("click", selectGame);
    }
    let edits = document.querySelectorAll(".edit");
    for(let edit of edits){
        edit.addEventListener("click", showUpdateGameForm);
    }
    let add = document.querySelector(".add");
    add.addEventListener("click", showAddGameForm);
});

function showAddGameForm(){
    hideDeleteGamesPrompt();
    hideUpdateGameForm();
    hideMenu();
    if(!document.getElementById("addGameForm")){
        let form = document.createElement("form");
        form.setAttribute("action", "../operations/games/addGame.php");
        form.setAttribute("method", "POST");
        form.setAttribute("id", "addGameForm");

        let p = document.createElement("p");
        p.textContent = "Game Toevoegen";

        form.appendChild(p);
        
        let fields = ["Title", "Rules"];
        let fieldTexts = ["Titel", "Spelregels"];
        let label;
        let input;

        for (let x = 0; x < fields.length; x++){
            label = document.createElement("label");
            label.setAttribute("for", fields[x]);
            label.textContent = fieldTexts[x];
            form.appendChild(label);

            input = document.createElement("input");
            input.setAttribute("id", fields[x]);
            input.setAttribute("name", fields[x]);
            input.setAttribute("type", "text");
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

function hideAddGameForm(){
    if (document.getElementById("addGameForm")){
        document.getElementById("addGameForm").remove();
    }
}

function selectGame(event){
    let checkbox = event.target;
    if (checkbox.checked){
        games_selected.push(checkbox.id);
    }
    else{
        let index = games_selected.indexOf(checkbox.id);
        games_selected.splice(index, 1);
    }
    console.log(games_selected);

    if (!document.getElementById("gameOperations")){
        if (games_selected.length > 0){
            showMenu();
            let deleteGames = document.getElementById("deleteGames");
            deleteGames.addEventListener("click", showDeleteGamesPrompt);
        }
    }
    else{
        if (games_selected.length == 0){
            document.getElementById("gameOperations").remove();
            hideDeleteGamesPrompt();
        }
        else{
            let games = document.querySelectorAll(".games");
            if(games.length > 0){
                for(let game of games){
                    game.value = JSON.stringify(games_selected);
                }
            }
            let deleteGames = document.getElementById("deleteGames");
            deleteUsers.addEventListener("click", showDeleteGamesPrompt);
        }
    }
}

function showMenu(){
    hideUpdateGameForm();
    hideAddGameForm();
    let div = document.createElement("div");
    div.setAttribute("id", "gameOperations");

    let span = document.createElement("span");
    span.setAttribute("class", "material-symbols-outlined");
    span.setAttribute("id", "deleteGames");
    span.textContent = "delete";

    div.appendChild(span);

    let main = document.querySelector("main");
    main.insertBefore(div, main.firstChild);
}

function hideUpdateGameForm(){
    if (document.getElementById("updateGameForm")){
        document.getElementById("updateGameForm").remove();
    }
}

function hideMenu(){
    if (document.getElementById("gameOperations")){
        document.getElementById("gameOperations").remove();
    }
}

function showUpdateGameForm(event){
    hideDeleteGamesPrompt();
    hideAddGameForm();
    hideMenu();
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

function showDeleteGamesPrompt(){
    hideUpdateGameForm();
    hideAddGameForm();
    if(!document.getElementById("deleteGamesForm")){
        let form = document.createElement("form");
        form.setAttribute("action", "../operations/games/deleteGames.php");
        form.setAttribute("method", "POST");
        form.setAttribute("id", "deleteGamesForm");

        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "games");
        input.setAttribute("class", "games");
        input.value = JSON.stringify(games_selected);
        
        form.appendChild(input);

        let p = document.createElement("p");
        p.textContent = "Weet je zeker dat je deze games wilt verwijderen?";
        form.appendChild(p);

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

function hideDeleteGamesPrompt(){
    if (document.getElementById("deleteGamesForm")){
        document.getElementById("deleteGamesForm").remove();
    }
}
</script>