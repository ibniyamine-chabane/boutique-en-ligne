<?php
session_start();

include('src/class/users.php');
include('src/class/cart.php');

$user_id = $_SESSION['id_user']; // Récupération de l'ID de l'utilisateur connecté

$cart = new Cart();

// Se connecter à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    // Rediriger l'utilisateur vers la page de connexion
    header('Location: connection.php');
    exit();
}

// Vérifier si le bouton "Supprimer le panier" a été cliqué
if (isset($_POST['delete_cart'])) {
    // Supprimer le panier de l'utilisateur connecté
    $requete = $connexion->prepare("DELETE FROM `cart` WHERE id_user = :id_user");
    $requete->bindParam(':id_user', $user_id);
    $requete->execute();

    // Rediriger l'utilisateur vers la page d'accueil
    header('Location: cart.php');
    exit();
}

$products = $cart->getCartProductsByUserId($user_id); // Récupération des produits du panier de l'utilisateur

$total = 0; // initialisation de la variable total
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Panier</title>
</head>
<body>
    <?php include('header.php') ?>
    <h1>Panier</h1>
    <form method="post">
        <button type="submit" name="delete_cart">Supprimer le panier</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $product) {
                ?>
                <tr>
                    <td><img src="<?php echo $product['image']; ?>"></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?> €</td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php $product_total = $product['price'] * $product['quantity']; echo $product_total; ?> €</td>
                    <td>

                    </td>
                </tr>
                <?php
                $total += $product_total; // Ajout du prix total du produit à la variable total
            }
            ?>
            <tr>
                <td colspan="4">Total :</td>
                <td><?php echo $total; ?> €</td> <!-- Affichage du total en euros -->
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>




