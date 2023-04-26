<?php

session_start();

require_once("src/class/users.php");
$user = new users;
$userDb = $user->getProfil()[0];





?>
<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profil</title>
</head>
<body>
    <?php require_once("header.php"); ?>    
    <main>
        <section>
            <div>
                <h2>profil</h2>
                <form action="" method="post">
                    <label for="email">email</label>
                    <input type="email" name="email" value="<?= $prefilled_email ?>" >
                    <label for="firstname">prénom</label>
                    <input type="text" name="firstname" value="<?= $prefilled_firstname ?>">
                    <label for="lastname">lastname</label>
                    <input type="lastname" name="lastname" value="<?= $prefilled_lastname ?>">
                    <label for="current_password">mot de passe actuelle</label><!-- mot de passe actuel -->
                    <input type="password" name="current_password">
                    <label for="new_password">nouveau mot de passe</label><!-- nouveau mot de passe -->
                    <input type="password" name="new_password">
                    <label for="password_confirm">confirmer mot de passe</label><!-- confirmer le nouveu mdp -->
                    <input type="password" name="password_confirm">
                    <input type="submit" name="submit" value="valider">
                </form>
            </div>
        </section>
        <section>
    
        </section> 
        <section>
            
        </section>  
    </main>
</body>
</html>