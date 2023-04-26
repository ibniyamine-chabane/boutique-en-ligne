<?php

class  products
{
    //attributs 
    private $database;
    private $id;
    private $name;
    private $image;
    private $price;
    private $description;

    //Constructeur
    public function __construct()
    {
        try {
            $this->database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Méthodes
    public function getDB()
    {
        return $this->database;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function addProduct($title, $price, $description)
    {

        $this->name = $title;
        $this->price = $price;
        $this->description = $description;

        //if the fields are filled in
        if ($_POST['title']) {
            if ($_FILES['image'] && $_FILES['image']['error'] === 0) {

                // // checks are carried out
                // extension
                $allowed = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                ];

                $this->image = $_FILES['image']['name'];
                $filetype = $_FILES['image']['type'];
                $filesize = $_FILES['image']['size'];

                $extension = pathinfo($this->image, PATHINFO_EXTENSION);

                // we check the absence of the extension in the keys of the allowed variable or the absence of the MIME type in the values
                if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
                    die('ERREUR : format de fichier incorrect');
                }

                // The limit is 1 MB
                if ($filesize > 1024 * 1024) {
                    die('Le fichier dépasse 1 Mo');
                }

                // we generate a complete path
                $newfilename = __DIR__ . "/../upload/" . $this->image;

                // insert the downloaded image in the upload folder
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $newfilename)) {
                    die("L'upload a échoué");
                }
                if ($_POST['description']) {
                    if ($_POST['category']) {

                        $request = $this->database->prepare('SELECT * FROM category');

                        $request->execute(array());
                        $categoryDB = $request->fetchAll(PDO::FETCH_ASSOC);
                        //var_dump($boutiqueDB);

                        foreach ($categoryDB as $categoryName) {
                            if ($_POST['category'] == $categoryName['name']) {
                                //echo $categoryName['id'];
                                $_SESSION['category_id'] = $categoryName['id'];
                            }
                        }

                        if ($_POST['price']) {

                            $_SESSION['name'] = $title;

                            $request = $this->database->prepare('SELECT * FROM product');

                            $request->execute(array());
                            $boutiqueDB = $request->fetchAll(PDO::FETCH_ASSOC);
                            //var_dump($boutiqueDB);

                            // SENDING THE REQUEST
                            $sql = "INSERT INTO `product` (`name`,`image`,`price`,`description`,`id_category`) 
                            VALUE (?,?,?,?,?)";
                            $request = $this->database->prepare($sql);
                            $request->execute(array($title, $this->image, $price, $description, $_SESSION['category_id']));

                            $request2 = $this->database->prepare('SELECT * FROM product WHERE name = (?)');
                            $request2->execute(array($_SESSION['name']));
                            $boutiqueDB = $request2->fetchAll(PDO::FETCH_ASSOC);
                            //var_dump($boutiqueDB);

                            // echo $boutiqueDB[0]["id"];

                            $_SESSION['id_product'] = $boutiqueDB[0]['id'];
                            $this->id = $_SESSION['id_product'];

                            if ($_POST['quantity']) {


                                $quantity = intval($_POST['quantity']);
                                $_SESSION['quantity'] = $quantity;

                                $request = $this->database->prepare('SELECT product.id AS id_prod, inventory.id AS id_invent, id_product, id_inventory 
                                                                FROM product_inventory
                                                                INNER JOIN product
                                                                on product_inventory.id_product = product.id
                                                                INNER JOIN inventory
                                                                on product_inventory.id_inventory = inventory.id');
                                $request->execute(array());
                                $boutiqueDB = $request->fetchAll(PDO::FETCH_ASSOC);

                                //var_dump($boutiqueDB);

                                // SENDING THE REQUEST
                                $sql = "INSERT INTO `inventory` (`quantity`) 
                                VALUE (?)";
                                $request = $this->database->prepare($sql);
                                $request->execute(array($quantity));

                                $request2 = $this->database->prepare('SELECT * FROM inventory WHERE quantity = (?)');
                                $request2->execute(array($_SESSION['quantity']));
                                $boutiqueDB2 = $request2->fetchAll(PDO::FETCH_ASSOC);
                                //var_dump($boutiqueDB2);

                                $_SESSION['id_inventory'] = $boutiqueDB2[0]['id'];

                                $sql2 = "INSERT INTO `product_inventory` (`id_product`,`id_inventory`) 
                                VALUE (?,?)";
                                $request = $this->database->prepare($sql2);
                                $request->execute(array($this->id, $_SESSION['id_inventory']));

                                if ($_POST['sub_category']) {
                                    //var_dump($_POST['sub_category']);
                                    // var_dump($_POST['sub_category'][1]);
                                    $request = $this->database->prepare('SELECT * FROM sub_category');
                                    $request->execute(array());
                                    $subCategoryDB = $request->fetchAll(PDO::FETCH_ASSOC);
                                    //var_dump($boutiqueDB);

                                    foreach ($_POST['sub_category'] as $postSubCategory) {
                                        foreach ($subCategoryDB as $subCategoryName) {
                                            if ($postSubCategory == $subCategoryName['name']) {
                                                //echo $subCategoryName['id'];
                                                $_SESSION['sub_category_id'] = $subCategoryName['id'];

                                                $sql = "INSERT INTO `sub_category_category` (`id_category`,`id_sub_category`) 
                                                VALUE (?,?)";
                                                $request = $this->database->prepare($sql);
                                                $request->execute(array($_SESSION['category_id'], $_SESSION['sub_category_id']));

                                                $sql2 = "INSERT INTO `sub_category_product` (`id_product`,`id_sub_category`) 
                                                VALUE (?,?)";
                                                $request = $this->database->prepare($sql2);
                                                $request->execute(array($_SESSION['id_product'], $_SESSION['sub_category_id']));
                                            }
                                        }
                                    }
                                } else {
                                    echo "Veuillez ajouter au moins une sous catégorie au produit";
                                }
                            } else {
                                echo "Veuillez ajouter la quantité du produit";
                            }
                        } else {
                            echo "Veuillez ajouter un prix au produit";
                        }
                    } else {
                        echo "Veuillez ajouter une catégorie au produit";
                    }
                } else {
                    echo "Veuillez ajouter une description au produit";
                }
            } else {
                echo "Veuillez ajouter une image au produits";
            }
        } else {
            echo "Veuillez ajouter un titre au produit";
        }
    }
}
