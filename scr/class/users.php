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
            $this->database = new PDO('mysql:host=localhost;dbname=boutique;charset=utf8;port=3306', 'root', '');
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Méthodes 

    public function register($email, $firstname, $lastname, $password) {

        $request = $this->database->prepare('SELECT * FROM users');
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
          $request = $this->database->prepare("INSERT INTO user (email, firstname, lastname, password, id_role, register_date) VALUES (?, ?, ?, ?,NOW())");
          $request->execute(array($this->email, $firstname, $lastname, $password, $role_id));
    
          echo "tu est inscrit";
        }        
          
        
    }

    public function connection($email, $password) {
        //session_start();

        $request = $this->database->prepare('SELECT u.`id` , `email` , `firstname` , `lastname` , `password` , `rights` FROM user u INNER JOIN role ON role.id = u.role_id');
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
                $_SESSION["firstname"] = $user["firstname"];
                $_SESSION["rights"] = $user["rights"];
                $logged = true;
                break;

            } else {
                $logged = false;
            }
            //var_dump($user);
        }

        //echo $_SESSION["username"];

        if( $logged ) {
            echo "vous êtes connecté ".$_SESSION['username']." en tant que: ".$_SESSION['rights'];
            //var_dump($user);
            header('Location: index.php');
        } else {
            echo "erreur dans l'email ou le password</br>";
        }

    }

    public function getData() {
        return $this->database;
    }

}

//$user = new users;

 //$user->register("test@test.com","test","test");
//$user->register("test@test4.com","test5","test5");
// $user->register("yolo@fimo.com","yolo","stand");
//$user->connection("test@test.com","test");
// $user->connection("admin@wild.com","azeradmin");
// echo $user->getAllUsers()['email'];
// echo $user->getAllUsers()['email'];
// echo $user->getAllUsers()['email'];

?>
