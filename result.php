<?php
$pdo = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');

if (isset($_GET['q'])) {
    $query = $_GET['q'];

    // Recherche des produits correspondant à la chaîne de recherche
    $stmt = $pdo->prepare("SELECT id, name, price,id_category FROM product WHERE name LIKE :query");
    $stmt->bindValue(':query', '%'.$query.'%');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        // Aucun produit trouvé
        echo "Aucun produit avec ce nom.";
    } else {
        // Affichage des produits correspondant à la recherche
        foreach ($results as $result) {
            $id = $result['id'];
            $nom = $result['name'];
            $category = $result['id_category'];
            $price = $result['price'] ;
            echo "<h1>$nom</h1>";
            echo "<p>$price</p>";
            echo "<a href=\"product.php?id=$id\">Voir le produit</a><br><br>";
        }
    }
}
?>