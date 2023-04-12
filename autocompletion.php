<?php 

$pdo = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');

if (isset($_GET['q'])){
    $query = $_GET['q'];

    //requete


// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');

if (isset($_GET['q'])){
    $query = $_GET['q'];

    // Requête SQL pour chercher les suggestions d'autocomplétion
    $stmt = $pdo->prepare("SELECT id, name, price FROM product WHERE name LIKE :query LIMIT 10");
    $stmt->bindValue(':query', '%'.$query.'%');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Transformation du tableau de résultats pour récupérer les noms, les prix et les identifiants de chaque produit
    $suggestions = array();
    foreach ($results as $result) {
      $id = $result['id'];
      $name = $result['name'];
      $price = $result['price'];
      $suggestion = array('id' => $id, 'name' => $name, 'price' => $price);
      array_push($suggestions, $suggestion);
    }

    // Affichage des suggestions au format JSON
    echo json_encode($suggestions);
}

}



?>