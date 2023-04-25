<?php
session_start();
//var_dump($_SESSION["rights"]);
require_once("src/class/users.php");
require_once("src/class/cartClass.php");
$user = new users;
// var_dump($user->getProfil());  
$userDb = $user->getProfil()[0];
//echo $userDb['email'];
$prefilled_email = $userDb["email"];
$prefilled_firstname = $userDb["first_name"];
$prefilled_lastname = $userDb["last_name"];
$current_password = $userDb["password"]; // c'est le mdp actuelle de l'utilisateur dans la BDD

$cart = new cart;
$cartDb = $cart->getCartProductsByUserId($_SESSION['id_user']);
// var_dump($cartDb);

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
            echo "erreur";
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
    <link rel="stylesheet" href="src/css/style.css">
    <title>profil</title>
</head>
<body>
    <?php require_once("header.php"); ?>    
    <main>
        <section>
            <div class="container-register">
                <h2>profil</h2>
                <div class="container-form-register">
                    <form action="" method="post">
                        <label for="email">email</label>
                        <input type="email" name="email" value="<?= $prefilled_email ?>" >
                        <label for="firstname">prénom</label>
                        <input type="text" name="firstname" value="<?= $prefilled_firstname ?>">
                        <label for="lastname">lastname</label>
                        <input type="lastname" name="lastname" value="<?= $prefilled_lastname ?>">
                        <label for="current_password">mot de passe actuelle (valider votre mdp si vous voulez seulement modifier les infos ci dessus)</label><!-- mot de passe actuel -->
                        <input type="password" name="current_password">
                        <label for="new_password">nouveau mot de passe</label><!-- nouveau mot de passe -->
                        <input type="password" name="new_password">
                        <label for="password_confirm">confirmer mot de passe</label><!-- confirmer le nouveu mdp -->
                        <input type="password" name="password_confirm">
                        <input type="submit" name="submit" value="valider" class="button">
                    </form>
                </div>    
            </div>
        </section>
        <section>
    
        </section> 
        <section>
            <div class="container-cart-profil">
                <h2>mon panier</h2>
            <div class="container-table">
                <table id="cart">
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>total</th>
                </tr>
                <?php foreach ($cartDb as $cart) :?> 
                <tr>     
                    <td><?= $cart['name'] ?><img src="src/upload/<?= $cart['image'] ?>" width="100px" style="margin-left:66px;" alt=""> </td>
                    <td><?= $cart['price'] ?></td>
                    <td><?= $cart['quantity'] ?></td>
                    <td><?= $cart['amount'] ?></td>
                </tr>
                <?php endforeach; ?>       
                </table>
            </div>
            
            </div>    
        </section>  
    </main>
    <?php require_once("footer.php"); ?>
</body>
</html>