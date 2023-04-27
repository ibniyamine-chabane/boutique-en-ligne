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
    <link rel="stylesheet" href="src/css/style.css">
    <title>ajouter un produit</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
        <div class="container-register">
            <h2>ajout de produit</h2>
            <div class="container-form-register">
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
                        <option value="Comics">Comics</option>
                        <option value="Bande dessinée">Bande dessinée</option>
                        <option value="Manga">Manga</option>
                        <option value="Manhwa">Manhwa</option>
                        <option value="Manhua">Manhua</option>
                    </select>
                    <legend>Sous-catégorie :</legend>
                    <div class="category">
                        <div class="">
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Action">
                            <label for="Action">Action</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Fantaisie">
                            <label for="Fantaisie">Fantaisie</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Isekai">
                            <label for="Isekai">Isekaï</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Drame">
                            <label for="Drame">Drame</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Psychologique">
                            <label for="Psychologique">Psychologique</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Comedie">
                            <label for="Comedie">Comedie</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Policier">
                            <label for="Policier">Policier</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Science fiction">
                            <label for="Science fiction">Science fiction</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Aventure">
                            <label for="Aventure">Aventure</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Mecha">
                            <label for="Mecha">Mecha</label>
                            <br>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Horreur">
                            <label for="Mecha">Horreur</label>
                        </div>
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