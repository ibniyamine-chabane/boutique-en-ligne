<?php
session_start();
require_once('src/class/shopClass.php');
$shop = new shop;
$database = $shop->getDatabase();

// pagination
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
var_dump($productDatabase);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin dashboard</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <div>
                <div>
                    <div>
                        <img src="" alt="">
                    </div>
                    <div>
                        <h4>titre produit</h4>
                        <p>prix</p>
                        <p>catégorie</p>
                        <p>sous-categorie</p>
                    </div>
                </div>
            </div>

            <div class="pagination">
                <ul>
                    <li class="<?= ($currentPage == 1) ? "disabled" : "" ?>"><a href="admin_dashboard.php?page=<?= $currentPage - 1 ?>">Précèdent</a></li>
                    <?php for ($page = 1; $page <= $pages; $page++) : ?>
                        <li><a href="admin_dashboard.php?page=<?= $page ?>"><?= $page ?></a></li>
                    <?php endfor; ?>
                    <li class="<?= ($currentPage == $pages) ? "disabled" : "" ?>"><a href="admin_dashboard.php?page=<?= $currentPage + 1 ?>">Suivant</a></li>
                </ul>
            </div>

            <button><a href="add_product.php">ajouter un produit</a></button>
        </section>
    </main>
</body>

</html>