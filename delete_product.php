<?php

session_start();
if (!empty($_SESSION['email']) && $_SESSION['rights'] != "administrator") { // si l'utilisateur n'est pas connecté, il est rediriger vers la page d'accueil.php
    header("Location: index.php");
    exit;
}

require_once("src/class/users.php");
$user = new users;
$id_toDel = $_GET["id"];
echo $id_toDel;
$request = $user->getData()->prepare('DELETE FROM product WHERE id = (?)');
$request->execute(array($id_toDel));
header("Location: admin_dashboard.php");
//echo "yolo";
