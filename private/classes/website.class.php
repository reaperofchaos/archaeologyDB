<?php
    class Website extends Source{

        //constructor
        public $title;
        public $date;
        public $publisher; 
        public $website;  
        public $webmasters;

        public function __construct($args=[]) {
                parent::__construct($args);  
                $this->title = $args['title'] ?? ''; 
                $this->date = $args['date'] ?? '';
                $this->year = date("Y", strtotime($this->date));
                $this->publisher = $args['publisher'] ?? '';
                $this->website = $args['website'] ?? '';
                $this->srcType = 'w'; 
                $this->srcId = $this->getsrcId();
                $this->webmasters = [];
        }

        public function getsrcId(){
            $sql = "SELECT MAX(srcId) AS id ";
            $sql .= "FROM sources ";
            $sql .= "WHERE srcType ='w'";
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

        //VALIDATION
	public function checkIfExists()
	{
		$query = "SELECT * ";
		$query .= " FROM sources ";
		$query .= " WHERE title= '" . $this->title. "'";
		$query .= " AND website = '" . $this->website. "'";
		$query .= " AND date = '" . $this->date. "'";
		$query .= " AND srcType = 'w'";  
        $total =  self::findBySqlCount($query);
        if($total > 0){
          return true;
        }
		return false;
	}

	static public function checkIfSrcExists($source){
		$query = "SELECT * ";
		$query .= " FROM sources ";
		$query .= " WHERE title= '" . $source->title. "'";
		$query .= " AND website = '" . $this->website. "'";
		$query .= " AND date = '" . $this->date. "'";
		$query .= " AND srcType = 'w'";    
		return self::findBySql($query);
		$total =  self::findBySqlCount($query);
        if($total > 0){
          return true;
        }
        return false;
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
                $query .= " WHERE sources.srcId='" . $srcId . "'";
                $query .= " AND sources.srcType='" . $srcType . "'";
                $obj_array = self::findBySql($query);
                if(!empty($obj_array)) {
                    return array_shift($obj_array);
                } else {
                    return false;
                }
        }
        
        static public function getWebmasters($source){
            $webmasters =[];
            $sql = "SELECT * ";
            $sql .= "FROM authors ";
            $sql .= "WHERE srcId = '" . $source->srcId . "'";
            $sql .= " AND srcType= '" . $source->srcType . "'";
            $sql .= " AND authorType = 'webmaster'";
        
            $result = self::$database->prepare($sql);
            $result->execute();
              
            if(!$result) {
                exit("Database query failed.");
            }
            $result->setFetchMode(PDO::FETCH_ASSOC); 
            while($record = $result->fetch()) {
                array_push($webmasters, $record['authorName']);
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
        static public function insertWebMasters($source){
            Source::insert_creator("webmaster", $source);			
        }
        static public function insertSource($source){
            $query = "INSERT INTO sources";
            $query .= "(srcType, srcId, title, date, publisher, website, srcLocation) ";
            $query .= "VALUES('";
            $query .= $source->srcType . "', '";
            $query .= $source->srcId . "', '";
            $query .= $source->title . "', '";
            $query .= $source->date . "', '";
            $query .= $source->publisher . "', '";
            $query .= $source->website . "', '";
            $query .= $source->srcLocation;
            $query .= "')";
            Parent::insert($source, $query);
        }
        static public function uploadFile($source, $file){
            Source::uploadSource($source, $file);
        }
        
        static public function create_citation($website){  
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
        public function createCitation(){  
            $citation = "";
            !empty($this->title) ?$citation .= $this->title . ". " : null;
            if(!empty($this->webmasters)){
        	$webmasters =$this->webmasters;
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
            !empty($this->publisher) ? $citation .= $this->publisher : null;
            !empty($this->website) ? $citation .= " Website: " . $this->website . ".": null;
            !empty($this->date) ?  $citation .= " Accessed on " .$this->date . ". " : null;
            return $citation;
        } 
    }
?>