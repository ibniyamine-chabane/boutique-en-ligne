<?php
session_start();

//require_once 'src/class/products.php/';

// Connect to database
try {
    $database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

//var_dump($_FILES['image']);

if (isset($_POST['send'])) {

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

            $filename = $_FILES['image']['name'];
            $filetype = $_FILES['image']['type'];
            $filesize = $_FILES['image']['size'];

            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            // we check the absence of the extension in the keys of the allowed variable or the absence of the MIME type in the values
            if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
                die('ERREUR : format de fichier incorrect');
            }

            // The limit is 1 MB
            if ($filesize > 1024 * 1024) {
                die('Le fichier dépasse 1 Mo');
            }

            // we generate a complete path
            $newfilename = __DIR__ . "/src/upload/" . $filename;

            // insert the downloaded image in the upload folder
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $newfilename)) {
                die("L'upload a échoué");
            }
            if ($_POST['description']) {
                if ($_POST['category']) {

                    $request = $database->prepare('SELECT * FROM category');
                    //$request = $this->database->prepare('SELECT * FROM users');
                    $request->execute(array());
                    $boutiqueDB = $request->fetchAll(PDO::FETCH_ASSOC);
                    //var_dump($boutiqueDB);

                    foreach ($boutiqueDB as $categoryName) {
                        if ($_POST['category'] == $categoryName['name']) {
                            //echo $categoryName['id'];
                            $_SESSION['category_id'] = $categoryName['id'];
                        }
                    }

                    if ($_POST['price']) {

                        $title = $_POST['title'];
                        $image = $filename;
                        $price = intval($_POST['price']);
                        $description = $_POST['description'];
                        $_SESSION['name'] = $title;

                        $request = $database->prepare('SELECT * FROM product');
                        //$request = $this->database->prepare('SELECT * FROM users');
                        $request->execute(array());
                        $boutiqueDB = $request->fetchAll(PDO::FETCH_ASSOC);
                        //var_dump($boutiqueDB);
                        // $this->$content = $content;
                        // $this->$title = $title;


                        //var_dump($request->execute(array()));

                        // SENDING THE REQUEST
                        $sql = "INSERT INTO `product` (`name`,`image`,`price`,`description`,`id_category`) 
                        VALUE (?,?,?,?,?)";
                        $request = $database->prepare($sql);
                        //$request = $this->database->prepare($sql);
                        $request->execute(array($title, $image, $price, $description, $_SESSION['category_id']));

                        $request2 = $database->prepare('SELECT * FROM product WHERE name = (?)');
                        $request2->execute(array($_SESSION['name']));
                        $boutiqueDB = $request2->fetchAll(PDO::FETCH_ASSOC);
                        //var_dump($boutiqueDB);

                        // echo $boutiqueDB[0]["id"];

                        $_SESSION['id_product'] = $boutiqueDB[0]['id'];

                        if ($_POST['quantity']) {


                            $quantity = intval($_POST['quantity']);
                            $_SESSION['quantity'] = $quantity;

                            $request = $database->prepare('SELECT product.id AS id_prod, inventory.id AS id_invent, id_product, id_inventory 
                                                            FROM product_inventory
                                                            INNER JOIN product
                                                            on product_inventory.id_product = product.id
                                                            INNER JOIN inventory
                                                            on product_inventory.id_inventory = inventory.id');
                            //$request = $this->database->prepare('SELECT * FROM users');
                            $request->execute(array());
                            $boutiqueDB = $request->fetchAll(PDO::FETCH_ASSOC);

                            // $this->$content = $content;
                            // $this->$title = $title;

                            //var_dump($boutiqueDB);

                            // SENDING THE REQUEST
                            $sql = "INSERT INTO `inventory` (`quantity`) 
                            VALUE (?)";
                            $request = $database->prepare($sql);
                            //$request = $this->database->prepare($sql);
                            $request->execute(array($quantity));

                            $request2 = $database->prepare('SELECT * FROM inventory WHERE quantity = (?)');
                            $request2->execute(array($_SESSION['quantity']));
                            $boutiqueDB2 = $request2->fetchAll(PDO::FETCH_ASSOC);
                            //var_dump($boutiqueDB2);

                            $_SESSION['id_inventory'] = $boutiqueDB2[0]['id'];

                            $sql2 = "INSERT INTO `product_inventory` (`id_product`,`id_inventory`) 
                            VALUE (?,?)";
                            $request = $database->prepare($sql2);
                            //$request = $this->database->prepare($sql);
                            $request->execute(array($_SESSION['id_product'], $_SESSION['id_inventory']));

                            if ($_POST['sub_category']) {
                                //var_dump($_POST['sub_category']);
                                // var_dump($_POST['sub_category'][1]);
                                $request = $database->prepare('SELECT * FROM sub_category');
                                //$request = $this->database->prepare('SELECT * FROM users');
                                $request->execute(array());
                                $boutiqueDB = $request->fetchAll(PDO::FETCH_ASSOC);
                                //var_dump($boutiqueDB);

                                foreach ($_POST['sub_category'] as $postSubCategory) {
                                    foreach ($boutiqueDB as $subCategoryName) {
                                        if ($postSubCategory == $subCategoryName['name']) {
                                            //echo $subCategoryName['id'];
                                            $_SESSION['sub_category_id'] = $subCategoryName['id'];

                                            $sql = "INSERT INTO `sub_category_category` (`id_category`,`id_sub_category`) 
                                            VALUE (?,?)";
                                            $request = $database->prepare($sql);
                                            //$request = $this->database->prepare($sql);
                                            $request->execute(array($_SESSION['category_id'], $_SESSION['sub_category_id']));

                                            $sql2 = "INSERT INTO `sub_category_product` (`id_product`,`id_sub_category`) 
                                            VALUE (?,?)";
                                            $request = $database->prepare($sql2);
                                            //$request = $this->database->prepare($sql);
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

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajouter un produit</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <h2>ajout de produit</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="">nom du produit</label>
                <input type="text" name="title">
                <label for="">image du produit (png, jpg, jpeg, d'1 Mo max)</label>
                <input type="file" name="image" accept=".png,.jpg,.jpeg">
                <label for="">prix</label>
                <input type="text" name="price">
                <label for="">quantité</label>
                <input type="text" name="quantity">
                <label for="">Catégorie</label>
                <select name="category" id="">
                    <option value="Comics">Comics</option>
                    <option value="Bande dessinée">Bande dessinée</option>
                    <option value="Manga">Manga</option>
                    <option value="Manhwa">Manhwa</option>
                    <option value="Manhua">Manhua</option>
                </select>
                <legend>Sous-catégorie :</legend>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Action">
                    <label for="Action">Action</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Fantaisie">
                    <label for="Fantaisie">Fantaisie</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Isekai">
                    <label for="Isekai">Isekaï</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Drame">
                    <label for="Drame">Drame</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Psychologique">
                    <label for="Psychologique">Psychologique</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Comedie">
                    <label for="Comedie">Comedie</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Policier">
                    <label for="Policier">Policier</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Science fiction">
                    <label for="Science fiction">Science fiction</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Aventure">
                    <label for="Aventure">Aventure</label>
                </div>
                <div>
                    <input type="checkbox" id="sub_category" name="sub_category[]" value="Mecha">
                    <label for="Mecha">Mecha</label>
                </div>
                <label for="">description</label>
                <textarea name="description" id="" cols="80" rows="5"></textarea>
                <input type="submit" value="ajouter le produit" name="send">
            </form>
        </section>
    </main>
</body>

</html>