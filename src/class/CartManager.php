<?php

class CartManager {
    private $connexion;

    public function __construct(PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function redirectToLoginPage() {
        header('Location: connection.php');
        exit();
    }

    public function deleteCart($user_id) {
        $requete = $this->connexion->prepare("DELETE FROM `cart` WHERE id_user = :id_user");
        $requete->bindParam(':id_user', $user_id);
        $requete->execute();

        header('Location: cart.php');
        exit();
    }

    public function deleteProductFromCart($user_id, $product) {
        $requete = $this->connexion->prepare("SELECT id FROM cart WHERE id_user = :id_user");
        $requete->bindParam(':id_user', $user_id);
        $requete->execute();
        $cart_id = $requete->fetch(PDO::FETCH_ASSOC)['id'];

        $requete = $this->connexion->prepare("DELETE FROM `cart_product` WHERE id_cart = :cart_id AND id_product = :product");
        $requete->bindParam(':cart_id', $cart_id);
        $requete->bindParam(':product', $product);
        $requete->execute();

        if ($requete->rowCount() > 0) {
            header('Location: cart.php');
            exit();
        } else {
            echo "Le produit n'a pas été supprimé.";
        }
    }

    public function validateCart($user_id) {
        $requete = $this->connexion->prepare("SELECT * FROM cart WHERE id_user = :id_user");
        $requete->bindParam(':id_user', $user_id);
        $requete->execute();
        $cart = $requete->fetch(PDO::FETCH_ASSOC);

        session_start();
        $_SESSION['cart'] = $cart;

        header('Location: order_validation.php');
        exit();
    }
}




?>
