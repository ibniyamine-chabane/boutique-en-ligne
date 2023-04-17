<?php
session_start();

include('src/class/autoload.php');

$cart = new Cart();

//recuperer les les produits 

$products = $cart->selectProducts();


?>
<!DOCTYPE html>
<html>
<head>
  <title>Nos produits</title>
</head>
<body>
  <?php include('header.php') ?>
  <h1>Nos produits</h1>
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
        $products = $cart->getProducts();
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
