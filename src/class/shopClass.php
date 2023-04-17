<?php 

class shop

{

    //attributs 
    private $database;
    private $perPages = 10;

    //Constructeur
    public function __construct(){ 
        
    }

    //Méthodes 

    public function getAllProducts() {

        $request = $this->getDatabase()->prepare('SELECT * FROM product');
        $request->execute(array());
        return $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function setProductsPerPages(int $Product_per_pages) {
      
    $this->perPages = $Product_per_pages;

    }

    public function getProductsPerPages() {
        return $this->perPages;
    }
    public function getDatabase() {

        try {
            $this->database = new PDO('mysql:host=localhost;dbname=boutique;charset=utf8;port=3306', 'root', '');

        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        return $this->database;
    }
    
    public function getProduct() {
        $request = $this->getDatabase()->prepare('SELECT product.id , `name` , `image` , `description` , `price` , inventory.id , quantity 
                               FROM product 
                               INNER JOIN product_inventory 
                               ON product_inventory.id_product = product.id 
                               INNER JOIN inventory 
                               ON product_inventory.id_inventory = inventory.id 
                               WHERE product.id = (?)'
                               );
        $request->execute(array($_GET['id']));
        return $productDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProfil() {

        $request = $this->database->prepare("SELECT * FROM user WHERE id = (?)");
        $request->execute(array($_SESSION['id']));
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        return $userDatabase;
    }

}
//$user = new users;

// $user->register("maloo@.com","maloo","boubou");
// $user->register("elgato@churros.com","elgato","meowmeow");
// $user->register("yolo@fimo.com","yolo","stand");
// $user->connection("elmacho@dino.com","pocoloco");
// $user->connection("yolo@fimo.com","stand"); 
// $user->connection("admin@wild.com","azeradmin");
// echo $user->getAllUsers()['email'];
// echo $user->getAllUsers()['email'];
// echo $user->getAllUsers()['email'];

?>
