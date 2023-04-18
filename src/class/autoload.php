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
    
    
    




    public function getProducts() {
        $stmt = $this->database->prepare('SELECT * FROM product ORDER BY date_product DESC');
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }


}



?>
