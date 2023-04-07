<?php
session_start();
//var_dump($_SESSION["rights"]);
require_once("src/class/users.php");
$user = new users;
var_dump($user->getProfil());  
$userDb = $user->getProfil()[0];
//echo $userDb['email'];
$prefilled_email = $userDb["email"];
$prefilled_firstname = $userDb["first_name"];
$prefilled_lastname = $userDb["last_name"];
$current_password = $userDb["password"]; // c'est le mdp actuelle de l'utilisateur dans la BDD

if (isset($_POST['submit'])) {

    if ($_POST['email'] && $_POST['firstname'] && $_POST['lastname'] && $_POST['current_password']) {
     
        if ($_POST['current_password'] == $current_password) {

            $email = htmlspecialchars(trim($_POST['email']));
            $firstname = htmlspecialchars(trim($_POST['firstname']));
            $lastname =  htmlspecialchars(trim($_POST['lastname']));
            $password =  htmlspecialchars(trim($_POST['current_password']));
            $user->updateProfil($email, $firstname, $lastname, $password);

        }else {
            echo "les mot de passe ne correspond pas";
        }    

    } else {
        echo "veuillez remplir tout les champs";
    } 

    if ($_POST['current_password'] && $_POST['new_password'] && $_POST['password_confirm']) {
        
        if($_POST['current_password'] == $current_password && $_POST['new_password'] == $_POST['password_confirm'] ) {

            $new_password = $_POST['new_password'];
            $user->changePassword($new_password);
            echo "le mot de passe a été modifier";

        } else if ($_POST['current_password'] != $current_password) {
            echo "erreur sur le mdp actuelle ";
        } else if ($_POST['new_password'] != $_POST['password_confirm']) {
            echo "les nouveau mdp et la confirmation ne sont pas identique";
        }
    }


} 



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