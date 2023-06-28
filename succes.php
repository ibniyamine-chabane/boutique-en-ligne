<?php
session_start();
include('src/class/users.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Succès</title>
    <link rel="stylesheet" href="./src/css/style.css">

</head>
<body>
<?php require_once("header.php"); ?>

    <h1>Commande réussie !</h1>
    <p>Votre numéro de commande est : <span id="order-number"></span></p>
    <script src="./src/js/validcard.js"></script>

    <?php require_once("footer.php"); ?>

</body>
</html>