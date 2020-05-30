<?php
    class Login{
        private $userID;
        private $username;
        private $password;
        private $name;
        private $role;
        private $email;
        static protected $database;

        public function __construct($args=[]) {
            $this->userID = $args['userID'] ?? ''; 
            $this->username = $args['username'] ?? ''; 
            $this->password = $args['password'] ?? ''; 
            $this->name = $args['name'] ?? ''; 
            $this->role = $args['role'] ?? ''; 
            $this->email = $args['email'] ?? ''; 
        }

        static public function set_database($database) {
            self::$database = $database;
        }

        //getters
        public function getUserID(){return $this->userID;}
        public function getUsername(){return $this->username;}
        public function getPassword(){return $this->password;}
        public function getName(){return $this->name;}
        public function getRole(){return $this->role;}
        public function getEmail(){return $this->email;}

        //functions
        static public function findBySql($sql) {	
            $object_array = [];
            try{
                $result = self::$database->prepare($sql);
                $result->execute();
                //$result->setFetchMode(PDO::FETCH_ASSOC); 
                // results into objects
                while($record = $result->fetch()) {
                    $object_array[] = self::instantiate($record);
                }
                $result=null;
            }
            catch(PDOException $e)
            {
                echo "Query was unsuccessful. <br />";
                echo $e->getMessage() . "<br />"; 
            }
            return $object_array;
        }

        static protected function instantiate($record) {
            $object = new self;
            // Could manually assign values to properties
            // but automatically assignment is easier and re-usable
            foreach($record as $property => $value) {
                if(property_exists($object, $property)) {
                    $object->$property = $value;
                }
            }
            return $object;
        }
        static public function login($username, $password){
            $sql  = "SELECT * FROM `users` ";
            $sql .= "WHERE `username`=? ";
            $sql .= "LIMIT 1"; 
            $result = self::$database->prepare($sql);
            $result->execute([$username]);
            $user = $result->fetch();     
            return array(password_verify($password, $user['password']), $user);
        }

        public static function check_login($username= '', $pass = '', & $errors)
        {
            $errors = [];
            if(empty($username))
            {
                $errors[] = 'You forgot to enter your email address';
            }
            else
            {
                $u = trim($username);
            }
            if(empty($pass))
            {
                $errors[] = 'You forgot to enter your password';
            }
            else
            {
                $p = trim($pass);
            }
            $results = Login::login($username, $pass); 
            if($results[0])
            {
                return $results;
            }
            else
            {
                $errors[] = "The username and password entered do not match those on file.";
            }
        }
        
        public static function absolute_url($page = 'index.php')
        {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
            $url = rtrim($url, '/\\');
            $url .= '/' . $page;
            return $url;
        }

        public function addUser()
        {
                $sql  = "INSERT INTO `users` (`userName`, `password`, `name`, `role`, `email`) ";
                $sql .= "VALUES (?,?,?,?,?) ";
                try{
                    $result = self::$database->prepare($sql);
                    $hash = password_hash($this->password, PASSWORD_DEFAULT);
                    $result->execute([$this->username, $hash, $this->name, 'user', $this->email]);
                }
                catch(PDOException $e)
                {
                    echo "Error: Unable to add User <br />";
                    echo $e . "<br />";
                }        
        }

        public static function add_user($user)
        {
                $sql  = "INSERT INTO `users` (`userName`, `password`, `name`, `role`, `email`) ";
                $sql .= "VALUES (?,?,?,?,?) ";
                try{
                    $result = self::$database->prepare($sql);
                    $hash = password_hash($user->password, PASSWORD_DEFAULT);
                    $result->execute([$user->username, $hash, $user->name, 'user', $user->email]);
                }
                catch(PDOException $e)
                {
                    echo "Error: Unable to add User <br />";
                    echo $e . "<br />";
                }        
        }
        static public function checkIfUserExists($username)
        {
            $sql  = "SELECT * FROM `users` ";
            $sql .= "WHERE `username`='". $username . "'";
            $result = self::$database->prepare($sql);
            $result->execute([$username]);
            $user = $result->fetch();
            if($user)
            {
                return true; 
            }
            else
            {
                return false; 
            }
        }
    }
     
?>