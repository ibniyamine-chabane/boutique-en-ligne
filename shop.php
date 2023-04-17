<?php
session_start(); 
require_once('src/class/shopClass.php');
$shop = new shop;
$database = $shop->getDatabase();

//$database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

// on determine dans quel page on se trouve 
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}

//var_dump($currentPage);
// la requete pour compter le nombre de produit 
$sql = 'SELECT COUNT(*) AS nb_product FROM `product`;';
$request = $database->prepare($sql);
$request->execute(array());
$result = $request->fetch();

$nbProduct = (int) $result['nb_product'];
//var_dump($nbProduct);

// on determine le nombre de produit par page.
$perPages = 6;

// on fait un calcule pour avoir le nombre de page total pour les produits

$pages = ceil($nbProduct / $perPages);
//var_dump($pages);
// Calculation of the 1st item on the page
$premier = ($currentPage * $perPages) - $perPages;


$sql = 'SELECT * FROM `product` LIMIT :premier, :parpage;';

// We prepare the request
$request = $database->prepare($sql);

$request->bindValue(':premier', $premier, PDO::PARAM_INT);
$request->bindValue(':parpage', $perPages, PDO::PARAM_INT);

// We run
$request->execute();

// The values are retrieved in an associative array
$productDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
//var_dump($prod);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Boutique</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <style> .container-thumbnail { border: 1px solid black;
    width: 365px;} .container-product { display: flex; justify-content: space-evenly; flex-wrap: wrap; }
    .disabled { pointer-events: none; } .pagination {margin: auto; width: 627px;} ul {display:flex; justify-content: space-evenly;}</style>
        <section>
            <h2>Produit de la boutique</h2>
            <div class="container-product">
                <?php foreach ($productDatabase as $product ) : ?>
                <a href="product.php?id=<?= $product['id'] ?>"><div class="container-thumbnail"> <!-- div qui contient l'image et le titre  -->
                    <div>
                        <div>
                            <img src="src/upload/<?=$product['image']?>" alt="">
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
                <div>
                    <form action="" method="post">
                        <label for="categories">Catégories</label>
                        <select name="category" id="category">
                        <option value="manga">Manga</option>
                        <option value="bd">Bande-déssiné</option>
                        <option value="comics">comics</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="pagination">
                <ul>                
                    <li class="<?= ($currentPage == 1) ? "disabled" : "" ?>"><a href="shop?page=<?= $currentPage - 1 ?>">Précèdent</a></li>
                    <?php for ($page = 1; $page <= $pages; $page++) : ?>
                    <li><a href="shop.php?page=<?= $page ?>"><?= $page ?></a></li>
                    <?php endfor; ?>
                    <li class="<?= ($currentPage == $pages) ? "disabled" : "" ?>"><a href="shop.php?page=<?= $currentPage + 1 ?>">Suivant</a></li>
                </ul>
            </div>
        </section>
    </main>
</body>
</html>