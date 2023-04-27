<?php
session_start();
require_once("src/class/users.php");
require_once("src/class/cartClass.php");
$select = new cart;
$user = new users;
$userDb = $user->getProfil()[0];
var_dump($userDb);
// var_dump($_SESSION['id_user']);
$idUserLoged = $userDb['id'];
// var_dump($idUserLoged);
if (!empty($_SESSION['email']) && $_SESSION['id_user'] != $idUserLoged) { // si l'utilisateur n'est pas connecté, il est rediriger vers la page d'accueil.php
    header("Location: index.php");
    exit;
}

$id_cart = $_GET["id_c"];
$id_product = $_GET["id_p"];

$request = $user->getData()->prepare('DELETE FROM cart WHERE id = (?) AND id_user = (?)');
$request->execute(array($id_cart, $_SESSION['id_user']));
$request = $user->getData()->prepare('DELETE FROM cart_product WHERE id_product = (?) AND id_cart = (?)');
$request->execute(array($id_product, $id_cart));
header("Location: cart.php");
?>