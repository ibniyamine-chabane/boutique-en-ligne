<?php
session_start();

require_once 'src/class/products.php';

if (isset($_POST['send'])) {

    $product = new products;
    $product->addProduct($_POST['title'], $_POST['price'], $_POST['description']);
}

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
                    <div class="ds">
                        <div class="">
                            <label for="Action">Action</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Action">
                            <br>
                            <label for="Fantaisie">Fantaisie</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Fantaisie">
                            <br>
                            <label for="Isekai">Isekaï</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Isekai">
                            <br>
                            <label for="Drame">Drame</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Drame">
                            <br>
                            <label for="Psychologique">Psychologique</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Psychologique">
                            <br>
                            <label for="Comedie">Comedie</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Comedie">
                            <br>
                            <label for="Policier">Policier</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Policier">
                            <br>
                            <label for="Science fiction">Science fiction</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Science fiction">
                            <br>
                            <label for="Aventure">Aventure</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Aventure">
                            <br>
                            <label for="Mecha">Mecha</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Mecha">
                            <br>
                            <label for="Mecha">Horreur</label>
                            <input type="checkbox" id="sub_category" name="sub_category[]" value="Horreur">
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