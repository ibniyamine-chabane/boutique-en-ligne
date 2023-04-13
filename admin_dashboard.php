<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin dashboard</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
        <div>
            <div>
                <div>
                    <img src="" alt="">
                </div>
                <div>
                    <h4>titre produit</h4>
                    <p>prix</p>
                    <p>catégorie</p>
                    <p>sous-categorie</p>
                </div>
            </div>
        </div>
        <button><a href="add_product.php">ajouter un produit</a></button>
        </section>
    </main>
</body>
</html>