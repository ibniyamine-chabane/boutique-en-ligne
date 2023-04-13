<?php 

class users
{

    //attributs 
    private $database;
    private $id;
    private $email;

    //Constructeur
    public function __construct(){ 
        try {

        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Méthodes 

    public function register($email, $firstname, $lastname, $password) {

        $request = $this->database->prepare('SELECT * FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $this->email = $email;
        $password;
        $firstname;
        $emailOk = false;
        $right = "";
        $role_id = 2; // le role id 2 correspond a un utilisateur normale.
        

        foreach ($userDatabase as $user) {
            
            if ( $this->email == $user['email']){
                echo "cette utilisateur existe déjà";
                $emailOk = false;
                break;
            } else {    
                $emailOk = true;
            }           
            echo $user['email']."<br>";
        }


        if ($emailOk == true){
        //on créer l'utilisateur.
          $request = $this->database->prepare("INSERT INTO user(email, first_name, last_name, password, id_role, register_date) VALUES (?, ?, ?, ?, ?,NOW())");
          $request->execute(array($this->email, $firstname, $lastname, $password, $role_id));
    
          echo "tu est inscrit";
        }        
          
        
    }

    public function connection($email, $password) {
        //session_start();

        $request = $this->database->prepare('SELECT u.`id` , `email` , `first_name` , `last_name` , `password` , `rights` FROM user u INNER JOIN role ON role.id = u.id_role');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);

        $this->email = $email;
        $password;
        $logged = false;
                             

        foreach ($userDatabase as $user) { //je lis le contenu de la table de la BDD

            if ($email === $user['email'] && $password === $user['password']) {   
                $_SESSION['email'] = $email;
                $id = $user['id'];  
                $_SESSION['id'] = $id;
                $_SESSION["firstname"] = $user["first_name"];
                $_SESSION["rights"] = $user["rights"];
                $logged = true;
                break;

            } else {
                $logged = false;
            }
        }

        //echo $_SESSION["username"];

        if( $logged ) {
            echo "vous êtes connecté ".$_SESSION['firstname']." en tant que: ".$_SESSION['rights'];
            //var_dump($user);
            header('Location: index.php');
        } else {
            echo "erreur dans l'email ou le password</br>";
        }

    }

    public function getData() {
        return $this->database;
    }

    public function getProfil() {

        $request = $this->database->prepare("SELECT * FROM user WHERE id = (?)");
        $request->execute(array($_SESSION['id']));
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        return $userDatabase;
    }

    public function updateProfil($email, $firstname, $lastname, $password) {

        $this->email = $email;
        $request = $this->database->prepare('SELECT * FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $emailOk = false;
        
        foreach ($userDatabase as $user) {
            
            if ($this->email == $_SESSION['email']) {
                $emailOk = true;
            } else if ( $this->email == $user['email']){
                echo "cette adresse appartient à un autre utilisateur";
                $emailOk = false;
                break;
            } else {
                $emailOk = true;
            }

        }

        if ($emailOk == true){
            
            $request = $this->database->prepare("UPDATE user SET `email` = (?) , `first_name` = (?) , `last_name` = (?) , `password` = (?) WHERE `user`.`id` = (?)");
            $request->execute(array($email, $firstname, $lastname, $password, $_SESSION['id']));
        
              echo "votre profil a bien été modifier";
            }               
    }

    public function changePassword($new_password) {

        $request = $this->database->prepare('SELECT * FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $request = $this->database->prepare("UPDATE user SET `password` = (?) WHERE `user`.`id` = (?)");
        $request->execute(array($new_password, $_SESSION['id']));

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