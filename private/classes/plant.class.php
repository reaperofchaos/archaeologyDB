<?php
    class Plant {
        public $siteId;
        public $siteName; 
        public $plantName;
        public $plantType;
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
            $this->plantName = $args['plantName'] ?? '';
            $this->plantType = $args['plantType'] ?? '';
            $this->quantity = $args['quantity'] ?? ''; 
            $this->srcId = $args['srcId'] ?? '';
            $this->srcType = $args['srcType'] ?? '';
        } 

        //functions
        static public function find_by_sql($sql) {
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

        static public function find_by_id($srcType, $srcId) {
            $query = "SELECT * ";
            $query .= " FROM plant";
            $query .= " WHERE srcId='" . $srcId . "'";
            $query .= " AND srcType='" . $srcType . "'";
            $query .= " ORDER by siteName ASC";
            $obj_array = self::find_by_sql($query);
            return $obj_array;
        }   

    }    
?>