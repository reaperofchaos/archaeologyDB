<?php
	
class Bibliography{
    //PARAMETERS
	public $srcID;
	public $srcType;
	public $srcTitle;
	public $refID;
	public $refType;
	public $refTitle;
	static protected $database;

	
	//CONSTRUCTOR
    public function __construct($args=[]) {
		$this->srcID = $args['srcID'] ?? '';
		$this->srcType = $args['srcType'] ?? ''; 
		$this->srcTitle = $args['srcTitle'] ?? ''; 
		$this->refID = $args['refID'] ?? ''; 
		$this->refType = $args['refType'] ?? ''; 
		$this->refTitle = $args['refTitle'] ?? ''; 
	}
	static public function set_database($database) {
		self::$database = $database;
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
	
	static public function findBySql($sql) {
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
	
	static public function findAll($srcID, $srcType) {
		$sql = "SELECT * from bibliography ";
		$sql .= "WHERE `srcID` = '". $srcID . "'";
		$sql .= "AND `srcType` = '" . $srcType . "'";	
		return self::findBySql($sql);
	}
	static public function findReference($srcID, $refID) {
		$sql = "SELECT * from bibliography ";
		$sql .= "WHERE `srcID`= '". $srcID . "' AND ";
		$sql .= "`refID` = '" . $refID . "'";
		return self::findBySql($sql);
	}

	static public function delete($srcID, $refID){
		$sql = "DELETE * from bibliography ";
		$sql = "WHERE srcID = '" . $srcID . "' ";
		$sql = "AND refID = '" . $refID ."'";
		try{
			$result = self::$database->prepare($query);
			$result->execute();
			if(!$result) {
				exit("Database query failed.");
				$updateNote = "Failed: Reference ". $reference->title . " was not deleted from the bibliography for " . $source->title . ".";
				echo $updateNote;
				Update::updateRecord($source->srcID, "Delete", FALSE, $updateNote);
			}
			else
			{
				$updateNote = "Reference ". $reference->title . " has been deleted from the bibliography for " . $source->title . ".";
				echo $updateNote;
				Update::updateRecord($source->srcID, "Delete", TRUE, $updateNote);
			}
		}catch(PDOException $e){
			$updateNote = "Failed: Reference ". $reference->title . " was not deleted from the bibliography for " . $source->title . ".";
			$updateNote .= $e->getMesage();
			echo $updateNote;
			Update::updateRecord($source->srcID, "Delete", FALSE, $updateNote);
		}
	}
	public function equal($rhs)
	{
		if($this->srcID == $rhs->srcID &&
		  $this->srcType == $rhs->srcType &&
		  $this->srcTitle == $rhs->srcTitle &&
		  $this->refID = $rhs->refID &&
		  $this->refType = $rhs->refType &&
		  $this->refTitle == $rhs->refTitle )
		  {
			  return true;
		  }
		  else
		  {
			  return false;
		  }
	}
	
	static public function insert($source, $reference){
		//check if exists already
		$found = Bibliography::findReference($source->srcID, $reference->srcID);
		if(!$found)
		{
			$query = "INSERT INTO bibliography";
			$query .= "(srcID, srcType, srcTitle,";
			$query .= "refID, refType, refTitle)";
			$query .= "Values(" .$source->srcID . "', '";
			$query .= $source->srcType . "', '";
			$query .= $source->title . "', '";
			$query .= $reference->srcID . "', '";
			$query .= $reference->srcType . "', '";
			$query .= $reference->title . "')";
			try{
				$result = self::$database->prepare($query);
				$result->execute();
				if(!$result) {
					exit("Database query failed.");
					$updateNote = "Failed: Reference ". $reference->title . " was not inserted into the bibliography for " . $source->title . " successfully.";
					echo $updateNote . "<br />";
					Update::updateRecord($source->srcID, "Bibliography", FALSE, $updateNote);
				}else{
					$updateNote = "Reference ". $reference->title . " was successfully inserted into the bibliography for " . $source->title . ".";
					echo $updateNote . "<br />";
					Article::createCitation($source);
					Update::updateRecord($source->srcID, "Bibliography", TRUE, $updateNote);
				}
			}catch(PDOException $e){
				$updateNote = "Failed: Reference ". $reference->title . " was not inserted into the bibliography for " . $source->title . ".";
				$updateNote .= $e->getMesage();
				echo $updateNote . "<br />";
				Update::updateRecord($source->srcID, "Bibliography", FALSE, $updateNote);
			}
		}else
		{
			$updateNote = "Failed: Reference ". $reference->title . " was not inserted into the bibliography for " . $source->title . " because it already exists.";
			echo $updateNote . "<br />";
			Update::updateRecord($source->srcID, "Bibliography", FALSE, $updateNote);
		}
	}


	static public function display($srcID, $srcType)
	{
		$references = Bibliography::findAll($srcID, $srcType);
		$output = "<h3>Bibliography</h3>
				   <table class='table'>
				   <tr>  
				   		<th>Source ID</th>
					    <th>Citation</th>
					</tr>";
		foreach($references as $r)
		{	
			$citation = SourceCreator::createCitation($r->refType, $r->refID);
			$output .= "<tr>
							<td>". $r->refType . " - " . $r->refID . "<td>
							<td>" . $citation . "</td>
						</tr>";
		}
		$output .= "</table>";
		echo $output;
	}

  }

?>