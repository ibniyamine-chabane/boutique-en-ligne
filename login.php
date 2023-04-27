<?php 
session_start();
require_once("src/class/users.php");
$user = new users;

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $user->connection($email, $password);

}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css"> 
    <title>Document</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <div></div>
    <section>
        <div class="container-login">
            <div class="container-form-login">
            <h2>Connexion</h2>
                <form action="" method="post">
                    <label for="email">email</label>
                    <input type="email" name="email" required>
                    <label for="password">password</label>
                    <input type="password" name="password" required>
                    <input type="submit" name="submit" value="valider" class="button">
                </form>
            </div>
        </div>
    </section>
    </main>
    <?php require_once("footer.php"); ?>
</body>
</html>