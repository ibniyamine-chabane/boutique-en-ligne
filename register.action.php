<?php 

require_once("src/class/users.php");
$user = new users;

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