<?php
    class fauna{
        public $id; 
        public $name;
        public $class;
        public $order;
        public $family;
        public $genus;
        public $species;
        public $japanese_name; 
        public $type; 
        public $image; 
        public $sites = [];
        public $source = [];
        public $locations = [];
        static protected $database;
        
        static public function set_database($database) {
            self::$database = $database;
        }

        //constructor
        public function __construct($args=[]) {
            $this->id = $args['id'] ?? '';
            $this->name = $args['name'] ?? '';
            $this->class = $args['class'] ?? '';
            $this->order = $args['order'] ?? '';
            $this->family = $args['family'] ?? '';
            $this->genus = $args['genus'] ?? '';
            $this->species = $args['species'] ?? '';
            $this->japanese_name = $args['japanese_name'] ?? '';
            $this->type = $args['type'] ?? '';
            $this->image = $args['image'] ?? '';
        }

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

        public static function find_all_species_by_limit($start, $limit)
        {
            $query =  "SELECT * ";
            $query .= " FROM fauna_type";
            $query .= " ORDER BY name ASC";
            $query .= " Limit " . $start .", " . $limit;
            $obj_array = self::findBySql($query);
            if(!empty($obj_array)) {
                return $obj_array;
            } else {
                return false;
            }
        }

        //display record label
        public function displayRecord()
        {
            echo "<tr>
                    <td>
                        <input type='checkbox' class='animalRecord' value='" .h($this->id) . "' />
                    </td>
                    <td>"
                        . h($this->name) .
                    "</td>
                    <td>"
                    . h($this->genus) .
                    "</td>
                    <td>"
                        . h($this->species) . 
                    "</td>
            </tr>";
        }
    }
?>
