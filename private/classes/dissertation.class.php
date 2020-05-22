<?php
    class Dissertation extends Source{
        //constructor
        public $date;
        public $year;
        public $level; 
        public $location; 
        public $authors;
        public $supervisors;

        

        public function __construct($args=[]) {
                parent::__construct($args);  
                $this->date = $args['date'] ?? '';
                $this->year = date("Y", strtotime($this->date));
                $this->location = $args['location'] ?? '';
                $this->level = $args['level'] ?? '';
                $this->srcType = 'd'; 
                $this->authors = [];
                $this->supervisors = [];

        }

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
              echo $e . "<br />"; 
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

        static public function findById($srcType, $srcId) {
                $query = "SELECT * ";
                $query .= " FROM sources";
                $query .= " INNER JOIN authors";
                $query .= " ON authors.srcId = sources.srcId";
                $query .= " WHERE authors.srcId='" . $srcId . "'";
                $query .= " AND authors.srcType='" . $srcType . "'";
                $obj_array = self::findBySql($query);
                if(!empty($obj_array)) {
                    return array_shift($obj_array);
                } else {
                    return false;
                }
        }
        static public function getAuthors($source){
            $source->authors = Source::get_creators("author", $source);
        }
        
        static public function getSupervisors($source){
            $source->supervisors = Source::get_creators("supervisor", $source);
        }
        
        static public function getSourceBy($name, $authorType){
            $query = Source::getSourceByQuery($name, "d", $authorType);
            $obj_array = self::findBySql($query);
            if(!empty($obj_array)) {
              return $obj_array;
            } else {
              return false;
            }
        }
      
        //member function to check if a source is in db
        public function checkIfExists()
        {
            $query = "SELECT * ";
            $query .= " FROM sources ";
            $query .= " WHERE title= '" . $this->title. "'";
            $query .= " AND date = '" . $this->date. "'";
            $query .= " AND location = '" . $this->location. "'";
            $query .= " AND srcType = 'd'";  
            return self::findBySql($query);	
        }

        static public function insertDissertation($source){
            $query = "INSERT INTO sources";
            $query .= "(srcType, srcId, date, title, level, location, srcLocation) ";
            $query .= "VALUES('";
            $query .= $source->srcType . "', '";
            $query .= $source->srcId . "', '";
            $query .= $source->date . "', '";
            $query .= $source->title . "', '";
            $query .= $source->level . "', '";
            $query .= $source->location . "', '";
            $query .= $source->srcLocation;
            $query .= "')";
            Source::insert($source, $query);
        }

        public function createCitation()
        {
            $citation = "";
            if(!empty($this->authors)){
                $authors = $this->authors;
                $i = 1;
                $length = count($authors);
                foreach($authors as $a){
                    if($i == $length){
                        $citation .= $a . ". ";
                    }else{
                        $citation .= $a . ", ";
                        }
                            $i++;
                }
            }
            if(!empty($this->supervisors)){
                $supervisors = $this->supervisors;
                $i = 1;
                $length = count($supervisors);
                $citation .= "Supervised by ";
                foreach($supervisors as $a){
                    if($i == $length){
                        $citation .= $a . ". ";
                    }else{
                        $citation .= $a . ", ";
                        }
                            $i++;
                }
            }
            !empty($this->date) ?  $citation .= $this->date . ". " : null;
            !empty($this->title) ?$citation .= $this->title . ". " : null;
            !empty($this->level) ? $citation .= $this->level : null;
            !empty($this->location) ? $citation .= " ( Completed at " . $this->location . ")" : null;
            return $citation; 
        }

        static public function create_citation($dissertation){  
            $citation = "";
            if(!empty($dissertation->authors)){
                $authors =$dissertation->authors;
                $i = 1;
                $length = count($authors);
                foreach($authors as $a){
                    if($i == $length){
                        $citation .= $a . ". ";
                    }else{
                        $citation .= $a . ", ";
                        }
                            $i++;
                }
            }
            if(!empty($dissertation->supervisors)){
                $supervisors =$dissertation->supervisors;
                $i = 1;
                $length = count($supervisors);
                $citation .= "Supervised by ";
                foreach($supervisors as $a){
                    if($i == $length){
                        $citation .= $a . ". ";
                    }else{
                        $citation .= $a . ", ";
                        }
                            $i++;
                }
            }
            !empty($dissertation->date) ?  $citation .= $dissertation->date . ". " : null;
            !empty($dissertation->title) ?$citation .= $dissertation->title . ". " : null;
            !empty($dissertation->level) ? $citation .= $dissertation->level : null;
            !empty($dissertation->location) ? $citation .= " ( Completed at " . $dissertation->location . ")" : null;
            return $citation;
        }
        
        static public function uploadFile($source, $file){
            Source::uploadSource($source, $file);
        }
    }
?>