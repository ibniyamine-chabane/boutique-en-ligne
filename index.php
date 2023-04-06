<?php
session_start();
//var_dump($_SESSION["rights"]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>accueil</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <h2>nos produits</h2>
            <div>
                <div>
                    <img src="" alt="">
                </div>
                <div>
                    <h4>titre produit</h4>
                    <p>prix</p>
                </div>
            </div>
        </section>
        <section>
            <h2>Nos dernier produits ajouté</h2>
            <div>
                <div>
                    <img src="" alt="">
                </div>
                <div>
                    <h4>titre produit</h4>
                    <p>prix</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>