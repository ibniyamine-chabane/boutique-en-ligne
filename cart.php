<?php
session_start();
include('src/class/users.php');
include('src/class/cart.php');

$user_id = $_SESSION['id_user']; // Récupération de l'ID de l'utilisateur connecté

$cart = new Cart();
$products = $cart->getCartProductsByUserId($user_id); // Récupération des produits du panier de l'utilisateur

$total = 0; // initialisation de la variable total

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de la présence de l'id du produit à supprimer dans la requête POST
    if (isset($_POST['id_product']) && is_scalar($_POST['id_product'])) {
        $product_id = $_POST['id_product'];
        
        // Vérification de la présence de la quantité à supprimer dans la requête POST
        if (isset($_POST['quantity']) && is_scalar($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
            
            // Suppression du produit du panier
            $cart->removeProductFromCart($product_id);
            
            // Redirection vers la page du panier
            header('Location: cart.php');
            exit();
        }
    }
}
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
                    <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?> €</td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php $product_total = $product['price'] * $product['quantity']; echo $product_total; ?> €</td>
                    <td>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="id_product" value="<?php echo $product['id_product']; ?>">
                            <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php
                $total += $product_total; // Ajout du prix total du produit à la variable total
            }
            ?>
            <tr>
                <td colspan="4">Total :</td>
                <td><?php echo $total; ?> €</td> <!-- Affichage du total en euros -->
            </tr>
        </tbody>
    </table>
</body>
</html>







