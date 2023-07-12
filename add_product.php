<?php
session_start();

if(isset($_SESSION['id_user']) && $_SESSION['rights'] != 'administrator') {
    header("Location: index.php");
} elseif (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
}

require_once 'src/class/productsClass.php';

$product = new products;
$message = "";
if (isset($_POST['send'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $price = htmlspecialchars(trim($_POST['price']));
    $description = htmlspecialchars(trim($_POST['description']));
    $product->addProduct($title, $price, $description);
    $message = $product->getMessage();
}

// select the category table
$request = $product->getDB()->prepare('SELECT * FROM category');
$request->execute(array());
$categoryDB = $request->fetchAll(PDO::FETCH_ASSOC);
//var_dump($categoryDB);

// select the sub category table
$request2 = $product->getDB()->prepare('SELECT * FROM sub_category');
$request2->execute(array());
$subCategoryDB = $request2->fetchAll(PDO::FETCH_ASSOC);
//var_dump($subCategoryDB);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <title>ajouter un produit</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <div class="container-register">
                <h2>ajout de produit</h2>
                <?php if(isset($message)):?>
                    <span style="text-align: center;display: block;color: green;font-weight: bold;background-color: #ffffffa3;width: 60%;margin: auto;margin-top: 17px;margin-bottom: 17px;"><?= $message ?></span>
                <?php endif; ?>
                <div class="container-form-register">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="">nom du produit</label>
                        <input type="text" name="title">
                        <label for="">image du produit (png, jpg, jpeg, d'1 Mo max)</label>
                        <input type="file" name="image" accept=".png,.jpg,.jpeg">
                        <label for="">prix</label>
                        <input type="number" name="price">
                        <label for="">quantité</label>
                        <input type="number" name="quantity">
                        <label for="">Catégorie</label>
                        <select name="category" id="">
                            <?php foreach ($categoryDB as $category) : ?>
                                <option value="<?= $category['name'] ?>">
                                    <?= $category['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <legend>Sous-catégorie :</legend>
                        <div class="category">
                        <?php foreach ($subCategoryDB as $subCategory) : ?>
                            <div>
                                <input type="checkbox" id="sub_category" name="sub_category[]" value="<?= $subCategory['name'] ?>">
                                <label for="Action"><?= $subCategory['name'] ?></label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                        <label for="">description</label>
                        <textarea name="description" id="" cols="80" rows="5"></textarea>
                        <input type="submit" value="ajouter le produit" name="send">
                    </form>
                </div>
            </div>
        </section>
    </main>
    <?php require_once('footer.php'); ?>
</body>

</html>