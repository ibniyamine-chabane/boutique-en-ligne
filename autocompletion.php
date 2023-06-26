<?php 
$pdo = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

if (isset($_GET['q'])) {
    $query = $_GET['q'];

    $stmt = $pdo->prepare("SELECT id, name, price, id_category , image FROM product WHERE name LIKE :query LIMIT 10");
    $stmt->bindValue(':query', '%'.$query.'%');
    $stmt->execute(); // Exécuter la requête SQL
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Stocker le résultat de la requête SQL dans un tableau associatif

    $suggestions = array(); // Initialiser un tableau  pour afficher les resultat
    // Pour chaque résultat  créer une suggestion et l'afficher au tableau
    foreach ($results as $result) {
      $id = $result['id'];
      $name = $result['name'];
      $price = $result['price'];
      $category_id = $result['id_category'];
      $image = $result['image'];
      $suggestion = array('id' => $id, 'name' => $name, 'price' => $price, 'category_id' => $category_id, 'image' => $image);
      array_push($suggestions, $suggestion);
    }

    // Encoder le tableau $suggestions au format JSON et l'afficher dans la réponse HTTP
    echo json_encode($suggestions);
}
?>

