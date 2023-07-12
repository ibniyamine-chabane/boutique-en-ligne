<?php 

class users
{

    //attributs 
    private $database;
    private $id;    
    private $email;
    private $message;

    //Constructeur
    public function __construct(){ 
        try {
            $this->database = new PDO('mysql:host=localhost;dbname=boutique-en-ligne;charset=utf8;port=3307', 'root', '');

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
        $password = password_hash($password, PASSWORD_DEFAULT);
        $firstname;
        $emailOk = false;
        $right = "";
        $role_id = 2; // le role id 2 correspond a un utilisateur normale.
        
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) == false) {
            die("<h1 style='text-align: center; color: red'>vous n'avez pas entrer une adresse email valide</h1>");
        }
 
        foreach ($userDatabase as $user) {
            
            if ( $this->email == $user['email']){
                $this->message = "cette utilisateur existe déjà";
                $emailOk = false;
                break;
            } else {    
                $emailOk = true;
            }           
        }


        if ($emailOk == true){
        //on créer l'utilisateur.
          $request = $this->database->prepare("INSERT INTO user(email, first_name, last_name, password, id_role, register_date) VALUES (?, ?, ?, ?, ?,NOW())");
          $request->execute(array($this->email, $firstname, $lastname, $password, $role_id));
          $this->message = "inscription réussi";
          header('location : login.php');
        }        
          
        
    }

    public function connection($email, $password) {
        // préparation de la requête
        $request = $this->database->prepare('SELECT u.`id` , `email` , `first_name` , `last_name` , `password` , `rights` 
                                             FROM user u 
                                             INNER JOIN role 
                                             ON role.id = u.id_role
                                             WHERE `email` = (?)');
        $request->execute(array($email));
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);

        $this->email = $email;
        $password;
        $logged = false;
                                  
        foreach ($userDatabase as $user) { //je lis le contenu de la table de la BDD

            if ($email === $user['email'] && password_verify($password, $user['password'])) {   
                $_SESSION['email'] = $email;
                $id = $user['id'];  
                $_SESSION['id_user'] = $id;
                $_SESSION["firstname"] = $user["first_name"];
                $_SESSION["rights"] = $user["rights"];
                $logged = true;
                break;
                
            } else {
                $logged = false;
            }
        }

        if( $logged ) {
            header('Location: index.php');
        } else {
            $this->message = "erreur dans l'email ou le password";
        }

    }

    public function getData() {
        return $this->database;
    }

    public function getProfil() {

        $request = $this->database->prepare("SELECT * FROM user WHERE id = (?)");
        $request->execute(array($_SESSION['id_user']));
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        return $userDatabase;
    }

    public function getMessage() {
        return $this->message;
    }

    public function updateProfil($email, $firstname, $lastname, $password) {

        $this->email = $email;
        $request = $this->database->prepare('SELECT * FROM user WHERE email = (?)');
        $request->execute(array($this->email));
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $emailOk = false;
        
        foreach ($userDatabase as $user) {
            
            if ($this->email == $_SESSION['email']) {
                $emailOk = true;
            } else if ( $this->email == $user['email']){
                $this->message = "cette adresse appartient à un autre utilisateur";
                $emailOk = false;
                break;
            } else {
                $emailOk = true;
            }

        }

        if ($emailOk == true){
            $password = password_hash($password, PASSWORD_DEFAULT);
            $request = $this->database->prepare("UPDATE user SET `email` = (?) , `first_name` = (?) , `last_name` = (?) , `password` = (?) WHERE `user`.`id` = (?)");
            $request->execute(array($email, $firstname, $lastname, $password, $_SESSION['id_user']));
        
              //echo "votre profil a bien été modifier";
            //   $_SESSION['message_profil'] = "votre profil a bien été modifier";
              $this->message = "votre profil a bien été modifier";
            }               
    }

    public function changePassword($new_password) {

        // $request = $this->database->prepare('SELECT * FROM user');
        // $request->execute(array());
        // $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $request = $this->database->prepare("UPDATE user SET `password` = (?) WHERE `user`.`id` = (?)");
        $request->execute(array($new_password, $_SESSION['id_user']));
        $this->message = "le mot de passe a été modifier";

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
