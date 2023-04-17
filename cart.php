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
  <title>Tous les produits</title>
</head>
<body>
    <?php include('header.php') ?>
  <h1>Tous les produits</h1>
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Date de création</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
        <tr>
          <td><?php echo $product['name']; ?></td>
          <td><?php echo $product['description']; ?></td>
          <td><?php echo $product['price']; ?> €</td>
          <td><?php echo date('d/m/Y', strtotime($product['date_product'])); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>




