<?php
session_start();
include('src/class/users.php');
include('src/class/AddressManager.php');


try {
    $connexion = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit();
}

$addressManager = new AddressManager($connexion);

if (!isset($_SESSION['id_user'])) {
    die("erreur aucun utilisateur connecté");
}

if (!empty($_POST)) {
    $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
    if ($id_user === null) {
        die("erreur aucun utilisateur connecté");
    }

    $adresse_line1 = isset($_POST["adresse_line1"]) ? htmlspecialchars($_POST["adresse_line1"]) : null;
    $adresse_line2 = isset($_POST["adresse_line2"]) ? htmlspecialchars($_POST["adresse_line2"]) : null;
    $city = isset($_POST["city"]) ? htmlspecialchars($_POST["city"]) : null;
    $postal_code = isset($_POST["postal_code"]) ? htmlspecialchars($_POST["postal_code"]) : null;
    $country = isset($_POST["country"]) ? htmlspecialchars($_POST["country"]) : null;
    $telephone = isset($_POST["telephone"]) ? htmlspecialchars($_POST["telephone"]) : null;
    $mobile = isset($_POST["mobile"]) ? htmlspecialchars($_POST["mobile"]) : null;
    $credit_card_number = isset($_POST["credit_card_number"]) ? htmlspecialchars($_POST["credit_card_number"]) : null;
    $expiration_date = isset($_POST["expiration_date"]) ? htmlspecialchars($_POST["expiration_date"]) : null;
    $cvv = isset($_POST["cvv"]) ? htmlspecialchars($_POST["cvv"]) : null;
    

    $addressManager->addAddress($id_user, $adresse_line1, $adresse_line2, $city, $postal_code, $country, $telephone, $mobile, $credit_card_number, $expiration_date, $cvv);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/style.css">
    <title>Validation commande</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <div class="container-addresse-form">
                <h2>Détail de facturation</h2>
                <div>
                    <form class="form-fact" method="post" id="form-adresse">
                        <label for="adresse-line1">Adresse ligne 1 :</label>
                        <input type="text" name="adresse_line1" id="adresse-line1" required>
                        <br>
                        <label for="adresse-line2">Adresse ligne 2 :</label>
                        <input type="text" name="adresse_line2" id="adresse-line2">
                        <br>
                        <label for="city">Ville :</label>
                        <input type="text" name="city" id="city" required>
                        <br>
                        <label for="postal-code">Code postal :</label>
                        <input type="text" name="postal_code" id="postal-code" required>
                        <br>
                        <label for="country">Pays :</label>
                        <input type="text" name="country" id="country" required>
                        <br>
                        <label for="telephone">Téléphone :</label>
                        <input type="text" name="telephone" id="telephone">
                        <br>
                        <label for="mobile">Mobile :</label>
                        <input type="text" name="mobile" id="mobile">
                        <br>
                        <label for="credit-card-number">Numéro de carte de crédit :</label>
                        <input type="text" name="credit_card_number" id="credit-card-number" required>
                        <br>
                        <label for="expiration-date">Date d'expiration (MM/AAAA) :</label>
                        <input type="text" name="expiration_date" id="expiration-date" required>
                        <br>
                        <label for="cvv">Code de sécurité (CVV) :</label>
                        <input type="text" name="cvv" id="cvv" required>
                        <br>
                        <input type="submit" value="Ajouter l'adresse et passer au paiement">
                    </form>
                </div>
            </div>    
        </section>
    </main>

    <?php include('footer.php') ?>
</body>
</html>
