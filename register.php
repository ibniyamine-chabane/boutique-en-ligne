<?php
require_once("src/class/users.php");
$user = new users;

$message = "";

if (isset($_POST['submit'])) {

    if ($_POST['email'] && $_POST['firstname'] && $_POST['lastname'] && $_POST['password'] && $_POST['password_confirm']) {
     
        if ($_POST['password'] == $_POST['password_confirm']) {

            $email = htmlspecialchars(trim($_POST['email']));
            $firstname = htmlspecialchars(trim($_POST['firstname']));
            $lastname =  htmlspecialchars(trim($_POST['lastname']));
            $password =  htmlspecialchars(trim($_POST['password']));
            $user->register($email, $firstname, $lastname, $password);
            $message = $user->getMessage();
            header('Location: login.php');
        }else {
            $message = "les mots de passe ne correspond pas";
        }    

    } else {
        $message = "veuillez remplir tout les champs"; 
    } 
} 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <script defer src="src\js\register.js"></script>
    <title>inscription</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
    <div></div>
    <section>
        <div class="container-register">
            <h2>Inscription</h2>
            <?php if (isset($message)) :?>
                <span class="msg" style="text-align: center;display: block;color: green;font-weight: bold;background-color: #ffffffa3;width: 58%;margin: auto;margin-top: 17px"><?= $message ?></span>
                <?php endif; ?>
            <div class="container-form-register">
                <form action="" method="post" id="register-form"> <!-- le formulaire d'inscription -->
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
                    <input type="submit" name="submit" value="valider" class="button">
                </form>
            </div>
        </div>
    </section> 
    </main>   
    <?php require_once("footer.php") ?>
</body>
</html>