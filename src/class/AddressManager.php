<?php

class AddressManager {
    private $connexion;
    private $testCreditCards;

    public function __construct(PDO $connexion) {
        $this->connexion = $connexion;
        $this->testCreditCards = array(
            array(
                'number' => '4242424242424242',
                'expiration' => '12/2024',
                'cvv' => '123'
            )
        );
    }

    public function addAddress($id_user, $adresse_line1, $adresse_line2, $city, $postal_code, $country, $telephone, $mobile, $credit_card_number, $expiration_date, $cvv) {
        if (!$this->isTestCreditCardValid($credit_card_number, $expiration_date, $cvv)) {
            exit();
        }

        try {
            $query = "INSERT INTO `users_address`(`adresse_line1`, `adresse_line2`, `city`, `postal_code`, `country`, `telephone`, `mobile`, `id_user`) VALUES (:adresse_line1, :adresse_line2, :city, :postal_code, :country, :telephone, :mobile, :id_user)";

            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(":adresse_line1", $adresse_line1);
            $stmt->bindParam(":adresse_line2", $adresse_line2);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":postal_code", $postal_code);
            $stmt->bindParam(":country", $country);
            $stmt->bindParam(":telephone", $telephone);
            $stmt->bindParam(":mobile", $mobile);
            $stmt->bindParam(":id_user", $id_user);

            if ($stmt->execute()) {
                echo "L'adresse a été ajoutée avec succès !";

                $deleteCartQuery = "DELETE FROM `cart` WHERE id_user = :id_user";
                $deleteCartStmt = $this->connexion->prepare($deleteCartQuery);
                $deleteCartStmt->bindParam(":id_user", $id_user);

                if ($deleteCartStmt->execute()) {
                    echo "Le panier a été supprimé.";
                } else {
                    echo "Erreur lors de la suppression du panier.";
                }

                $_SESSION['cart_id'] = $_SESSION['cart']['id'];
                header("location: succes.php?cart_id=" . $_SESSION['cart_id']);
                exit();
            } else {
                echo "Erreur lors de l'ajout de l'adresse.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    private function isTestCreditCardValid($number, $expiration, $cvv) {
        foreach ($this->testCreditCards as $card) {
            if ($number === $card['number'] && $expiration === $card['expiration'] && $cvv === $card['cvv']) {
                return true;
            }
        }
        return false;
    }
}




?>