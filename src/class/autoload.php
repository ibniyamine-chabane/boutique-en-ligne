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
    
    public function addToCart($product_id, $quantity) {
        // Récupération de l'ID de l'utilisateur connecté à partir de la  session
        $user_id = $_SESSION['id'];
        
        // Vérification que $user_id et $product_id sont des scalaires 
        if (!is_scalar($user_id) || !is_scalar($product_id)) {
            return false;
        }
        
        // Vérification que la quantité est un nombre  positif
        if (!is_int($quantity) || $quantity <= 0) {
            return false;
        }
        
        // Récupération de l'id de l'inventaire correspondant au produit
        $stmt = $this->database->prepare('SELECT inventory.id FROM inventory INNER JOIN product ON product.id = inventory.product_id WHERE product.id = :product_id');
        $stmt->execute(array(':product_id' => $product_id));
        $inventory_id = $stmt->fetch(PDO::FETCH_COLUMN);
        
        // Vérification que $inventory_id 
        if (!is_scalar($inventory_id)) {
            return false;
        }
        
        // Vérification du stock disponible
        $stmt = $this->database->prepare('SELECT quantity FROM inventory WHERE id = :inventory_id');
        $stmt->execute(array(':inventory_id' => $inventory_id));
        $available_stock = $stmt->fetch(PDO::FETCH_COLUMN);
        
        if ($quantity > $available_stock) {
            return false;
        }
        
        // Insertion de l'article dans le panier
        $stmt = $this->database->prepare('INSERT INTO cart_product (id_cart, id_product, quantity) VALUES (:id_cart, :id_product, :quantity)');
        $stmt->execute(array(':id_cart' => $user_id, ':id_product' => $product_id, ':quantity' => $quantity));
        
        // Mise à jour du stock
        $new_stock = $available_stock - $quantity;
        $stmt = $this->database->prepare('UPDATE inventory SET quantity = :new_stock WHERE id = :inventory_id');
        $stmt->execute(array(':new_stock' => $new_stock, ':inventory_id' => $inventory_id));
        
        return true;
    }
    




    public function getProducts() {
        $stmt = $this->database->prepare('SELECT * FROM product ORDER BY date_product DESC');
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }


}

// Fonction d'auto-chargement des classes
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

?>
