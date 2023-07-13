<?php
session_start();

include('src/class/users.php');
include('src/class/cartClass.php');
include('src/class/CartManager.php');


$user_id = $_SESSION['id_user']; // Récupération de l'ID de l'utilisateur connecté

$cart = new Cart();

$connexion = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');
$cartManager = new CartManager($connexion);

if (!isset($_SESSION['id_user'])) {
    $cartManager->redirectToLoginPage();
}

if (isset($_POST['delete_cart'])) {
    $cartManager->deleteCart($_SESSION['id_user']);
}

if (isset($_POST['delete_simple'])) {
    if (isset($_POST['id_product'])) {
        $product = $_POST['id_product'];
        $cartManager->deleteProductFromCart($_SESSION['id_user'], $product);
    }
}

if (isset($_POST['validate_cart'])) {
    $cartManager->validateCart($_SESSION['id_user']);
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
        <div class="container-cart-profil"><!-- visible in desktop screen , it disapear with screen 1008px-->
            <h2>Panier</h2>
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
        <?php if($total == 0) :?>
            <p> </p>
        <?php else :?>                            
            <div class="container-button-cart">
                <form method="post">
                    <button type="submit" name="delete_cart" class="red">Supprimer le panier</button>
                </form>
                <form method="post">
                    <button type="submit" name="validate_cart">Valider le Panier</button>
                </form>
            </div>
        <?php endif; ?>
        
        <h1 class="title">Panier</h1> <!-- visible only with screen bellow 1008px-->
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
        <?php if($totalR == 0 ) :?> 
            <h3 class="cart-status">Votre panier est vide</h3> 
        <?php else : ?>       
            <div class="total-cart">
                <form method="post" class="red-button">
                    <button type="submit" name="delete_cart" class="red">Supprimer le panier</button>
                </form> 
                <p>prix total panier : <?= $totalR ?> €</p>
                <form method="post" class="validation-button">
                    <button type="submit" name="validate_cart">Valider le Panier</button>
                </form>            
            </div>
        <?php endif; ?>
    </main>
    <?php require_once('footer.php'); ?>
</body>
</html>

