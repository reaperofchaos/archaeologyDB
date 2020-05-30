<?php
    class Plant {
        public $id; 
        public $siteId;
        public $siteName; 
        public $name;
        public $type;
        public $class;
        public $order;
        public $family;
        public $subFamily;
        public $tribus;
        public $genus;
        public $species;
        public $subSpecies;
        public $japaneseName; 
        public $quantity;
        public $srcId;
        public $srcType;

        static protected $database;

        static public function set_database($database) {
            self::$database = $database;
        }

        //constructor
        public function __construct($args=[]) {
            $this->siteId = $args['siteId'] ?? '';
            $this->siteName = $args['siteName'] ?? '';
            $this->name = $args['name'] ?? '';
            $this->type = $args['type'] ?? '';
            $this->class = $args['class'] ?? '';
            $this->order = $args['order'] ?? '';
            $this->family = $args['family'] ?? '';
            $this->subFamily = $args['subFamily'] ?? '';
            $this->tribus = $args['tribus'] ?? '';
            $this->genus = $args['genus'] ?? '';
            $this->species = $args['species'] ?? '';
            $this->subSpecies = $args['subSpecies'] ?? '';
            $this->japaneseName = $args['japanese_name'] ?? '';
            $this->plant_type = $args['japanese_name'] ?? '';

            $this->quantity = $args['quantity'] ?? ''; 
            $this->srcId = $args['srcId'] ?? '';
            $this->srcType = $args['srcType'] ?? '';
        } 

        //functions
        static public function findBySql($sql) {
            $result = self::$database->prepare($sql);
            $result->execute();
            
            if(!$result) {
                exit("Database query failed.");
            }
            $result->setFetchMode(PDO::FETCH_ASSOC); 
            // results into objects
            $object_array = [];
            while($record = $result->fetch()) {
                $object_array[] = self::instantiate($record);
            }  
            $result=null;
            return $object_array;
        }

        static public function find_by_sql_count($sql) {
            $result = self::$database->prepare($sql);
            $result->execute();
            if(!$result) {
                exit("Database query failed.");
            }
            // results into value
            $count = $result->fetchColumn();
            return $count;
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
        
        //get all individuals
        public static function find_all_plants_by_limit($start, $limit)
        {
            $query =  "SELECT * ";
            $query .= " FROM plant_types";
            $query .= " ORDER BY name ASC";
            $query .= " Limit " . $start .", " . $limit;
            $obj_array = self::findBySql($query);
            if(!empty($obj_array)) {
                return $obj_array;
            } else {
                return false;
            }
        }

        static public function find_by_id($srcType, $srcId) {
            $query = "SELECT * ";
            $query .= " FROM plant";
            $query .= " INNER JOIN jomon_sites";
            $query .= " ON jomon_sites.siteId = plant.siteId";
            $query .= " INNER JOIN plant_types.name = plant.plantName";
            $query .= " WHERE srcId='" . $srcId . "'";
            $query .= " AND srcType='" . $srcType . "'";
            $query .= " ORDER by siteName ASC";
            $obj_array = self::find_by_sql($query);
            return $obj_array;
        }   

        //display record label
        public function displayRecord()
        {
            echo "<tr>
                    <td>
                        <input type='checkbox' class='plantRecord' value='" .h($this->id) . "' />
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