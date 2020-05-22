<?php
	/**
	 * @Name: Article Class
	 * @Description: Creates an Article Object from an 
	 * 							 associative array of args[]
	 * @Parameters: 
	 *		        srcType - type of source - always 'a' for article
	 *		        srcId - corresponds to srcId in the Source table. 
	 *										Id for source based on its type
	 *					  year - year the article was published
	 *						journal - name of the journal
	 *						volume - string for the volume title
	 *						issue - string for issue number or lack thereof
	 *						authors - array of author objects. Empty until
	 *										  getAuthors($source, $srcType, $srcId) 
	 *											is called
	 *		inherited:
	 *						id - unique id for source in Source table
	 *						title - name of source, article name
	 *						srcLocation - string containing the file directory
	 *												  path for the stored source. 
	 *            
	 * @Methods: 
	 * 		__construct($args=[])
	 * 		//Setter Methods
	 *  	static public function clearAuthors()
	 *  	static public function getAuthors($source{})
	 *  	public function getsrcId()
	 * 		//Database Methods
	 * 	  static public function findBySql($sql)
	 * 		static public function findBySqlCount($sql)
	 * 		static protected function instantiate($record[]) - 
	 * 				row to object
	 * 		//VALIDATION
	 * 		static public function findExistingAuthors($source{})
	 * 	  static public function checkIfDirectoryExists($target_dir)
	 * 		//CREATE
	 * 		static public function insert($source{})
	 * 		static public function insertAuthors($source{})
	 * 		static public function uploadSource($source{}, $file)
	 * 		//READ
	 * 		static public function find_all()
	 *    static public function findByTitle($title)
	 * 		//DELETE
	 * 		static public function delete($srcId)
	 * 		//UPDATE
	 * 		static public function update($source{}, $update[])
	 * 		//Create Citation
	 * 		static public function createCitation($source{})
	 * @Author: Jacob Conner
	 * @LastUpdate: 4/27/2019
	 */
	
class Article extends Source{
    //PARAMETERS
    public $id;
    public $year;
    public $journal;
    public $volume;
    public $issue;
    public $authors;
	
	//CONSTRUCTOR
    public function __construct($args=[]) {
        parent::__construct($args);  
        $this->srcType = 'a';
        $this->year = $args['year'] ?? '';
        $this->journal = $args['journal'] ?? '';
        $this->volume = $args['volume'] ?? '';
        $this->issue = $args['issue'] ?? '';
        $this->authors = $args['authors'] ?? [];
        $this->srcId = $this->getsrcId();
	}
	
	//getter Methods
	public function getAuthors(){
		return $this->authors;
	}
	//SETTER METHODS
	public function clearAuthors(){
	  $this->authors = []; 
	}
	public function equals($rhs){
		if($this->$id == $rhs->$id &&
		  $this->year == $rhs->year &&
		  $this->journal == $rhs->journal &&
		  $this->volume == $rhs->volume &&
		  $this->issue == $rhs->issue &&
		  $this->authors = $rhs->authors
		){
			return true;
		}
		else
		{
			return false;
		}
	}
	public function getSrcType(){return $this->srcType;}

	static public function getAuthorsFromDB($source){
		$source->authors = Source::get_creators("author", $source);
	}
	
	public function getsrcId(){
		$sql = "SELECT MAX(srcId) AS id ";
		$sql .= "FROM sources ";
		$sql .= "WHERE srcType ='a'";
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
	
    //DATABSE METHODS
	static public function findBySql($sql) {	
		$object_array = [];
		try{
			$result = self::$database->prepare($sql);
			$result->execute();
			$result->setFetchMode(PDO::FETCH_ASSOC); 
			// results into objects
			//$objects = [];
			while($record = $result->fetch()) {
				//array_push($objects, self::instantiate($record));
				//print_r($record);
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

    static public function findBySqlCount($sql) {
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
    static public function getSourceBy($name, $authorType){
		$query = Source::getSourceByQuery($name, "a", $authorType);
		$obj_array = self::findBySql($query);
		if(!empty($obj_array)) {
			return $obj_array;
		} else {
			return false;
		}
	}

	//VALIDATION
	public function checkIfExists()
	{
		$query = "SELECT * ";
		$query .= " FROM sources ";
		$query .= " WHERE title= '" . $this->title. "'";
		$query .= " AND journal = '" . $this->journal. "'";
		$query .= " AND year= '" . $this->year. "'";
		$query .= " AND srcType = 'a'";  
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
		$query .= " AND journal = '" . $source->journal. "'";
		$query .= " AND year= '" . $source->year. "'";
		$query .= " AND srcType = 'a'";  
		return self::findBySql($query);
		$total =  self::findBySqlCount($query);
        if($total > 0){
          return true;
        }
        return false;
    }
	
	static public function findExistingAuthors($source){
		$sql = "SELECT * ";
		$sql .= "FROM authors ";
		$sql .= "WHERE source_type ='a' ";
		$sql .= "AND source_id = '". $source->srcId . "' ";
		$sql .= "AND author_type='author'";
		
		$result = self::$database->prepare($sql);
		$result->execute();
		if(!$result) {
			exit("Database query failed.");
		}
		$result->setFetchMode(PDO::FETCH_ASSOC); 
		$existingAuthors = [];
		while($record = $result->fetch()) {
			array_push($existingAuthors, $record['author_name']);
		}
		return $existingAuthors;
    }
	
	//CREATE
	static public function insertSource($source){
		$query = "INSERT INTO sources";
		$query .= "(srcType, srcId, year, title, journal, volume, issue, srcLocation) ";
		$query .= "VALUES('";
		$query .= $source->srcType . "', '";
		$query .= $source->srcId . "', '";
		$query .= $source->year . "', '";
		$query .= $source->title . "', '";
		$query .= $source->journal . "', '";
		$query .= $source->volume . "', '";
		$query .= $source->issue . "', '";
		$query .= $source->srcLocation;
		$query .= "')";
		Parent::insert($source, $query);
	}
	
	static public function insertAuthors($source){
		Source::insert_creator("author", $source);			
	}		
	
	static public function uploadFile($source, $file){
		Source::uploadSource($source, $file);
	}
	
	//READ
	static public function findAll() {
		$sql = "SELECT id, srcType, srcId, year, title,
		journal, volume, issue, srcLocation";
		return self::findBySql($sql);
    }
    
    static public function findById($srcType, $srcId) {
		$query  = "SELECT * FROM sources ";
		$query .= "INNER JOIN authors ";
		$query .= "ON authors.srcId = sources.srcId ";
		$query .= "WHERE authors.srcId='" . $srcId . "' ";
		$query .= "AND authors.srcType='" . $srcType . "'";
		$obj_array = self::findBySql($query);
		if(!empty($obj_array)) {
			return array_shift($obj_array);
		} else {
			return false;
		}
    }
      
    static public function findByTitle($title) {
		$query = "SELECT * ";
		$query .= " FROM sources ";
		$query .= " WHERE title= '" . $title. "'";
		$query .= " AND srcType = 'a'";  
		return self::findBySql($query);
    }
    
    //DELETE
    static public function deleteById($srcId) {
		$query = "DELETE ";
		$query .= " FROM sources ";
		$query .= " WHERE srcId= '" . $srcId. "'";
		$query .= " AND srcType = 'a'";  
		$result = self::$database->prepare($query);
		$result->execute();
		
		if(!$result) {
			exit("Database query failed.");
		}
    }
	
	//UPDATE
    static public function updateSource($source, $update) {
		$attribute_pairs = [];
		foreach($update as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$query = "UPDATE sources SET ";
		$query .= join(', ', $attribute_pairs);      
		$query .= " WHERE srcType = '" . $source->srcType . "'";
		$query .= " AND srcId = '". $source->srcId . "'"; 
	
		$result = self::$database->prepare($query);
		$result->execute();
      
		if(!$result) {
			exit("Database query failed.");
			$updateNote = "Failed: " . $source->title . " did not update successfully.";
			echo $updateNote . "<br />";
			Update::updateRecord($source->srcId, $source->srcType, "Update Article", FALSE, $updateNote);
		}
		$updateNote = "Update success: " . Article::create_citation($source);
		$updateNote .= " has been updated to " . Article::create_citation($update);
		echo $updateNote . "<br />";
		Update::updateRecord($source->srcId, $source->srcType, "Update Article", TRUE, $updateNote);
    }
	
	//MISC METHODS
	//member function to create a citation
	public function createCitation(){
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
        !empty($this->year) ?  $citation .= $this->year . ". " : null;
        !empty($this->title) ?$citation .= $this->title . ". " : null;
        !empty($this->journal) ? $citation .= "<em>" . $this->journal . "</em>. " : null;
        !empty($this->volume) ? $citation .= "vol " . $this->volume : null;
        !empty($this->issue) ? $citation .= "(" . $this->issue . ")" : null;
        $citation .= ".";
        return $citation;
	}

	//static function to create a citation
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
        !empty($source->year) ?  $citation .= $source->year . ". " : null;
        !empty($source->title) ?$citation .= $source->title . ". " : null;
        !empty($source->journal) ? $citation .= "<em>" . $source->journal . "</em>. " : null;
        !empty($source->volume) ? $citation .= "vol " . $source->volume : null;
        !empty($source->issue) ? $citation .= "(" . $source->issue . ")" : null;
        $citation .= ".";
        return $citation;
    } 
  }

?>