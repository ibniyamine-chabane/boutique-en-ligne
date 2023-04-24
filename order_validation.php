<?php 
session_start();
include('src/class/users.php');

// Connexion à la base de données avec PDO
try {
    $connexion = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');
    // Configuration des options de PDO pour afficher les erreurs
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit();
}

if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['country']) && isset($_POST['address_line_1']) && isset($_POST['postal_code']) && isset($_POST['telephone']) && isset($_POST['mobile'])) {
    // récupération de l'ID de l'utilisateur connecté
    $user_id = $_SESSION['id_user'];

    // récupération des données du formulaire
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $country = $_POST['country'];
    $address_line_1 = $_POST['address_line_1'];
    $address_line_2 = isset($_POST['address_line_2']) ? $_POST['address_line_2'] : "";
    $postal_code = $_POST['postal_code'];
    $telephone = $_POST['telephone'];
    $mobile = $_POST['mobile'];

    // préparation et exécution de la requête SQL pour insérer les données dans la table users_address
    $query = $connexion->prepare("INSERT INTO users_address (adresse_line1, adresse_line2, city, postal_code, country, telephone, mobile, id_user) VALUES (:adresse_line1, :adresse_line2, :city, :postal_code, :country, :telephone, :mobile, :id_user)");
    $query->bindParam(':adresse_line1', $address_line_1);
    $query->bindParam(':adresse_line2', $address_line_2);
    $query->bindParam(':city', $lastname);
    $query->bindParam(':postal_code', $postal_code);
    $query->bindParam(':country', $country);
    $query->bindParam(':telephone', $telephone);
    $query->bindParam(':mobile', $mobile);
    $query->bindParam(':id_user', $user_id);
    $query->execute();

    // Redirection vers la page de validation de commande
    header('Location: order_validation.php');
    exit();
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>validation commande</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
    <section>
    <h2>Détail de facturation</h2>
    <div>
        <form action="" method="post">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname">
            <label for="country">Pays / région</label>
            <input type="text" name="country">
            <label for="address_line_1">Numéro et nom de rue</label>
            <input type="text" name="address_line_1">
            <label for="address_line_2">Complément d'adresse</label>
            <input type="text" name="address_line_2">
            <label for="postal_code">Code postal</label>
            <input type="text" name="postal_code">
            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile">
            <input type="submit" value="Finaliser la commande">
        </form>
    </div>
</section>
    </main>
</body>
</html>