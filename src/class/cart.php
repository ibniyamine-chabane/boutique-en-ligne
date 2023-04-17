<?php 



class Cart {
    private $database;

    public function __construct(){ 
        try {
            $this->database = new PDO('mysql:host=localhost;dbname=boutique;charset=utf8', 'root', '');
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    
    
    public function selectProducts() {
        // Récupération de l'ID de l'utilisateur connecté à partir de la variable de session
        $user_id = $_SESSION['id_user'];
        
        // Vérification que $user_id est un scalaire avant de l'utiliser dans la requête SQL
        if (!is_scalar($user_id)) {
            return array();
        }
        
        // Requête SQL pour récupérer les produits ajoutés par l'utilisateur connecté dans son panier
        $stmt = $this->database->prepare('SELECT cart_product.id_cart, cart_product.id_product, cart_product.quantity, product.* FROM cart_product INNER JOIN product ON product.id = cart_product.id_product INNER JOIN cart ON cart.id = cart_product.id_cart WHERE cart.user_id = :user_id');
        $stmt->execute(array(':user_id' => $user_id));
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getCartTotal() {
        // Récupération de l'ID de l'utilisateur connecté à partir de la  session
        $user_id = $_SESSION['id'];
        
        // Vérification que $user_id est  avant de l'utiliser dans la requête SQL
        if (!is_scalar($user_id)) {
            return 0;
        }
        
        // Requête SQL pour récupérer le montant total du panier de l'utilisateur connecté
        $stmt = $this->database->prepare('SELECT cart.montant FROM cart WHERE cart.user_id = :user_id');
        $stmt->execute(array(':user_id' => $user_id));
        $total = $stmt->fetch(PDO::FETCH_COLUMN);
        
        return $total ? $total : 0;
    }
    

}


?>

