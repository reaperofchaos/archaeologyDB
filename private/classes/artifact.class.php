<?php
    class Artifact {
        public $artifactId;
        public $siteId; 
        public $siteName;
        public $timePeriod;
        public $artifactClass;
        public $artifact;
        public $quantity;
        public $srcType;
        public $srcId;

        static protected $database;

        static public function set_database($database) {
            self::$database = $database;
        }

        //constructor
        public function __construct($args=[]) {
            $this->artifactId = $args['artifactId'] ?? '';
            $this->siteId = $args['siteId'] ?? '';
            $this->siteName = $args['siteName'] ?? '';
            $this->timePeriod = $args['timePeriod'] ?? '';
            $this->artifact = $args['artifact'] ?? '';
            $this->artifactClass = $args['artifactClass'] ?? '';
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
            //echo $srcType . "<br />" . $srcId;
            $query = "SELECT * ";
            $query .= " FROM artifact ";
            $query .= " INNER JOIN jomon_sites ";
            $query .= " ON jomon_sites.siteId = artifact.siteId ";
            $query .= " WHERE srcId='" . $srcId . "'";
            $query .= " AND srcType='" . $srcType . "'";
            $query .= " ORDER by jomon_sites.siteName ASC";
            $obj_array = self::find_by_sql($query);
            return $obj_array;
        }   

    }    
?>