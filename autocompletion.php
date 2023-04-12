<?php 

$pdo = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');

if (isset($_GET['q'])){
    $query = $_GET['q'];

    //requete


  // Requête SQL pour chercher les suggestions d'autocomplétion
  $stmt = $pdo->prepare("SELECT name FROM product WHERE name LIKE :query LIMIT 10");
  $stmt->bindValue(':query', '%'.$query.'%');
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

  // Affichage des suggestions au format JSON
  echo json_encode($results);
}



?>