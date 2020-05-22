<?php
    class Presentation extends Source {
        //constructor
        public $date;
        public $location; 
        public $website; 
        public $conference; 
        public $conferenceId;
        public $presenters; 

        public function __construct($args=[]) {
                parent::__construct($args);  
                $this->date = $args['date'] ?? '';
                $this->location = $args['location'] ?? '';
                $this->website = $args['website'] ?? '';
                $this->conference = $args['conference'] ?? '';
                $this->presenters = [];
                $this->srcType = "pr";
                $this->srcId = $this->getsrcId();
                $this->conferenceId = Presentation::getConferenceId($this->conference) ?? 0;
        }

        public function getSrcId(){
            //create if it does note exist;
            if(Presentation::checkIfSrcExists($this))
            {
               $sql = "SELECT MAX(srcId) AS id ";
               $sql .= "FROM sources ";
               $sql .= "WHERE srcType ='". $this->srcType . "'";
               $result = self::$database->prepare($sql);
               $result->execute();
              if(!$result) {
                exit("Database query failed.");
              }
              $result->setFetchMode(PDO::FETCH_ASSOC); 
              while($record = $result->fetch()) {
                    $srcId = $record['id'];
              }
              return $srcId + 1;
            }else{
              return $this->retrieveSrcID();
            }  
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
                $query .= " AND authors.srcType = sources.srcType";
                $query .= " INNER JOIN conference";
                $query .= " ON conference.conf_id = sources.conferenceId";
                $query .= " WHERE authors.srcId='" . $srcId . "'";
                $query .= " AND authors.srcType='" . $srcType . "'";
                $obj_array = self::findBySql($query);
                if(!empty($obj_array)) {
                    return array_shift($obj_array);
                } else {
                    return false;
                }
        }

        static public function getPresenters($source){
            $source->presenters = Source::get_creators("presenter", $source);
        }

        static public function getSourceBy($name, $authorType){
            $query = Source::getSourceByQuery($name, "pr", $authorType);
            $obj_array = self::findBySql($query);
            if(!empty($obj_array)) {
              return $obj_array;
            } else {
              return false;
            }
        }

        static public function getConferenceId($conference){
            $query = "SELECT conf_id FROM conference";
            $query .= " WHERE conference = '" . $conference ."'";
            $query .= " LIMIT 1";
            try
            {
                $result = self::$database->prepare($query);
                $result->execute();
                if($result)
                {
                    $r = $result->fetch();
                    return $r['conf_id'];
                }
            }
            catch(PDOException $e)
            {
                echo "Failed to retrieve conference ID <br />";
                echo $e->getMessage() . "<br />";
            }
            return 0;
        }

        static public function insertSource($source){
            $query = "INSERT INTO sources";
            $query .= "(srcType, srcId, date, title, location, website, conferenceId, srcLocation) ";
            $query .= "VALUES('";
            $query .= $source->srcType . "', '";
            $query .= $source->srcId . "', '";
            $query .= $source->date . "', '";
            $query .= $source->title . "', '";
            $query .= $source->location . "', '";
            $query .= $source->website . "', '";
            $query .= $source->conferenceId . "', '";
            $query .= $source->srcLocation . "')";
            Source::insert($source, $query);
        }
  
        static public function insertPresenters($source){
            Source::insert_creator("presenter", $source);			
        }

        //member method to check if source is in DB
        public function checkIfExists(){
            $query  = "SELECT * ";
            $query .= " FROM sources ";
            $query .= " WHERE title= '" . $this->title . "'";
            $query .= " AND location = '" . $this->location . "'";
            $query .= " AND srcId = '" . $this->srcId . "'";
            $query .= " AND srcType = 'pr'";  
            $total  =  self::findBySqlCount($query);
            if($total > 0){
            return true;
            }
            return false;
        }
        
        public function retrieveSrcId(){
            $query = "SELECT srcId ";
            $query .= " FROM sources ";
            $query .= " WHERE title= '" . $this->title . "'";
            $query .= " AND location = '" . $this->location . "'";
            $query .= " AND srcType = 'pr'";  
            $result = self::$database->prepare($query);
            $result->execute();
            if($result)
            {
                $r =$result->fetch();
                return $r['srcId'];
            }
        } 

      static public function checkIfSrcExists($source){
            $query = "SELECT * ";
            $query .= " FROM sources ";
            $query .= " WHERE title= '" . $source->title . "'";
            $query .= " AND location = '" . $source->location . "'";
            $query .= " AND srcId = '" . $source->srcId . "'";
            $query .= " AND srcType = 'pr'";  
            $total =  self::findBySqlCount($query);
            if($total > 0){
            return true;
            }
            return false;
        } 
        //member method to create citation
        public function createCitation(){  
            $citation = "";
            
            if(!empty($this->presenters)){
        	$presenters =$this->presenters;
        	$i = 1;
        	$length = count($presenters);
        	foreach($presenters as $a){
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
            !empty($this->conference) ? $citation .= "Presented at " . $this->conference : null;
            !empty($this->location) ? $citation .= "(" . $this->location . ")" : null;
            return $citation;
        }
        //static method to create citation
        static public function create_citation($presentation){  
            $citation = "";
            
            if(!empty($presentation->presenters)){
        	$presenters =$presentation->presenters;
        	$i = 1;
        	$length = count($presenters);
        	foreach($presenters as $a){
                    if($i == $length){
                        $citation .= $a . ". ";
                    }else{
                        $citation .= $a . ", ";
                    }
                    $i++;
        	    }
            }
            !empty($presentation->date) ?  $citation .= $presentation->date . ". " : null;
            !empty($presentation->title) ?$citation .= $presentation->title . ". " : null;
            !empty($presentation->conference) ? $citation .= "Presented at " . $presentation->conference : null;
            !empty($presentation->location) ? $citation .= "(" . $presentation->location . ")" : null;
            return $citation;
        } 

      static public function uploadFile($source, $file){
        Source::uploadSource($source, $file);
      }
    }
?>