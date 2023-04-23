<?php

header('Content-Type: application/json');

include("src/class/users.php");
$user = new users;
$response = array("success" => false, "message" => "");

if (isset($_POST['submit'])) {

    if ($_POST['email'] && $_POST['firstname'] && $_POST['lastname'] && $_POST['password'] && $_POST['password_confirm']) {

        if ($_POST['password'] == $_POST['password_confirm']) {

            $email = htmlspecialchars(trim($_POST['email']));
            $firstname = htmlspecialchars(trim($_POST['firstname']));
            $lastname =  htmlspecialchars(trim($_POST['lastname']));
            $password =  htmlspecialchars(trim($_POST['password']));

            $registerResult = $user->register($email, $firstname, $lastname, $password);

            if ($registerResult) {
                $response["success"] = true;
                $response["message"] = "Inscription réussie!";
            } else {
                $response["message"] = "Échec de l'inscription.";
            }
        } else {
            $response["message"] = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $response["message"] = "Veuillez remplir tous les champs.";
    }
} else {
    $response["message"] = "Aucune donnée soumise.";
}

echo json_encode($response);
?>

