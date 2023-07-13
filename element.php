<?php
session_start();
include('src/class/users.php');


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="result.js"></script>
    <title>Résultats de la recherche</title>
</head>
<body>
    <?php include('header.php') ?>
    <main>
        <div class="container-result">
            <h1>Résultats de la recherche pour "<span id="search-query"></span>" :</h1>
            <div id="products"></div>
        </div>
    </main>
</body>
</html>


