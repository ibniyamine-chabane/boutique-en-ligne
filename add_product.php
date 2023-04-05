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
                <label for="">catégorie</label>
                <input type="text" name="catégory_product">
                <label for="">sous-catégorie</label>
                <input type="text" name="sub_category_product">
                <label for="">description</label>
                <input type="textarea" name="descritpion_product">
                <input type="submit" value="ajouter le produit">
            </form>
        </section>
    </main>
</body>
</html>