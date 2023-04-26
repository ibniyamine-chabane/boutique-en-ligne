<?php
session_start();

require_once 'src/class/productsClass.php';

$product = new products;

if (isset($_POST['send'])) {

    $product->addProduct($_POST['title'], $_POST['price'], $_POST['description']);
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
    <title>ajouter un produit</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <h2>ajout de produit</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="">nom du produit</label>
                <input type="text" name="title">
                <label for="">image du produit (png, jpg, jpeg, d'1 Mo max)</label>
                <input type="file" name="image" accept=".png,.jpg,.jpeg">
                <label for="">prix</label>
                <input type="text" name="price">
                <label for="">quantité</label>
                <input type="text" name="quantity">
                <label for="">Catégorie</label>
                <select name="category" id="">
                    <?php foreach ($categoryDB as $category) : ?>
                        <option value="<?= $category['name'] ?>">
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <legend>Sous-catégorie :</legend>
                <?php foreach ($subCategoryDB as $subCategory) : ?>
                    <div>
                        <input type="checkbox" id="sub_category" name="sub_category[]" value="<?= $subCategory['name'] ?>">
                        <label for="Action"><?= $subCategory['name'] ?></label>
                    </div>
                <?php endforeach; ?>
                <label for="">description</label>
                <textarea name="description" id="" cols="80" rows="5"></textarea>
                <input type="submit" value="ajouter le produit" name="send">
            </form>
        </section>
    </main>
</body>

</html>