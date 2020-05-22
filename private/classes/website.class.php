<?php
    class Website extends Source{

        //constructor
        public $date;
        public $publisher; 
        public $website;  
        public $webmasters;

        public function __construct($args=[]) {
                parent::__construct($args);  
                $this->date = $args['date'] ?? '';
                $this->year = date("Y", strtotime($this->date));
                $this->publisher = $args['publisher'] ?? '';
                $this->website = $args['website'] ?? '';
                $this->webmasters = [];
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
        
        static public function getWebmasters($source, $srcType, $srcId){
            $webmasters =[];
            $sql = "SELECT * ";
            $sql .= "FROM authors ";
            $sql .= "WHERE source_id = '" . $srcId . "'";
            $sql .= " AND source_type= '" . $srcType . "'";
            $sql .= " AND author_type = 'webmaster'";
        
            $result = self::$database->prepare($sql);
            $result->execute();
              
            if(!$result) {
                exit("Database query failed.");
            }
            $result->setFetchMode(PDO::FETCH_ASSOC); 
            while($record = $result->fetch()) {
                array_push($webmasters, $record['author_name']);
            }
            $source->webmasters = $webmasters;
        }

        static public function getSourceBy($name, $authorType){
            $query = Source::getSourceByQuery($name, "w", $authorType);
            $obj_array = self::findBySql($query);
            if(!empty($obj_array)) {
              return $obj_array;
            } else {
              return false;
            }
        }

        static public function uploadFile($source, $file){
            Source::uploadSource($source, $file);
        }
        
        static public function createCitation($website){  
            $citation = "";
            !empty($website->title) ?$citation .= $website->title . ". " : null;
            if(!empty($website->webmasters)){
        	$webmasters =$website->webmasters;
        	$i = 1;
        	$length = count($webmasters);
        	foreach($webmasters as $a){
        		if($i == $length){
         			$citation .= $a . ". ";
         		}else{
         			$citation .= $a . ", ";
         			}
         				$i++;
        	}
        }
            !empty($website->publisher) ? $citation .= $website->publisher : null;
            !empty($website->website) ? $citation .= " Website: " . $website->website . ".": null;
            !empty($website->date) ?  $citation .= " Accessed on " .$website->date . ". " : null;

            return $citation;
        } 
    }
?>