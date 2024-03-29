<?php
    include("../includes/connection.php");

    $admins = array();
    $users = array();
    $sql = "SELECT Id, Voornaam, Tussenvoegsel, Achternaam, Email, Opleiding, Rol, Geblokkeerd, Aangemaakt FROM users";
    $query = mysqli_prepare($connection, $sql);
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $Id, $FirstName, $Infix, $LastName, $Email, $Education, $Role, $Blocked, $CreationDate);
    while (mysqli_stmt_fetch($query)) {
        $row = array(
            'Id' => $Id,
            'FirstName' => $FirstName,
            'Infix' => $Infix,
            'LastName' => $LastName,
            'Email' => $Email,
            'Education' => $Education,
            'Blocked' => $Blocked,
            'CreationDate' => $CreationDate
        );
        if ($Role == "Beheerder"){
            $admins[] = $row;
        }
        else{
            $users[] = $row; 
        }
    }
    mysqli_stmt_close($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts beheren</title>
    <link rel="stylesheet" href="css/account.css">
    <link rel="stylesheet" href="../css/root.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
        <h1>Accounts beheren</h1>
    </header>
    <main>
        <section>
            <h2>Beheerders</h2>
            <?php
                if (count($admins) > 0){
                    echo "<div class=\"headers\">";
                    echo "<h3>Naam</h3>";
                    echo "<h3>Email</h3>";
                    echo "<h3>Opleiding</h3>";
                    echo "<h3>Aangemaakt</h3>";
                    echo "</div>";
                }
            ?>
            <div class="content">
            <?php
                foreach($admins as $admin){
                    echo "<div class='admin'>";
                    echo "<input type='checkbox' id='{$admin['Id']}'>";
                    echo "<p class='Name'>{$admin['FirstName']} {$admin['Infix']} {$admin['LastName']}</p>"; 
                    echo "<p class='FirstName'>{$admin['FirstName']}</p>"; 
                    echo "<p class='Infix'>{$admin['Infix']}</p>"; 
                    echo "<p class='LastName'>{$admin['LastName']}</p>"; 
                    echo "<p class='Email'>{$admin['Email']}</p>"; 
                    echo "<p class='Education'>{$admin['Education']}</p>"; 
                    echo "<p class='Blocked' blocked='{$admin['Blocked']}'>{$admin['Blocked']}</p>";
                    echo "<p class='CreationDate'>{$admin['CreationDate']}</p>"; 
                    echo "<span class=\"material-symbols-outlined edit\">
                    edit</span>";
                    echo "</div>";
                }
                if (count($admins) == 0){
                    echo "<p>Nog geen beheerders</p>";
                }
            ?>
            </div>
        </section>
        <section>
            <h2>Gebruikers</h2>
            <?php
                if (count($users) > 0){
                    echo "<div class=\"headers\">";
                    echo "<h3>Naam</h3>";
                    echo "<h3>Email</h3>";
                    echo "<h3>Opleiding</h3>";
                    echo "<h3>Aangemaakt</h3>";
                    echo "</div>";
                }
            ?>
            <div class="content">
            <?php
                foreach($users as $user){
                    echo "<div class='admin'>";
                    echo "<input type='checkbox' id='{$user['Id']}'>";
                    echo "<p class='Name'>{$user['FirstName']} {$user['Infix']} {$user['LastName']}</p>"; 
                    echo "<p class='FirstName'>{$user['FirstName']}</p>"; 
                    echo "<p class='Infix'>{$user['Infix']}</p>"; 
                    echo "<p class='LastName'>{$user['LastName']}</p>"; 
                    echo "<p class='Email'>{$user['Email']}</p>"; 
                    echo "<p class='Education'>{$user['Education']}</p>"; 
                    echo "<p class='Blocked' blocked='{$user['Blocked']}'>{$user['Blocked']}</p>";
                    echo "<p class='CreationDate'>{$user['CreationDate']}</p>"; 
                    echo "<span class=\"material-symbols-outlined edit\">
                    edit</span>";
                    echo "</div>";
                }
                if (count($users) == 0){
                    echo "<p>Nog geen gebruikers</p>";
                }
            ?>
            </div>
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>

<script>
let users_selected = [];

document.addEventListener("DOMContentLoaded", () =>{
    let checkboxes = document.querySelectorAll("input[type='checkbox']");
    for(let checkbox of checkboxes){
        checkbox.addEventListener("click", selectUser);
    }
    let edits = document.querySelectorAll(".edit");
    for(let edit of edits){
        edit.addEventListener("click", showUpdateUserForm);
    }
});

function hideUpdateUserForm(){
    if (document.getElementById("updateUserForm")){
        document.getElementById("updateUserForm").remove();
    }
}

function showUpdateUserForm(event){
    hideDeleteUsersPrompt();
    hideGrantAdminOptions();
    hideBlockUsersPrompt();
    hideMenu();
    if(!document.getElementById("updateUserForm")){
        let edit = event.target;
        let form = document.createElement("form");
        form.setAttribute("action", "../operations/admins/updateUser.php");
        form.setAttribute("method", "POST");
        form.setAttribute("id", "updateUserForm");

        let p = document.createElement("p");
        p.textContent = "Account Bijwerken";

        form.appendChild(p);

        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "user");
        input.value = edit.parentNode.querySelector("input[type='checkbox']").id;
        
        form.appendChild(input);

        let fields = ["FirstName", "Infix", "LastName", "Email", "Education"];
        let fieldTexts = ["Voornaam", "Tussenvoegsel", "Achternaam", "Email", "Opleiding"];
        let label;

        for (let x = 0; x < fields.length; x++){
            label = document.createElement("label");
            label.setAttribute("for", fields[x]);
            label.textContent = fieldTexts[x];
            form.appendChild(label);

            input = document.createElement("input");
            input.setAttribute("id", fields[x]);
            input.setAttribute("name", fields[x]);
            input.value = edit.parentNode.querySelector(`.${fields[x]}`).textContent;
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

function selectUser(event){
    let checkbox = event.target;
    if (checkbox.checked){
        users_selected.push(checkbox.id);
    }
    else{
        let index = users_selected.indexOf(checkbox.id);
        users_selected.splice(index, 1);
    }
    console.log(users_selected);

    if (!document.getElementById("adminOperations")){
        if(users_selected.length > 0){
            showMenu();
            let grantAdmin = document.getElementById("grantAdmin");
            grantAdmin.addEventListener("click", showGrantAdminOptions);
            let deleteUsers = document.getElementById("deleteUsers");
            deleteUsers.addEventListener("click", showDeleteUsersPrompt);
            let blockUsers = document.getElementById("blockUsers")
            blockUsers.addEventListener("click", (showBlockUsersPrompt));
        }
    }
    else{
        if (users_selected.length == 0){
            document.getElementById("adminOperations").remove();
            hideGrantAdminOptions();
            hideDeleteUsersPrompt();
            hideBlockUsersPrompt();
        }
        else{
            let users = document.querySelectorAll(".users");
            if(users.length > 0){
                for(let user of users){
                    user.value = JSON.stringify(users_selected);
                }
            }
            let grantAdmin = document.getElementById("grantAdmin");
            grantAdmin.addEventListener("click", showGrantAdminOptions);
            let deleteUsers = document.getElementById("deleteUsers");
            deleteUsers.addEventListener("click", showDeleteUsersPrompt);
            let blockUsers = document.getElementById("blockUsers")
            blockUsers.addEventListener("click", (showBlockUsersPrompt));
        }
    }
}

function hideGrantAdminOptions(){
    if (document.getElementById("grantAdminForm")){
        document.getElementById("grantAdminForm").remove();
    }
}

function showGrantAdminOptions(){
    hideDeleteUsersPrompt();
    hideUpdateUserForm();
    hideBlockUsersPrompt();
    if(!document.getElementById("grantAdminForm")){
        let form = document.createElement("form");
        form.setAttribute("action", "../operations/admins/grantAdmin.php");
        form.setAttribute("method", "POST");
        form.setAttribute("id", "grantAdminForm");

        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "users");
        input.setAttribute("class", "users");
        input.value = JSON.stringify(users_selected);
        
        form.appendChild(input);

        let label = document.createElement("label");
        label.setAttribute("for", "Role");
        label.textContent = "Rol Toekennen";

        form.appendChild(label);

        let select = document.createElement("select");
        select.setAttribute("name", "role");
        select.setAttribute("id", "Role");

        let suggestions = ["Gebruiker", "Beheerder"];
        for (let suggestion of suggestions){
            let option = document.createElement("option");
            option.setAttribute("value", suggestion);
            option.textContent = suggestion;
            select.appendChild(option);
        }

        form.appendChild(select);

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

function showDeleteUsersPrompt(){
    hideGrantAdminOptions();
    hideUpdateUserForm();
    hideBlockUsersPrompt();
    if(!document.getElementById("deleteUsersForm")){
        let form = document.createElement("form");
        form.setAttribute("action", "../operations/admins/deleteUsers.php");
        form.setAttribute("method", "POST");
        form.setAttribute("id", "deleteUsersForm");

        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "users");
        input.setAttribute("class", "users");
        input.value = JSON.stringify(users_selected);
        
        form.appendChild(input);

        let p = document.createElement("p");
        p.textContent = "Weet je zeker dat je deze gebruikers wilt verwijderen?";
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

function showBlockUsersPrompt(){
    hideGrantAdminOptions();
    hideUpdateUserForm();
    hideDeleteUsersPrompt();
    if(!document.getElementById("blockUsersForm")){
        let form = document.createElement("form");
        form.setAttribute("action", "../operations/admins/blockUsers.php");
        form.setAttribute("method", "POST");
        form.setAttribute("id", "blockUsersForm");

        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "users");
        input.setAttribute("class", "users");
        input.value = JSON.stringify(users_selected);
        
        form.appendChild(input);

        let label = document.createElement("label");
        label.setAttribute("for", "Status");

        form.appendChild(label);

        let select = document.createElement("select");
        select.setAttribute("name", "Status");
        select.setAttribute("id", "Status");

        let suggestions = ["Blokkeren", "Deblokkeren"];
        for (let suggestion of suggestions){
            let option = document.createElement("option");
            option.setAttribute("value", suggestion);
            option.textContent = suggestion;
            select.appendChild(option);
        }

        form.appendChild(select);

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

function hideBlockUsersPrompt(){
    if (document.getElementById("blockUsersForm")){
        document.getElementById("blockUsersForm").remove();
    }
}

function hideDeleteUsersPrompt(){
    if (document.getElementById("deleteUsersForm")){
        document.getElementById("deleteUsersForm").remove();
    }
}

function hideMenu(){
    if (document.getElementById("adminOperations")){
        document.getElementById("adminOperations").remove();
    }
}

function showMenu(){
    hideUpdateUserForm();
    let div = document.createElement("div");
    div.setAttribute("id", "adminOperations");

    let span = document.createElement("span");
    span.setAttribute("class", "material-symbols-outlined");
    span.setAttribute("id", "grantAdmin");
    span.textContent = "shield_person";

    div.appendChild(span);

    span = document.createElement("span");
    span.setAttribute("class", "material-symbols-outlined");
    span.setAttribute("id", "deleteUsers");
    span.textContent = "delete";

    div.appendChild(span);

    span = document.createElement("span");
    span.setAttribute("class", "material-symbols-outlined");
    span.setAttribute("id", "blockUsers");
    span.textContent = "block";

    div.appendChild(span);

    let main = document.querySelector("main");
    main.insertBefore(div, main.firstChild);
}
</script>
