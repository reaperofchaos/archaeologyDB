<?php
    //Abstract class is not allowed, so you are now a summary
    class Summary extends Source {
        //constructor
        public $date;
        public $location; 
        public $website; 
        public $conference;
        public $conferenceId; 
        public $authors; 

        public function __construct($args=[]) {
                parent::__construct($args);  
                $this->date = $args['date'] ?? '';
                $this->location = $args['location'] ?? '';
                $this->website = $args['website'] ?? '';
                $this->conference = $args['conference'] ?? '';
                $this->conferenceId = Summary::getConferenceId($this->conference);
                $this->srcType = 'ab';
                $this->srcId = $this->getsrcId();
                $this->authors = [];
        }

        //getter Methods
        public function getAuthors(){
            return $this->authors;
        }

        public function getSrcId(){
            //create if it does note exist;
            if(!Summary::checkIfSrcExists($this))
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
        //Static method to check if a source is in DB
      static public function checkIfSrcExists($source)
      {
          $query = "SELECT * ";
          $query .= " FROM sources ";
          $query .= " WHERE title= '" . $source->title. "'";
          $query .= " AND date = '" . $source->date. "'";
          $query .= " AND srcType = 'ab'";  
          $total =  self::findBySqlCount($query);
          if($total > 0){
            return true;
          }
          return false;
      }

      public function retrieveSrcID()
      {
          $query = "SELECT srcId ";
          $query .= " FROM sources ";
          $query .= " WHERE title= '" . $this->title. "'";
          $query .= " AND date = '" . $this->date. "'";
          $query .= " AND srcType = 'ab'";
          $query .= " LIMIT 1";
          $result = self::$database->prepare($query);
          $result->execute();
          if($result)
          {
            $r =$result->fetch();
            return $r['srcId'];
          }
      }
      
      static public function getSourceBy($name, $authorType){
        $query = Source::getSourceByQuery($name, "ab", $authorType);
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
        
        static public function getAuthorsFromDB($source){
            Source::get_creators("author", $source);
        }
        
        public function createCitation(){  
            $citation = "";
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
            !empty($this->date) ?  $citation .= $this->date . ". " : null;
            !empty($this->title) ? $citation .= $this->title . ". " : null;
            !empty($this->conference) ? $citation .= "Presented at " . $this->conference : null;
            !empty($this->location) ? $citation .= "(" . $this->location . ")" : null;
            return $citation;
        } 

        static public function create_citation($source){  
            $citation = "";
            if(!empty($source->authors)){
                $authors = $source->authors;
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
            !empty($source->date) ?  $citation .= $source->date . ". " : null;
            !empty($source->title) ?$citation .= $source->title . ". " : null;
            !empty($source->conference) ? $citation .= "Presented at " . $source->conference : null;
            !empty($source->location) ? $citation .= "(" . $source->location . ")" : null;
            return $citation;
        }
        
        static public function uploadFile($source, $file){
            Source::uploadSource($source, $file);
        }
    }
?>