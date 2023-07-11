<?php
session_start();
require_once('src/class/shopClass.php');
$shop = new shop;
// $database = $shop->getDatabase();
$message = "";
$message2 = "";
// pagination
// on determine dans quel page on se trouve 
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}


$display = $shop->getAllProducts();

$display2 = $shop->getAllProductsSubCategory();

// envoyé une catégory dans la base de données
if (isset($_POST['submit_category'])) {
    if ($_POST['category']) {
        $category = htmlspecialchars(trim(strip_tags($_POST['category'])));
        $shop->addCategory($category);
        $message = $shop->getMessage();
    } else {
        $message = "veuillez entrer une categorie";
    }
}
// envoyé une sous catégory dans la base de données
if (isset($_POST['submit_sub_category'])) {
    if ($_POST['sub_category']) {
        $subCategory = htmlspecialchars(trim(strip_tags($_POST['sub_category'])));
        $shop->addSubCategory($subCategory);
        $message2 = $shop->getMessage();
    } else {
        $message2 = "veuillez entrer une sous categorie";
    }
}

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
                    <h2>Ajouter un produit</h2>
                    <a href="add_product.php" class="add-product-button">Ajouter un produit</a>
                    <h2>Ajouter une catégorie</h2>
                    <input type="text" name="category" placeholder="ajouter une catégorie">
                    <input type="submit" name="submit_category" value="ajouter la catégorie">
                    <?php if (isset($message) && empty($_POST['category'])) :?>
                        <span style="text-align: center;display: block;color: red;font-weight: bold;background-color: #ffffffa3;width: 30%;margin: auto;"><?= $message ?></span>
                    <?php elseif (isset($message)) :?>
                        <span style="text-align: center;display: block;color: green;font-weight: bold;background-color: #ffffffa3;width: 30%;margin: auto;"><?= $message ?></span>
                    <?php endif; ?>
                    <h2>Ajouter une sous catégorie</h2>
                    <input type="text" name="sub_category" placeholder="ajouter une sous-catégorie">
                    <input type="submit" name="submit_sub_category" value="ajouter la sous-catégorie">
                    <?php if (isset($message2) && empty($_POST['sub_category'])) :?>
                        <span style="text-align: center;display: block;color: red;font-weight: bold;background-color: #ffffffa3;width: 30%;margin: auto;"><?= $message2 ?></span>
                    <?php elseif (isset($message2)) :?>
                        <span style="text-align: center;display: block;color: green;font-weight: bold;background-color: #ffffffa3;width: 30%;margin: auto;"><?= $message2 ?></span>
                    <?php endif; ?>
            </div>

            <h2>Produits de la boutique</h2>
            <div>
            <div class="container-product">
                <?php foreach ($display as $product) : ?>
                    <a href="product.php?id=<?= $product['productId'] ?>" class="no-underline">
                        <div class="container-thumbnail"> <!-- div qui contient l'image et le titre  -->
                            <div>
                                <div class="image_box">
                                    <img src="src/upload/<?= $product['image'] ?>" alt="">
                                </div>
                                <div>
                                    <div class="card-font-size">
                                        <h4><?= $product['productName'] ?></h4>
                                        <p><?= "Quantité : " . $product['quantity'] . " " . "prix : " . $product['price'] ."€" ?></p>
                                        <p><?= $product['date_product'] ?></p>
                                    </div>
                                    <div class="card-font-size">
                                    <span><?php echo $product['categoryName']." : ";  
                                    foreach ($display2 as $subCategory) {
                                        if (
                                            $product['productId'] ==
                                            $subCategory['id_product']
                                        ) {
                                            echo $subCategory['subName']." ";
                                        }

                                    }?></span>
                                  
                                    </div>
                                    <div class="button-box">
                                        <a href="product_change.php?id=<?= $product['productId'] ?>" class="add-product-button admin-action-button">Modifier le produit</a>
                                        <a href="delete_product.php?id=<?= $product['productId'] ?>" class="add-product-button admin-action-button">suprimmer le produit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
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