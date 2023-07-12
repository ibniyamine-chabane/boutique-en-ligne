<?php

session_start();

if(isset($_SESSION['id_user']) && $_SESSION['rights'] != 'administrator') {
    header("Location: index.php");
    exit;
} elseif (!isset($_SESSION['id_user'])) {
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
