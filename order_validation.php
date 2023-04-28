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



if (!empty($_POST)) {
    $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
    if($id_user === null){
        die("erreur aucun user connecter");
    }

    $adresse_line1 = $_POST["adresse_line1"];
    $adresse_line2 = $_POST["adresse_line2"] ?? null;
    $city = $_POST["city"];
    $postal_code = $_POST["postal_code"];
    $country = $_POST["country"];
    $telephone = $_POST["telephone"] ?? null;
    $mobile = $_POST["mobile"] ?? null;

    try {
        $query = "INSERT INTO `users_address`(`adresse_line1`, `adresse_line2`, `city`, `postal_code`, `country`, `telephone`, `mobile`, `id_user`) VALUES (:adresse_line1, :adresse_line2, :city, :postal_code, :country, :telephone, :mobile, :id_user)";
    
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(":adresse_line1", $adresse_line1);
        $stmt->bindParam(":adresse_line2", $adresse_line2);
        $stmt->bindParam(":city", $city);
        $stmt->bindParam(":postal_code", $postal_code);
        $stmt->bindParam(":country", $country);
        $stmt->bindParam(":telephone", $telephone);
        $stmt->bindParam(":mobile", $mobile);
        $stmt->bindParam(":id_user", $id_user); 

        
        if ($stmt->execute()) {
            echo "L'adresse a été ajoutée avec succès!";
            $_SESSION['cart_id'] = $_SESSION['cart']['id'];
            header("location: payement.php?cart_id=" . $_SESSION['cart_id']);
            exit();
        } else {
            echo "Erreur lors de l'ajout de l'adresse.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}


?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/style.css">
    <title>validation commande</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
  <section>
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
        <input type="submit" value="Ajouter l'adresse et passer au paiement">
      </form>
    </div>
  </section>
</main>

    <?php include('footer.php') ?>
</body>
</html>