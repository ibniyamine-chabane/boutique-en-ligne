<?php 

class Cart {
    private $database;

    public function __construct(){ 
        try {
            $this->database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    


    public function getCartProductsByUserId($user_id) {
        // Vérification que $user_id est un scalaire avant de l'utiliser dans la requête SQL
        if (!is_scalar($user_id)) {
            return array();
        }

        // Requête SQL pour récupérer les produits du panier de l'utilisateur
        $stmt = $this->database->prepare('SELECT product.id, product.name, product.price, product.image, cart_product.quantity FROM product INNER JOIN cart_product ON product.id = cart_product.id_product INNER JOIN cart ON cart.id = cart_product.id_cart WHERE cart.id_user = :user_id');
        $stmt->execute(array(':user_id' => $user_id));
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    
   
    
    
    
    
    
    
    
    
}

?>


