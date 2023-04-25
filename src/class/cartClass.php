<?php 

class cart

{

    //attributs 
    private $database;
    

    //Constructeur
    public function __construct(){ 
       
    }

    //Méthodes 

    public function getAllProducts() {

        $request = $this->database->prepare('SELECT * FROM product');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function addProductInCart(int $quantity) {
         //étape 1 on insert l'id de l'user dans la table cart
        $request = $this->getDatabase()->prepare('INSERT INTO cart(id_user , amount, creation_date) 
                                                  VALUES (?, ?, NOW())'
                                                  );

        $request->execute(array($_SESSION['id_user'], 0));
         //étape 2 on select la table cart ou la colonne id user correspont a notre user pour récupérer l'id de cart
        $request2 = $this->getDatabase()->prepare('SELECT id 
                                                 FROM cart 
                                                 WHERE id_user = (?)'
                                                 );

        $request2->execute(array($_SESSION['id_user']));
        $cartDb = $request2->fetchAll(PDO::FETCH_ASSOC);
        $id_cart = $cartDb[0]['id'];
         //étape 3 on insert l'id_cart , l'id_product ,et la quantité entré dans le champ par l'user
        $request3 = $this->getDatabase()->prepare('INSERT INTO cart_product(id_cart , id_product , quantity)
                                                VALUES (?, ?, ?)'
                                                );
         
        $request3->execute(array($id_cart, $_GET['id'], $quantity));

        //étape 4 on fait un select des table pour récupérer le prix par rapport a la quantité sur le bon produit
        $request4 = $this->getDatabase()->prepare('SELECT user.id , product.id , price , amount , quantity
                                                   FROM user
                                                   INNER JOIN cart 
                                                   ON user.id = cart.id_user
                                                   INNER JOIN cart_product 
                                                   ON cart_product.id_cart = cart.id
                                                   INNER JOIN product
                                                   ON cart_product.id_product = product.id
                                                   WHERE id_user = (?)'
                                                );

        $request4->execute(array($_SESSION['id_user']));
        $displaySelect = $request4->fetchAll(PDO::FETCH_ASSOC);
        $priceDb = $displaySelect[0]['price'];
        $quantityDb = $displaySelect[0]['quantity'];
        $amount = $priceDb * $quantityDb;

        //derniere étape ajouter le montant dans notre table cart qui correspont a notre id.
        $update = $this->getDatabase()->prepare('UPDATE cart
                                                   SET `amount` = (?)
                                                   WHERE id_user = (?)'
                                                   );

        $update->execute(array($amount ,$_SESSION['id_user']));
        
        // $_SESSION['message'] = "votre produit à bien été ajouté dans votre panier";

    }

    public function setProductsPerPages(int $Product_per_pages) {
      
   

    }

    public function getProductsPerPages() {
       
    }
    public function getDatabase() {

        try {
            $this->database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        return $this->database;
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
