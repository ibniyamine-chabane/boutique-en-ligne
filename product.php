<?php 
session_start();
require_once("src/class/shopClass.php");
$products = new shop;
$productDatabase = $products->getProduct();

// dans cette page il faudrat récupérer la quantité deproduit disponible du produit , et les infos du produit
// les table products et product_inventory devront etre appeler, 
// le formulaire une fois valider devra envoyer les données récupérer en post vers la table cart.
//$database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');
// $request = $database->prepare('SELECT * FROM product WHERE id = (?)');
// $request = $database->prepare('SELECT product.id , `name` , `image` , `description` , `price` , inventory.id , quantity 
//                                FROM product 
//                                INNER JOIN product_inventory 
//                                ON product_inventory.id_product = product.id 
//                                INNER JOIN inventory 
//                                ON product_inventory.id_inventory = inventory.id 
//                                WHERE product.id = (?)'
//                                );
// $request->execute(array($_GET['id']));
// $productDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
// var_dump($productDatabase);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <div></div>
        <section>
            <?php foreach ($productDatabase as $product) : ?>
            <h2><?= $product['name'] ?></h2>
            <div>
                <img src="<?= $product['image'] ?>.jpg" alt="">
            </div>
            <article>
                <h3><?= $product['description'] ?></h3>
                <aside>
                    <p></p>
                </aside>
            </article>
            <div>
                <form action="">
                    <label for="product_quantity">quantité :</label>
                    <input type="hidden" name="" value=""><!-- ici la value sera l'id de l'user inscrit -->
                    <input type="hidden" value=""><!-- ici la value sera l'id du produit -->
                    <input type="number" maxlength="4" size="4" min="1" max="<?= $productDatabase[0]['quantity'] ?>"><!-- le max sera la quantité disponible pour ce produit, ce champ a mettre en width: 39px ne pas oublier de transformer le number en string-->
                    <input type="submit" value="ajouté au panier"> 
                </form>
            </div>
        </section>
        <?php endforeach; ?>
    </main>
</body>
</html>