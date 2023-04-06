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
                <label for="">Sous-catégorie</label>
                <select name="categorie" id="" multiple>
                    <option value="Action">Action</option>
                    <option value="Fantaisie">Fantaisie</option>
                    <option value="Isekai">Isekai</option>
                    <option value="Drame">Drame</option>
                    <option value="Psychologique">Psychologique</option>
                    <option value="Comedie">Comedie</option>
                    <option value="Policier">Policier</option>
                    <option value="Science fiction">Science fiction</option>
                    <option value="Aventure">Aventure</option>
                    <option value="Mecha">Mecha</option>
                </select>
                <label for="">description</label>
                <input type="textarea" name="descritpion_product">
                <input type="submit" value="ajouter le produit">
            </form>
        </section>
    </main>
</body>

</html>