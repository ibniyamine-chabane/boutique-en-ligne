<?php
    session_start();
    include('src/class/users.php');
    include('src/class/cart.php');

   // Instanciation de la classe Cart
$cart = new Cart();

// Récupération des produits ajoutés par l'utilisateur connecté dans son panier
$products = $cart->selectProducts();

    // Calcul  total du panier
    $total_price = 0;
    foreach ($products as $product) {
        $total_price += $product['price'];
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Mon panier</title>
</head>
<body>
    <?php include('header.php') ?>
  <h1>Mon panier</h1>
  <?php if (count($products) > 0) { ?>
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Description</th>
          <th>Prix</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product) { ?>
          <tr>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['description']; ?></td>
            <td><?php echo $product['price']; ?> €</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <p>Aucun produit dans votre panier.</p>
  <?php } ?>
</body>
</html>

