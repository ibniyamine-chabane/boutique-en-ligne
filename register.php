





    







<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <title>inscription</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
    <div></div>
    <section>
        <div class="container-register">
        <form id="formulaire" method="post">
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
        <input id="button" type="submit" name="submit" value="valider">
    </form>
        <script  src="register.js"></script>
            </div>
        </div>
    </section> 
    </main>   
    <?php require_once("footer.php") ?>
</body>
</html>
