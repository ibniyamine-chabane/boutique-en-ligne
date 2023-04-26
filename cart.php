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
if (isset($_POST['delete_simple'])) {
    // Vérifier si l'ID du produit à supprimer est présent dans le formulaire
    if (isset($_POST['id_product'])) {
        $product = $_POST['id_product'];

        // Récupérer l'ID du panier de l'utilisateur connecté
        $requete = $connexion->prepare("SELECT id FROM cart WHERE id_user = :id_user");
        $requete->bindParam(':id_user', $user_id);
        $requete->execute();
        $cart_id = $requete->fetch(PDO::FETCH_ASSOC)['id'];

        // Supprimer le produit du panier de l'utilisateur connecté
        $requete = $connexion->prepare("DELETE FROM `cart_product` WHERE id_cart = :cart_id AND id_product = :product");
        $requete->bindParam(':cart_id', $cart_id);
        $requete->bindParam(':product', $product);
        $requete->execute();

        // Vérifier si le produit a été supprimé
        if ($requete->rowCount() > 0) {
            // Rediriger l'utilisateur vers la page du panier
            header('Location: cart.php');
            exit();
        } else {
            echo "Le produit n'a pas été supprimé.";
        }
    }
}

// Vérifier si le bouton "Valider" a été envoyer
if (isset($_POST['validate_cart'])) {
    // Récupérer le panier de l'utilisateur connecté
    $requete = $connexion->prepare("SELECT * FROM cart WHERE id_user = :id_user");
    $requete->bindParam(':id_user', $user_id);
    $requete->execute();
    $cart = $requete->fetch(PDO::FETCH_ASSOC);

    // Stocker le panier de l'utilisateur connecté dans la session
    session_start();
    $_SESSION['cart'] = $cart;

    // Rediriger l'utilisateur vers la page de validation de commande
    header('Location: order_validation.php');
    exit();
}






$products = $cart->getCartProductsByUserId($user_id); // Récupération des produits du panier de l'utilisateur

$total = 0; // initialisation de la variable total
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./src/css/style.css">
    <title>Panier</title>
</head>
<body>
    <?php include('header.php') ?>
    <h1>Panier</h1>

    <table id="cart">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>total produit</th>
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
                    <form method="post">
                        <input type="hidden" name="id_product" value="ID_DU_PRODUIT">
                        <button type="submit" name="delete_simple">Supprimer ce produit</button>
                        </form>



                    </td>
                </tr>

                <?php
                $total += $product_total; 
            }
            ?>
            <tr>
                <td colspan="4">Total :</td>
                <td><?php echo $total; ?> €</td> <!-- Affichage du total en euros -->

            </tr>
        </tbody>
    </table>
                 <form method="post">
                <button type="submit" name="delete_cart">Supprimer le panier</button>
                </form>
                <form method="post">
             <button type="submit" name="validate_cart">Valider le Panier</button>
            </form>

</body>
</html>

