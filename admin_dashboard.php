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
//var_dump($productDatabase);

$request = $database->prepare("SELECT image, price, quantity, product.name 
                                AS productName, category.name 
                                AS categoryName, 
                                -- sub_category.name AS subName, 
                                product.id 
                                AS productId, inventory.id 
                                AS inventoryId, product_inventory.id 
                                AS prod_inv_id,  
                                date_product  
                                FROM product 
                                INNER JOIN product_inventory
                                on product.id = product_inventory.id_product
                                INNER JOIN inventory
                                on inventory.id = product_inventory.id_inventory
                                INNER JOIN category
                                on product.id_category = category.id
                                -- INNER JOIN sub_category_product
                                -- on product.id = sub_category_product.id_product
                                -- INNER JOIN sub_category
                                -- on sub_category.id = sub_category_product.id_sub_category
                                ORDER BY date_product DESC");
$request->execute(array());

$display = $request->fetchAll(PDO::FETCH_ASSOC);
//var_dump($display);

$request2 = $database->prepare("SELECT id_product, id_sub_category, product.name 
                                AS productName, sub_category.name 
                                AS subName, product.id 
                                AS productId, sub_category.id 
                                AS subId, sub_category_product.id 
                                AS prod_sub_id, 
                                date_product  
                                FROM product
                                INNER JOIN sub_category_product
                                on product.id = sub_category_product.id_product
                                INNER JOIN sub_category
                                on sub_category.id = sub_category_product.id_sub_category
                                ORDER BY date_product DESC");
$request2->execute(array());

$display2 = $request2->fetchAll(PDO::FETCH_ASSOC);
//var_dump($display2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <title>admin dashboard</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <div class="container-form-register width-category-dashbord">
                <form action="" method="post">
                    <?php
                    // envoyé une catégory dans la base de données
                    if (isset($_POST['submit_category'])) {
                        if ($_POST['category']) {
                            $category = $_POST['category'];

                            $sql2 = "INSERT INTO `category` (`name`) 
                        VALUE (?)";
                            $request2 = $database->prepare($sql2);
                            $request2->execute(array($category));
                        }
                    }
                    ?>
                    <h2>Ajouter un produit</h2>
                    <a href="add_product.php" class="add-product-button">Ajouter un produit</a>
                    <h2>Ajouter une catégorie</h2>
                    <input type="text" name="category" placeholder="ajouter une catégorie">
                    <input type="submit" name="submit_category" value="ajouter la catégorie">
                    <?php
                    // envoyé une sous catégory dans la base de données
                    if (isset($_POST['submit_sub_category'])) {
                        if ($_POST['sub_category']) {
                            $subCategory = $_POST['sub_category'];

                            $sql2 = "INSERT INTO `sub_category` (`name`) 
                        VALUE (?)";
                            $request2 = $database->prepare($sql2);
                            $request2->execute(array($subCategory));
                        }
                    }
                    ?>
                    <h2>Ajouter une sous catégorie</h2>
                    <input type="text" name="sub_category" placeholder="ajouter une sous-catégorie">
                    <input type="submit" name="submit_sub_category" value="ajouter la sous-catégorie">
            </div>

            <h2>Produit</h2>
            <div class="container-product">
                <?php foreach ($display as $product) : ?>
                    <a href="product.php?id=<?= $product['productId'] ?>" class="no-underline">
                        <div class="container-thumbnail"> <!-- div qui contient l'image et le titre  -->
                            <div>
                                <div>
                                    <img src="src/upload/<?= $product['image'] ?>" alt="">
                                </div>
                                <div>
                                    <h4><?= $product['productName'] ?></h4>
                                    <p><?= $product['price'] ?>€</p>
                                    <p><?= "Quantité : " . $product['quantity'] ?></p>
                                    <p><?= $product['date_product'] ?></p>
                                    <p><?= $product['categoryName'] ?></p>
                                    <?php foreach ($display2 as $subCategory) : ?>
                                        <?php if (
                                            $product['productId'] ==
                                            $subCategory['id_product']
                                        ) : ?>
                                            <p><?= $subCategory['subName'] ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <div class="button-box">
                                        <a href="product_change.php?id=<?= $product['productId'] ?>" class="add-product-button" style="width:155px;font-size:12px;">Modifier le produit</a>
                                        <a href="delete_product.php?id=<?= $product['productId'] ?>" class="add-product-button" style="width:155px;font-size:12px;">suprimmer le produit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            </form>
            <?php if (isset($comment)) : ?> <!-- ici c'est pour que la pagination n'apparait pas, $comment n'existe pas -->
                <div class="pagination">
                    <ul>
                        <li class="<?= ($currentPage == 1) ? "disabled" : "" ?>"><a href="admin_dashboard.php?page=<?= $currentPage - 1 ?>">Précèdent</a></li>
                        <?php for ($page = 1; $page <= $pages; $page++) : ?>
                            <li><a href="admin_dashboard.php?page=<?= $page ?>"><?= $page ?></a></li>
                        <?php endfor; ?>
                        <li class="<?= ($currentPage == $pages) ? "disabled" : "" ?>"><a href="admin_dashboard.php?page=<?= $currentPage + 1 ?>">Suivant</a></li>
                    </ul>
                </div>
            <?php endif; ?>


        </section>
    </main>
    <?php require_once("footer.php") ?>
</body>

</html>