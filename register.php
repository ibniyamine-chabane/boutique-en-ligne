<?php
require_once("src/class/users.php");
$user = new users;

<<<<<<< HEAD
var_dump($user);

=======
>>>>>>> f3972328dd6ce00cbbf7d90c437dda109c677ff4
if (isset($_POST['submit'])) {

    if ($_POST['email'] && $_POST['firstname'] && $_POST['lastname'] && $_POST['password'] && $_POST['password_confirm']) {
     
        if ($_POST['password'] == $_POST['password_confirm']) {

            $email = htmlspecialchars(trim($_POST['email']));
            $firstname = htmlspecialchars(trim($_POST['firstname']));
            $lastname =  htmlspecialchars(trim($_POST['lastname']));
            $password =  htmlspecialchars(trim($_POST['password']));
            $user->register($email, $firstname, $lastname, $password);

        }else {
            echo "les mot de passe ne correspond pas";
        }    

    } else {
        echo "veuillez remplir tout les champs"; 
    } 
} 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
    <div></div>
    <section>
        <div>
            <h2>Inscription</h2>
            <form action="" method="post"> <!-- le formulaire d'inscription -->
                <label for="email">email</label>
                <input type="email" name="email">
                <label for="firstname">prénom</label>
                <input type="text" name="firstname">
                <label for="lastname">lastname</label>
                <input type="lastname" name="lastname">
                <label for="password">mot de passe</label>
                <input type="password" name="password">
                <label for="password_confirm">confirmer mot de passe</label>
                <input type="password" name="password_confirm">
                <input type="submit" name="submit" value="valider">
            </form>
        </div>
    </section> 
    </main>   
</body>
</html>