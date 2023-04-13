<?php
    session_start();
    include('src/class/users.php');
    include('src/class/cart.php');



    // Calcul  total du panier
    $total_price = 0;
    foreach ($products as $product) {
        $total_price += $product['price'];
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier</title>
</head>
<body>



<script src="research.js"></script>




<script src="research.js"></script>



    <main>
        <section>
            <h2>Mon panier</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Prix total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>                <?php echo $product['name']; ?></td>
                            <td><?= $product['price'] ?> €</td>
                            <td>1</td>
                            <td><?= $product['price'] ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <h2>Total panier : <?= $total_price ?> €</h2>
        <button>Valider le panier</button>
    </main>
</body>
</html>


