<?php
session_start();

include('src/class/users.php');
include('src/class/cartClass.php');

$user_id = $_SESSION['id_user']; // Récupération de l'ID de l'utilisateur connecté

$cart = new Cart();

// Se connecter à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    // Rediriger l'utilisateur vers la page de connexion
    header('Location: connection.php');
    exit();
}

// Vérifier si le bouton "Supprimer le panier" a été cliqué
if (isset($_POST['delete_cart'])) {
    // Supprimer le panier de l'utilisateur connecté
    $requete = $connexion->prepare("DELETE FROM `cart` WHERE id_user = :id_user");
    $requete->bindParam(':id_user', $user_id);
    $requete->execute();

    // Rediriger l'utilisateur vers la page d'accueil
    header('Location: cart.php');
    exit();
}

if (isset($_POST['delete_simple'])) {
    // Vérifier si l'ID du produit à supprimer est présent dans le formulaire
    if (isset($_POST['id_product'])) {
        $product = $_POST['id_product'];

        // Récupérer l'ID du panier de l'utilisateur connecté
        $requete = $connexion->prepare("SELECT id FROM cart WHERE id_user = :id_user");
        $requete->bindParam(':id_user', $user_id);
        $requete->execute();
        $cart_id = $requete->fetch(PDO::FETCH_ASSOC)['id'];

        // Supprimer le produit du panier de l'utilisateur connecté
        $requete = $connexion->prepare("DELETE FROM `cart_product` WHERE id_cart = :cart_id AND id_product = :product");
        $requete->bindParam(':cart_id', $cart_id);
        $requete->bindParam(':product', $product);
        $requete->execute();

        // Vérifier si le produit a été supprimé
        if ($requete->rowCount() > 0) {
            // Rediriger l'utilisateur vers la page du panier
            header('Location: cart.php');
            exit();
        } else {
            echo "Le produit n'a pas été supprimé.";
        }
    }
}

// Vérifier si le bouton "Valider" a été envoyer
if (isset($_POST['validate_cart'])) {
    // Récupérer le panier de l'utilisateur connecté
    $requete = $connexion->prepare("SELECT * FROM cart WHERE id_user = :id_user");
    $requete->bindParam(':id_user', $user_id);
    $requete->execute();
    $cart = $requete->fetch(PDO::FETCH_ASSOC);

    // Stocker le panier de l'utilisateur connecté dans la session
    session_start();
    $_SESSION['cart'] = $cart;

    // Rediriger l'utilisateur vers la page de validation de commande
    header('Location: order_validation.php');
    exit();
}






$products = $cart->getCartProductsByUserId($user_id); // Récupération des produits du panier de l'utilisateur

$total = 0; // initialisation de la variable total
$totalR = 0; 

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
                            <td><?php echo $total; ?> €</td> <!-- Affichage du total en euros -->

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
    
    <h1 class="title">Panier</h1>
    <div class="container-cart-responsive">
    <?php foreach ($products as $productR) :?>
        <div class="cart-product">
            <div class="box-detail-cart">
                <div class="container-cart-img">
                    <div class="box-cart-img">
                        <img src="src/upload/<?= $productR['image']?>" alt="">
                    </div>
                </div>
                <div class="cart-description">
                    <h2><?= $productR['name'] ?></h2>
                    <p>prix : <?= $productR['price'] ?> €</p>
                    <p>quantité : <?= $productR['quantity'] ?></p>
                </div>
            </div>
            <div class="total-price">
                <span>prix : <?php $product_totalR = $productR['price'] * $productR['quantity']; echo $product_totalR . " €"; ?></span>
                <a href="delete_cart_product.php?id_c=<?= $productR['id_cart'] ?>&id_p=<?= $productR['id_product']?>" class="login-button">supprimer du panier</a>
            </div>
        </div>
        <?php $totalR += $product_totalR; ?>
        <?php endforeach; ?>
        
    </div>
    <div class="total-cart">
            <form method="post" class="red-button">
                <button type="submit" name="delete_cart" class="red">Supprimer le panier</button>
            </form> 
            <p>prix total panier : <?= $totalR ?> €</p>
            <form method="post" class="validation-button">
                <button type="submit" name="validate_cart">Valider le Panier</button>
            </form>            
        </div>
    </main>
    <?php require_once('footer.php'); ?>
</body>
</html>

