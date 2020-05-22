<?php
    class Radiocarbon {
        public $id;
        public $labNo;
        public $artifactNo;
        public $date;
        public $standardError;
        public $site;
        public $material;
        public $context;
        public $collectedBy;
        public $submittedBy;
        public $srcType;
        public $srcId; 
        public $articleTitle;
        public $articleCitation; 
        public $indirectSrc;
        
        static protected $database;

        static public function set_database($database) {
            self::$database = $database;
        }

        //constructor
        public function __construct($args=[]) {
            $this->id = $args['id'] ?? '';
            $this->labNo = $args['labNo'] ?? '';
            $this->artifactNo = $args['artifactNo'] ?? '';
            $this->date = $args['date'] ?? '';
            $this->standardError = $args['standardError'] ?? '';
            $this->site = $args['site'] ?? '';
            $this->material = $args['material'] ?? ''; 
            $this->context = $args['context'] ?? '';
            $this->collectedBy = $args['collectedBy'] ?? '';
            $this->submittedBy = $args['submittedBy'] ?? '';
            $this->srcType = $args['srcType'] ?? '';
            $this->srcId = $args['srcId'] ?? '';
            $this->articleTitle = $args['articleTitle'] ?? '';
            $this->articleCitation = $args['articleCitation'] ?? '';
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
            $query .= " FROM radiocarbon_dates";
            $query .= " WHERE srcId='" . $srcId . "'";
            $query .= " AND srcType='" . $srcType . "'";
            $query .= " ORDER by site ASC";
            $obj_array = self::find_by_sql($query);
            return $obj_array;
        }   

    }    
?>