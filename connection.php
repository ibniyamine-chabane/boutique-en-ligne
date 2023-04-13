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
    <title>Document</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <div></div>
    <section>
        <div>
            <h2>Connexion</h2>
            <form action="" method="post">
                <label for="email">email</label>
                <input type="email" name="email" required>
                <label for="password">password</label>
                <input type="password" name="password" required>
                <input type="submit" name="submit" value="valider">
            </form>
        </div>
    </section>
    </main>
    <footer>

    </footer>
</body>
</html>