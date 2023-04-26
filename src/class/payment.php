<?php

// Valider les informations de paiement soumises par l'utilisateur
$nom = $_POST['nom'];
$adresse = $_POST['adresse'];
$numero_carte = $_POST['numero_carte'];
$date_expiration = $_POST['date_expiration'];
$code_securite = $_POST['code_securite'];

if (empty($nom) || empty($adresse) || empty($numero_carte) || empty($date_expiration) || empty($code_securite)) {
  // Si les informations de paiement sont manquantes, renvoyer une erreur
  header('Location: erreur.php');
  exit;
}

// Vérifier que la carte de crédit est valide
if (!preg_match('/^([0-9]{4}-){3}[0-9]{4}$/', $numero_carte)) {
  // Si la carte de crédit est invalide, renvoyer une erreur
  header('Location: erreur.php');
  exit;
}



// Vérifier que le paiement a été accepté
if (rand(0, 1)) {
  // Si le paiement est réussi, renvoyer une page de confirmation de paiement
  header('Location: confirmation.php');
  exit;
} else {
  // Si le paiement est refusé, renvoyer une page d'erreur
  header('Location: erreur.php');
  exit;
}
?>