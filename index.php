<?php
session_start();

require_once('src/class/shopClass.php');
$shop = new shop;
$database = $shop->getDatabase();


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


$sql2 = 'SELECT * FROM `product` ORDER BY id DESC LIMIT 4';
$database2 = $shop->getDatabase();
$requestLastProduct = $database2->prepare($sql2);
$requestLastProduct->execute();
$fourLastProducts = $requestLastProduct->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <title>accueil</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <h2>Nos produits</h2>
            <div class="container-product">
                <?php foreach ($productDatabase as $product ) : ?>
                    <div class="container-thumbnail"> <!-- div qui contient l'image et le titre  -->
                    <a href="product.php?id=<?= $product['id'] ?>">
                        <div>
                            <div class="image_box">
                                <img src="src/upload/<?=$product['image']?>" alt="">
                            </div>
                            <div class="box_title_product">
                                <h4><?= $product['name'] ?></h4>
                                <p><?= $product['price'] ?>€</p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="pagination">
                <ul>                
                    <li class="<?= ($currentPage == 1) ? "disabled" : "" ?>"><a href="index.php?page=<?= $currentPage - 1 ?>">Précédent</a></li>
                    <?php for ($page = 1; $page <= $pages; $page++) : ?>
                    <li><a href="index.php?page=<?= $page ?>"><?= $page ?></a></li>
                    <?php endfor; ?>
                    <li class="<?= ($currentPage == $pages) ? "disabled" : "" ?>"><a href="index.php?page=<?= $currentPage + 1 ?>">Suivant</a></li>
                </ul>
            </div>
        </section>
        <section>
            <h2>Nos derniers produits ajoutés</h2>
            <div class="container-product">
                <?php foreach ($fourLastProducts as $lastProducts ) : ?>
                <a href="product.php?id=<?= $lastProducts['id'] ?>">
                <div class="container-thumbnail"> <!-- div qui contient l'image et le titre  -->
                    <div>
                        <div class="image_box">
                            <img src="src/upload/<?=$lastProducts['image']?>" alt="">
                        </div>
                        <div class="box_title_product">
                            <h4><?= $lastProducts['name'] ?></h4>
                            <p><?= $lastProducts['price'] ?>€</p>
                        </div>
                    </div>
                </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <?php require_once("footer.php");?>
</body>
</html>