<?php
<<<<<<< HEAD
    session_start();

    include('C:\wamp64\www\boutique-en-ligne\scr\class\users.php');
    include('C:\wamp64\www\boutique-en-ligne\scr\class\cart.php');


    

    //verif recherche 


    // Instanciation de la classe Cart
    $cart = new Cart();

 // Vérifie si l'utilisateur est connecté
 //if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['email'];
//} else {
    // Redirige l'utilisateur vers la page de connexion si non connecté
   // header('Location: login.php');
    //exit();
//}


    // Récupération des produits ajoutés au panier par l'utilisateur
    $products = $cart->selectProducts($user_id);

    // Calcul  total du panier
    $total_price = 0;
    foreach ($products as $product) {
        $total_price += $product['price'];
    }
?>

=======
session_start();
?>
>>>>>>> f3972328dd6ce00cbbf7d90c437dda109c677ff4
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier</title>
</head>
<body>
<<<<<<< HEAD



<!-- liste des produits dans le panier -->
<ul>
    <?php foreach($products as $product): ?>
        <li>
            <a href="element.php?id=<?php echo $product['id']; ?>">
                <?php echo $product['name']; ?>
                <img src="<?php echo $product['image']; ?>" alt="">
            </a>
        </li>
    <?php endforeach; ?>
</ul>


<script src="research.js"></script>



=======
    <?php require_once("header.php"); ?>
>>>>>>> f3972328dd6ce00cbbf7d90c437dda109c677ff4
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
                            <td><?= $product['name'] ?></td>
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


