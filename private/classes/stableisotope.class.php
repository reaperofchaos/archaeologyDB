<?php
    class StableIsotope {
        public $id;
        public $siteId;
        public $site;
        public $timePeriod;
        public $sampleId;
        public $species;
        public $element;
        public $age;
        public $sex;
        public $c13;
        public $n15;
        public $srcType; 
        public $srcId; 
        public $indirectSrc;
        
        static protected $database;

        static public function set_database($database) {
            self::$database = $database;
        }

        //constructor
        public function __construct($args=[]) {
            $this->id = $args['id'] ?? '';
            $this->siteId = $args['siteId'] ?? '';
            $this->timePeriod = $args['timePeriod'] ?? '';
            $this->sampleId = $args['sampleId'] ?? '';
            $this->species = $args['species'] ?? '';
            $this->element = $args['element'] ?? '';
            $this->age = $args['age'] ?? ''; 
            $this->sex = $args['sex'] ?? '';
            $this->c13 = $args['c13'] ?? '';
            $this->n15 = $args['n15'] ?? '';
            $this->srcType = $args['srcType'] ?? '';
            $this->srcId = $args['srcId'] ?? '';
            $this->indirectSrc = $args['indirectSrc'] ?? '';
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
            //echo $srcType . "<br />" . $srcId;
            $query = "SELECT * ";
            $query .= " FROM stable_isotopes";
            $query .= " WHERE srcId='" . $srcId . "'";
            $query .= " AND srcType='" . $srcType . "'";
            $query .= " ORDER by site ASC";
            $obj_array = self::find_by_sql($query);
            return $obj_array;
        }   

    }    
?>