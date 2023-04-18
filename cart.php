<?php
session_start();
include('src\class\users.php');
include('src\class\cart.php');

$user_id = $_SESSION['id_user']; // Récupération de l'ID de l'utilisateur connecté

$cart = new Cart();
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
	<table>
		<thead>
			<tr>
				<th>Image</th>
				<th>Nom</th>
				<th>Prix unitaire</th>
				<th>Quantité</th>
				<th>Total</th>
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












