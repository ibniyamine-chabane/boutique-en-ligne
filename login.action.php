<?php
header('Content-Type: application/json');

session_start();

require_once("src/class/users.php");
$user = new users;
$response = array("success" => false, "message" => "");

if (isset($_POST['submit'])) {
    if ($_POST['email'] && $_POST['password']) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $loginResult = $user->connection($email, $password);

        if ($loginResult) {
            $response["success"] = true;
            $response["message"] = "Connexion réussie!";
        } else {
            $response["message"] = "Échec de la connexion.";
        }
    } else {
        $response["message"] = "Veuillez remplir tous les champs.";
    }
} else {
    $response["message"] = "Aucune donnée soumise.";
}

echo json_encode($response);
?>
