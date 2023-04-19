<?php
session_start();
include('src\class\users.php');
include('src\class\cart.php');

$user_id = $_SESSION['id_user']; // Récupération de l'ID de l'utilisateur connecté

$cart = new Cart();
$products = $cart->getCartProductsByUserId($user_id); // Récupération des produits du panier de l'utilisateur

$total = 0; // initialisation de la variable total

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de la présence de l'id du produit à supprimer dans la requête POST
    if (isset($_POST['id_product']) && is_scalar($_POST['id_product'])) {
        $product_id = $_POST['id_product'];
        
        // Vérification de la présence de la quantité à supprimer dans la requête POST
        if (isset($_POST['quantity']) && is_scalar($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
            
            // Suppression du produit du panier
            $cart->removeProductFromCart($product_id, $quantity);
            
            // Redirection vers la page du panier
            header('Location: cart.php');
            exit();
        }
    }
    
    // Vérification de la présence de l'id du produit à supprimer dans la requête POST
    if (isset($_POST['remove_product_id']) && is_scalar($_POST['remove_product_id'])) {
        $product_id = $_POST['remove_product_id'];
        
        // Suppression du produit du panier
        $cart->removeProductFromCart($product_id);
        
        // Redirection vers la page du panier
        header('Location: cart.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Panier</title>
</head>
<body>
	<?php include('header.php') ?>
	<h1>Panier</h1>
	<table>






