<?php
    class Video extends Source{
        
             //constructor
             public $date;
             public $year;
             public $publisher;
             public $website; 
             public $creators;
             public $uploaders;
     
             public function __construct($args=[]) {
                     parent::__construct($args);  
                     $this->date = $args['date'] ?? '';
                     $this->year = date("Y", strtotime($this->date));
                     $this->publisher = $args['publisher'] ?? ''; 
                     $this->website = $args['website'] ?? '';
                     $this->creators = [];
                     $this->uploaders = [];
             }
             
             public function getSrcId(){
                //create if it does note exist;
                if(Radio::checkIfSrcExists($this))
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
                     $query .= " ON authors.source_id = sources.srcId";
                     $query .= " WHERE srcId='" . $srcId . "'";
                     $query .= " AND srcType='" . $srcType . "'";
                     $obj_array = self::findBySql($query);
                     if(!empty($obj_array)) {
                         return array_shift($obj_array);
                     } else {
                         return false;
                     }
             }
             static public function getVideoCreators($source){
               Source::getCreators("creator", $source);
            }

            static public function getSourceBy($name, $authorType){
                $query = Source::getSourceByQuery($name, "v", $authorType);
                $obj_array = self::findBySql($query);
                if(!empty($obj_array)) {
                  return $obj_array;
                } else {
                  return false;
                }
            }
            
            static public function getUploaders($source, $srcType, $srcId){
                Source::getCreators("creator", $source);
            } 

            static public function insertSource($source){
                $query = "INSERT INTO sources";
                $query .= "(srcType, srcId, date, title, website) ";
                $query .= "VALUES('";
                $query .= $source->srcType . "', '";
                $query .= $source->srcId . "', '";
                $query .= $source->date . "', '";
                $query .= $source->title . "', '";
                $query .= $source->website . "', '";
                $query .= $source->srcLocation . "')";
                Source::insert($source, $query);
            }
            static public function insertCreators($source){
                Source::insert_creator("creator", $source);			
            }
            static public function insertUploaders($source){
                Source::insert_creator("uploader", $source);			
            }

            //member method to check if source is in DB
        public function checkIfExists(){
            $query  = "SELECT * ";
            $query .= " FROM sources ";
            $query .= " WHERE title= '" . $this->title . "'";
            $query .= " AND date = '" . $this->date ."'";  
            $query .= " AND website = '" . $this->website ."'";
            $query .= " AND srcType = 'v'";  
            $total  =  self::findBySqlCount($query);
            if($total > 0){
            return true;
            }
            return false;
        }

        //static method
        static public function checkIfSrcExists($source){
            $query = "SELECT * ";
            $query .= " FROM sources ";
            $query .= " WHERE title= '" . $source->title . "'";
            $query .= " AND date = '" . $source->date ."'";  
            $query .= " AND website = '" . $source->website ."'";
            $query .= " AND srcType = 'v'";    
            $total =  self::findBySqlCount($query);
            if($total > 0){
            return true;
            }
            return false;
        }

        public function retrieveSrcId(){
            $query = "SELECT srcId ";
            $query .= " FROM sources ";
            $query .= " WHERE title= '" . $this->title . "'";
            $query .= " AND date = '" . $this->date ."'";  
            $query .= " AND website = '" . $this->website ."'";
            $query .= " AND srcType = 'v'";    
            $result = self::$database->prepare($query);
            $result->execute();
            if($result)
            {
                $r =$result->fetch();
                return $r['srcId'];
            }
        }

             static public function createCitation($video){  
                $citation = "";
                if(!empty($video->creators)){
                    $creators =$video->creators;
                    $i = 1;
                    $length = count($creators);
                    foreach($creators as $a){
                        if($i == $length){
                            $citation .= $a . ". ";
                        }else{
                            $citation .= $a . ", ";
                            }
                                $i++;
                    }
                }
                if(!empty($video->uploaders)){
                    $creators =$video->uploaders;
                    $i = 1;
                    $length = count($uploaders);
                    $citation .= "Uploaded by ";
                    foreach($uploaders as $a){
                        if($i == $length){
                            $citation .= $a . ". ";
                        }else{
                            $citation .= $a . ", ";
                            }
                                $i++;
                    }
                }
                !empty($video->date) ?  $citation .= $video->date . ". " : null;
                !empty($video->title) ?$citation .= $video->title . ". " : null;
                !empty($video->website) ? $citation .= " Website: " . $video->website : null;
                 return $citation;
             } 
        
        static public function uploadFile($source, $file){
            Source::uploadSource($source, $file);
        }
    }
?>