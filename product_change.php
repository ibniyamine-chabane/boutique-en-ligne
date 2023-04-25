<?php
session_start();

//require_once('src/class/products.php');
require_once('src/class/shopClass.php');

$change = new shop;

$dbChangeproduct = $change->getProduct();
// var_dump($dbChangeproduct);

// select the sub category table
$request = $change->getDatabase()->prepare('SELECT * FROM sub_category');

$request->execute(array());
$subCategoryDB = $request->fetchAll(PDO::FETCH_ASSOC);
// var_dump($subCategoryDB);

// select the category table
$request = $change->getDatabase()->prepare('SELECT * FROM category');

$request->execute(array());
$categoryDB = $request->fetchAll(PDO::FETCH_ASSOC);
// var_dump($categoryDB);

// join the product table to sub category table
$request2 = $change->getDatabase()->prepare("SELECT id_product, id_sub_category, product.name 
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
                                WHERE id_product = (?)
                                ORDER BY date_product DESC");
$request2->execute(array($dbChangeproduct[0]['id']));

$display2 = $request2->fetchAll(PDO::FETCH_ASSOC);
// var_dump($display2);

// Update product
if (isset($_POST['send'])) {
    if ($_FILES['image'] && $_POST['name'] && $_POST['price'] && $_POST['quantity'] && $_POST['category'] && $_POST['sub_category'] && $_POST['description']) {

        $image = $_FILES['image'];
        $name = $_POST['name'];
        $price = intval($_POST['price']);
        $quantity = intval($_POST['quantity']);
        $description = $_POST['description'];
        $category = $_POST['category'];
        $sub_category = $_POST['sub_category'];

        foreach ($categoryDB as $categoryName) {
            if ($category == $categoryName['name']) {

                $categoryName['id'] = $_SESSION['category_id'];
            }
        }

        // // checks are carried out
        // extension
        $allowed = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];

        $filetype = $_FILES['image']['type'];
        $filesize = $_FILES['image']['size'];

        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

        // we check the absence of the extension in the keys of the allowed variable or the absence of the MIME type in the values
        if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
            die('ERREUR : format de fichier incorrect');
        }

        // The limit is 1 MB
        if ($filesize > 1024 * 1024) {
            die('Le fichier dépasse 1 Mo');
        }

        // we generate a complete path
        $newfilename = __DIR__ . "/src/upload/" . $image['name'];

        // insert the downloaded image in the upload folder
        if (!move_uploaded_file($image['tmp_name'], $newfilename)) {
            die("L'upload a échoué");
        }

        $sql = "UPDATE product
                INNER JOIN product_inventory on product.id = product_inventory.id_product
                INNER JOIN inventory on inventory.id = product_inventory.id_inventory
                set product.name = (?), product.image = (?), product.price = (?), product.description = (?), product.id_category = (?), inventory.quantity = (?)
                WHERE product.id = (?)";
        $request = $change->getDatabase()->prepare($sql);
        $request->execute(array($name, $image['name'], $price, $description, $_SESSION['category_id'], $quantity, $dbChangeproduct[0]['product_id']));

        //update sub category
        $sql2 = "DELETE FROM sub_category_product
                 WHERE id_product = (?)";
        $request2 = $change->getDatabase()->prepare($sql2);
        $request2->execute(array($dbChangeproduct[0]['product_id']));

        foreach ($_POST['sub_category'] as $postSubCategory) {
            foreach ($subCategoryDB as $subCategoryName) {
                if ($postSubCategory == $subCategoryName['name']) {

                    $sql2 = "INSERT INTO `sub_category_product` (`id_product`,`id_sub_category`) 
                    VALUE (?,?)";
                    $request2 = $change->getDatabase()->prepare($sql2);
                    $request2->execute(array($dbChangeproduct[0]['product_id'], $subCategoryName['id']));
                }
            }
        }
    } else {
        echo "veuillez remplir tous les champs";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification du produit</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <h2>Image du produit</h2>
            <div>
                <img src="src/upload/<?= $dbChangeproduct[0]['image'] ?>" alt="">
            </div>
            <h2>Modification du produit</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="">Nom du produit</label>
                <input type="text" name="name" value="<?= $dbChangeproduct[0]['name'] ?>">
                <label for="">Image du produit (png, jpg, jpeg, d'1 Mo max)</label>
                <input type="file" name="image" accept=".png,.jpg,.jpeg" value="<?= $dbChangeproduct[0]['image'] ?>">
                <label for="">Prix</label>
                <input type="text" name="price" value="<?= $dbChangeproduct[0]['price'] ?>">
                <label for="">Quantité</label>
                <input type="text" name="quantity" value="<?= $dbChangeproduct[0]['quantity'] ?>">
                <label for="">Catégorie</label>
                <select name="category" id="">
                    <?php foreach ($categoryDB as $category) : ?>
                        <option value="<?= $category['name'] ?>" <?php
                                                                    if ($category['id'] == $dbChangeproduct[0]['id_category']) :
                                                                    ?> <?= "selected"; ?> <?php endif; ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <legend>Sous-catégorie :</legend>
                <?php foreach ($subCategoryDB as $subCategory) : ?>
                    <div>
                        <input type="checkbox" id="sub_category" name="sub_category[]" value="<?= $subCategory['name'] ?>" <?php foreach ($display2 as $subCategory2) : ?> <?php if ($subCategory['name'] == $subCategory2['subName'] && $dbChangeproduct[0]['id'] == $subCategory2['productId']) : ?> <?= "checked" ?> <?php endif; ?> <?php endforeach; ?>>
                        <label for="Action"><?= $subCategory['name'] ?></label>
                    </div>
                <?php endforeach; ?>
                <label for="">description</label>
                <textarea name="description" id="" cols="80" rows="5"><?= $dbChangeproduct[0]['description'] ?></textarea>
                <input type="submit" value="Modifier le produit" name="send">
            </form>
        </section>
    </main>
</body>

</html>