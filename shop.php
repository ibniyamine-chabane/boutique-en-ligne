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

 
// $sql = 'SELECT product.id, product.name, price, image, sub_category.name as sub_name ,category.name as cate_name FROM `product` 
//         INNER JOIN category 
//         ON category.id = product.id_category
//         INNER JOIN sub_category_category
//         ON category.id = sub_category_category.id_category
//         INNER JOIN sub_category 
//         ON sub_category.id = sub_category_category.id_sub_category WHERE 1=1
//         AND category.id = 3  
//         AND sub_category.id = 2
//         LIMIT :premier, :parpage;';

// if (!empty($categorie)) {
//     $sql .= " AND id_categorie = " . $categorie;
//   }

//   if (!empty($sous_categorie)) {
//     $sql .= " AND id_sous_categorie = " . $sous_categorie;
//   }

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
    <script defer src="src/js/shop.js"></script>
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
                    <form action="" method="post" id="filter_form">
                        <label for="categories">Catégories</label>
                        <select name="category" id="">
                    <option value="Comics">Comics</option>
                    <option value="Bande dessinée">Bande dessinée</option>
                    <option value="Manga">Manga</option>
                    <option value="Manhwa">Manhwa</option>
                    <option value="Manhua">Manhua</option>
                </select>
                <legend>Sous-catégorie :</legend>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Action">
                    <label for="Action">Action</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Fantaisie">
                    <label for="Fantaisie">Fantaisie</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Isekai">
                    <label for="Isekai">Isekaï</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Drame">
                    <label for="Drame">Drame</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Psychologique">
                    <label for="Psychologique">Psychologique</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Comedie">
                    <label for="Comedie">Comedie</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Policier">
                    <label for="Policier">Policier</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Science fiction">
                    <label for="Science fiction">Science fiction</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Aventure">
                    <label for="Aventure">Aventure</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Mecha">
                    <label for="Mecha">Mecha</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Horreur">
                    <label for="Mecha">Horreur</label>
                </div>
                        <input type="submit" name="" id="">
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