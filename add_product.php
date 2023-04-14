<?php
session_start();
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
                <input type="text" name="title_product">
                <label for="">image du produit</label>
                <input type="file" name="image_file">
                <label for="">prix</label>
                <input type="text" name="price">
                <label for="">quantité</label>
                <input type="text" name="quantity_product">
                <label for="">Catégorie</label>
                <select name="categorie" id="">
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
                <label for="">description</label>
                <input type="textarea" name="descritpion_product">
                <input type="submit" value="ajouter le produit">
            </form>
        </section>
    </main>
</body>

</html>