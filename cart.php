<?php
    include('src/class/users.php');
    include('src/class/cart.php');

    $cart = new Cart();
    $products = $cart->getProducts();

    // Calcul  total du panier
    $total_price = 0;
    foreach ($products as $product) {
        $total_price += $product['price'];
    }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Votre Panier</title>
</head>
<body>
  <?php include('header.php') ?>
  <h1>Votre Panier</h1>
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Prix</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $cart = new Cart();
        $products = $cart->selectProducts();
        foreach ($products as $product) { 
      ?>
        <tr>
          <td><?php echo $product['name']; ?></td>
          <td><?php echo $product['description']; ?></td>
          <td><?php echo $product['price']; ?> €</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>




