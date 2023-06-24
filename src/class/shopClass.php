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

        $request = $this->getDatabase()->prepare('SELECT image, price, quantity, product.name 
                                                  AS productName, category.name 
                                                  AS categoryName, 
                                                  product.id 
                                                  AS productId, inventory.id 
                                                  AS inventoryId, product_inventory.id 
                                                  AS prod_inv_id,  
                                                  date_product  
                                                  FROM product 
                                                  INNER JOIN product_inventory
                                                  on product.id = product_inventory.id_product
                                                  INNER JOIN inventory
                                                  on inventory.id = product_inventory.id_inventory
                                                  INNER JOIN category
                                                  on product.id_category = category.id
                                                  ORDER BY date_product DESC');

                                                  $request->execute(array());
                                                  return $request->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function getAllProductsSubCategory() {
        $request = $this->getDatabase()->prepare('SELECT id_product, id_sub_category, product.name 
                                                  AS productName, sub_category.name 
                                                  AS subName, product.id 
                                                  AS productId, sub_category.id 
                                                  AS subId, sub_category_product.id 
                                                  AS prod_sub_id, 
                                                  date_product  
                                                  FROM product
                                                  INNER JOIN sub_category_product
                                                  on product.id = sub_category_product.id_product
                                                  INNER JOIN sub_category
                                                  on sub_category.id = sub_category_product.id_sub_category
                                                  ORDER BY date_product DESC
                                                ');
        $request->execute(array());
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function setProductsPerPages(int $Product_per_pages) {
      
    $this->perPages = $Product_per_pages;

    }

    public function getProductsPerPages() {
        return $this->perPages;
    }
    public function getDatabase() {

        try {
            $this->database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        return $this->database;
    }
    
    public function getProduct() {
        $request = $this->getDatabase()->prepare('SELECT product.id , `name` , `image` , `description` , `price` , id_category, inventory.id , quantity 
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
