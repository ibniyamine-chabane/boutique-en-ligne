<?php 
session_start();
require_once("src/class/shopClass.php");
require_once("src/class/cartClass.php");

$products = new shop;
$productDatabase = $products->getProduct();

$addProductCart = new cart;


if (isset($_POST['submit'])) {

    if ($_POST['quantity']) {
        $quantity = (int) strip_tags($_POST['quantity']);
        $addProductCart->addProductInCart($quantity);

        if($_POST['quantity'] > $productDatabase[0]['quantity']) {
            die('vous ne pouvez pas dépasser la quantité disponible pour ce produit');
        } else if ($_POST['quantity'] == 0) {
            die('vous ne pouvez pas choisir la valeur 0');
        }
    } else {
        echo "veuillez choisir une quantité";
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
    <title>Produit</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <div></div>
        <section>
            <?php foreach ($productDatabase as $product) : ?>
                <h2><?= $product['name'] ?></h2>
                <div class="container-product-page">
                    <div class="container-image">
                        <div class="image-box">
                            <img src="src/upload/<?= $product['image'] ?>" alt="">
                        </div>
                    </div>
                    <div class="right-side">
                        <article>
                            <h3>description</h3>
                            <aside>
                                <p><?= $product['description'] ?></p>
                            </aside>
                        </article>
                        <div class="container-form-quantity">
                            <form action="" method="post">
                                <label for="product_quantity">quantité :</label>
                                <input type="hidden" name="" value=""><!-- ici la value sera l'id de l'user inscrit -->
                                <input type="hidden" value=""><!-- ici la value sera l'id du produit -->
                                <input type="number" name="quantity" maxlength="4" size="3" min="1" max="<?= $productDatabase[0]['quantity'] ?>"><!-- le max sera la quantité disponible pour ce produit, ce champ a mettre en width: 39px ne pas oublier de transformer le number en string-->
                                <?php if ($productDatabase[0]['quantity'] == 0):?>
                                <p>rupture de stock</p>
                                <?php else : ?>
                                <p><?= $productDatabase[0]['quantity'] ?> en stock</p>
                                <?php endif; ?>
                                <input type="submit" name="submit" value="ajouté au panier" class="green-button"> 
                            </form>
                        </div>
                    </div>
                </div>
        </section>
        <?php endforeach; ?>
    </main>
    <?php require_once("footer.php"); ?>
</body>
</html>