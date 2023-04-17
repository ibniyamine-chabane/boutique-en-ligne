<?php 
session_start();
// dans cette page il faudrat récupérer la quantité deproduit disponible du produit , et les infos du produit
// les table products et product_inventory devront etre appeler, 
// le formulaire une fois valider devra envoyer les données récupérer en post vers la table cart.
$database = new PDO('mysql:host=localhost;dbname=boutique;charset=utf8;port=3306', 'root', '');
$request = $database->prepare('SELECT * FROM product WHERE id = (?)');
$request->execute(array($_GET['id']));
$productDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
var_dump($productDatabase);
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
                    <input type="hidden" value=""><!-- ici la value sera l'id de l'user inscrit -->
                    <input type="hidden" value=""><!-- ici la value sera l'id du produit -->
                    <input type="number" maxlength="4" size="4" min="1" max="5"><!-- le max sera la quantité disponible pour ce produit, ce champ a mettre en width: 39px ne pas oublier de transformer le number en string-->
                    <input type="submit" value="ajouté au panier"> 
                </form>
            </div>
        </section>
        <?php endforeach; ?>
    </main>
</body>
</html>