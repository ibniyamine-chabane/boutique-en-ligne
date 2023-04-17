<?php
  session_start();
  include('src\class\users.php');

  include('src\class\cart.php');
  
  $cart = new Cart();
  $products = $cart->selectProducts();
  $total_price = 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Votre Panier</title>
</head>
<body>
  <?php include('header.php') ?>
  <h1>Votre Panier</h1>
  <?php if (empty($cart_products)) { ?>
    <p>Il n'y a pas de produits dans votre panier pour le moment.</p>
  <?php } else { ?>
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Description</th>
          <th>Prix unitaire</th>
          <th>Quantité</th>
          <th>Prix total</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cart_products as $cart_product) { 
          $product_id = $cart_product['id_product'];
          $quantity = $cart_product['quantity'];
          $product = $products[$product_id];
          $price = $product['price'];
          $total_price = $price * $quantity;
        ?>
          <tr>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['description']; ?></td>
            <td><?php echo $price; ?> €</td>
            <td><?php echo $quantity; ?></td>
            <td><?php echo $total_price; ?> €</td>
            <td>
              <form method="post">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <button type="submit">Supprimer</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <p>Total de votre panier : <?php echo $cart['amount']; ?> €</p>
    <form method="post">
      <input type="hidden" name="action" value="checkout">
      <button type="submit">Passer commande</button>
    </form>
  <?php } ?>
</body>
</html>








