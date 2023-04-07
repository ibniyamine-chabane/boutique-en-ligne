<?php 

include('C:\wamp64\www\boutique-en-ligne\scr\class\users.php');

// Vérification si le formulaire a été soumis
if(isset($_POST['submit'])){

    // Vérification des données du formulaire
    if(isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['password']) ) {
        $email = htmlspecialchars($_POST['email'],ENT_QUOTES);
        $firstname = htmlspecialchars($_POST['firstname'],ENT_QUOTES);
        $lastname = htmlspecialchars($_POST['lastname'],ENT_QUOTES);
        $password = htmlspecialchars($_POST['password'],ENT_QUOTES);

        // Instanciation de l'objet "users"
        $user = new users();

        // Vérification si l'email est déjà utilisé
        $emailOk = $user->checkEmail($email);

        if($emailOk) {
            // Enregistrement du nouvel utilisateur
            $user->register($email, $firstname, $lastname, $password,);
        } else {
            echo "Cette adresse email est déjà utilisée.";
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
    <title>inscription</title>
</head>
<body>
    <header>

    </header>
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
                <input type="submit" value="valider">
            </form>
        </div>
    </section>    
</body>
</html>