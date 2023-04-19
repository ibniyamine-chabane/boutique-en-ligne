<?php 
$pdo = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

if (isset($_GET['q'])){
    $query = $_GET['q'];

    // Requête SQL pour chercher les suggestions d'autocomplétion
    $stmt = $pdo->prepare("SELECT id, name, price, id_category FROM product WHERE name LIKE :query LIMIT 10");
    $stmt->bindValue(':query', '%'.$query.'%');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Transformation du tableau de résultats pour récupérer les noms, les prix, les identifiants et les identifiants de catégorie de chaque produit
    $suggestions = array();
    foreach ($results as $result) {
      $id = $result['id'];
      $name = $result['name'];
      $price = $result['price'];
      $category_id = $result['id_category'];
      $suggestion = array('id' => $id, 'name' => $name, 'price' => $price, 'category_id' => $category_id);
      array_push($suggestions, $suggestion);
    }

    // Affichage des suggestions au format JSON
    echo json_encode($suggestions);
}
?>
