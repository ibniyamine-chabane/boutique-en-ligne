<?php
session_start();

include('src/class/users.php');
include('src/class/cartClass.php');

$user_id = $_SESSION['id_user'];

$cart = new Cart();


$connexion = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    // Rediriger l'utilisateur vers la page de connexion
    header('Location: login.php');
    exit();
}

// Vérifier si le bouton "Supprimer le panier" a été cliqué
if (isset($_POST['delete_cart'])) {
    // Supprimer le panier de l'utilisateur connecté
    $requete = $connexion->prepare("DELETE FROM `cart` WHERE id_user = :id_user");
    header("Location: cart.php");

    $requete->bindParam(':id_user', $user_id);
    $requete->execute();

    exit();
}

// Vérifier si le bouton "Valider" a été cliquer
if (isset($_POST['validate_cart'])) {
    // Récupérer le panier de l'utilisateur connecté
    $requete = $connexion->prepare("SELECT * FROM cart WHERE id_user = :id_user");
    $requete->bindParam(':id_user', $user_id);
    $requete->execute();
    $cart = $requete->fetch(PDO::FETCH_ASSOC);

    // Stocker le panier de l'utilisateur connecté dans la session
    $_SESSION['cart'] = $cart;

    // Ajouter l'id du panier dans l'URL de la page de validation de commande
    $cart_id = $cart['id'];
    header("Location: order_validation.php?cart_id=$cart_id");
    exit();
}






$products = $cart->getCartProductsByUserId($user_id); // Récupération des produits du panier de l'utilisateur

$total = 0; // le prix est de zero sans produit

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="src/css/style.css">
    <title>Panier</title>
</head>
<body>
    <?php include('header.php') ?>
    <main>
    <div class="container-cart-profil">
    <h1>Panier</h1>
        <div class="container-table">
            <table id="cart">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>total produit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) {?>
                        <tr>
                            <td><img src="src/upload/<?php echo $product['image']; ?>" style="width: 135px;"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['price']; ?> €</td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td><?php $product_total = $product['price'] * $product['quantity']; echo $product_total; ?> €</td>
                            <td><?= $product['amount'] ?> €</td>
                            <td><a href="delete_cart_product.php?id_c=<?= $product['id_cart'] ?>&id_p=<?= $product['id_product']?>" class="login-button">supprimer du panier</a></td>
                        </tr>
                        <?php $total += $product_total; }?>
                        <tr>
                            <td colspan="4">Total :</td>
                            <td><?php echo $total; ?> €</td> <!-- Afficher le prix total-->

                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container-button-cart">
    <form method="post">
        <button type="submit" name="delete_cart" class="red">Supprimer le panier</button>
    </form>
    <form method="post">
        <button type="submit" name="validate_cart">Valider le Panier</button>
    </form>
    </div>
    </main>
    <?php require_once('footer.php'); ?>
</body>
</html>

