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
        $user_id = $_SESSION['id'];
        
        // Vérification que $user_id est un scalaire avant de l'utiliser dans la requête SQL
        if (!is_scalar($user_id)) {
            return array();
        }
        
        // Requête SQL pour récupérer les produits ajoutés par l'utilisateur connecté dans son panier
        $stmt = $this->database->prepare('SELECT product.* FROM product INNER JOIN cart ON product.id = cart.product_id WHERE cart.user_id = :user_id');
        $stmt->execute(array(':user_id' => $user_id));
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getProducts() {
        $stmt = $this->database->prepare('SELECT * FROM product ORDER BY date_product DESC');
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
    
    

}

  






?>