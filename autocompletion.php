<?php 
$pdo = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

if (isset($_GET['q'])){
    $query = $_GET['q'];

    $stmt = $pdo->prepare("SELECT product.id, product.name AS name, product.price, product.id_category, category.name AS category_name, product.image
                           FROM product
                           INNER JOIN category ON category.id = product.id_category
                           WHERE product.name LIKE :query LIMIT 5");

    $stmt->bindValue(':query', '%'.$query.'%');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $suggestions = array();
    foreach ($results as $result) {
      $id = $result['id'];
      $name = $result['name'];
      $price = $result['price'];
      $category_id = $result['id_category'];
      $category = $result['category_name'];
      $image = $result['image'];
      $suggestion = array('id' => $id, 'name' => $name, 'price' => $price, 'category_id' => $category_id, 'image' => $image, 'category_name' => $category);
      array_push($suggestions, $suggestion);
    }

    echo json_encode($suggestions);
}
?>