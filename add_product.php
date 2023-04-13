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
                <input type="text" name="title">
                <label for="">image du produit</label>
                <input type="file" name="image_file">
                <label for="">prix</label>
                <input type="text" name="price">
                <label for="">quantité</label>
                <input type="text" name="quantity">
                <label for="">catégorie</label>
                <inpé'ut type="text" name="category">
                <label for="">sous-catégorie</label>
                <input type="text" name="sub_category">
                <label for="">description</label>
                <textarea name="description" id="" cols="80" rows="5"></textarea>
                <input type="submit" value="ajouter le produit">
            </form>
        </section>
    </main>
</body>
</html>