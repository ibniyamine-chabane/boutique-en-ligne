<?php
    session_start();
    include('src/class/users.php');
    include('src/class/cart.php');

    $cart = new Cart();
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
  <title>Votre Panier</title>
</head>
<body>
  <?php include('header.php') ?>
  <h1>Votre Panier</h1>
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
            <td>
              <form method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                <button type="submit">Supprimer</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <p>Total : <?php echo $total_price; ?> €</p>
  <?php } else { ?>
    <p>Aucun produit dans votre panier.</p>
  <?php } ?>
</body>
</html>





