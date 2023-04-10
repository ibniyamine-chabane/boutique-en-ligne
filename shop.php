<?php
session_start(); 

$database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');
$request = $database->prepare('SELECT * FROM product');
$request->execute(array());
$productDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
var_dump($productDatabase);
echo $productDatabase[0]['image'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <style> .container-thumbnail { border: 1px solid black;
    width: 365px;} .container-product { display: flex; justify-content: space-evenly; } </style>
        <section>
            <h2>Produit de la boutique</h2>
            <div class="container-product">
                <?php foreach ($productDatabase as $product ) : ?>
                <a href="product.php?id=<?= $product['id'] ?>"><div class="container-thumbnail"> <!-- div qui contient l'image et le titre  -->
                    <div>
                        <div>
                            <img src="<?=$product['image']?>.jpg" alt="">
                        </div>
                        <div>
                            <h4><?= $product['name'] ?></h4>
                            <p><?= $product['price'] ?>€</p>
                        </div>
                    </div>
                </div></a>
                <?php endforeach; ?>
            </div>
            <div><!-- les catégorie ici -->

            </div>
        </section>
    </main>
</body>
</html>