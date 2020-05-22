<?php
class Chapter{
    //parameters
    public $id;
    public $subSrcType;
    public $subSrcId;
    public $title;
    public $chNo;
    public $startPage;
    public $endPage;
    public $srcType;
    public $srcId;
    public $srcLocation;
    static protected $database;

    static public function set_database($database) {
        self::$database = $database;
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
        //print_r(var_dump($object_array));
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
  
    //constructor
  public function __construct($args=[]) {
    $this->id = $args['id'] ?? '';
    $this->subSrcId = $args['subSrcId'] ?? '';;
    $this->subSrcType = 'c';
    $this->title = $args['title'] ?? '';
    $this->chNo = $args['chNo'] ?? '';
    $this->startPage = $args['startPage'] ?? '';
    $this->endPage = $args['endPage'] ?? '';
    $this->srcType = $args['srcType'] ?? '';
    $this->srcId = $args['srcId'] ?? '';
    $this->srcLocation = $args['srcLocation'] ?? '';
  }
  static public function find_by_id($srcType, $srcId) {
    $query = "SELECT *";
    $query .= " FROM subsource";
    $query .= " WHERE srcId='" . $srcId . "'";
    $query .= " AND srcType='" . $srcType . "'";
    $query .= " AND subSrcType='c'";
    $obj_array = self::find_by_sql($query);
    if(!empty($obj_array)) {
      return $obj_array;
    } else {
      return false;
    }
  }
  static public function get_authors($source, $srcType, $srcId){
	$authors =[];
	$sql = "SELECT * ";
	$sql .= "FROM authors ";
	$sql .= "WHERE source_id = '" . $srcId . "'";
    $sql .= " AND source_type= 'C'";
    $sql .= " AND author_type = 'author'";

	 $result = self::$database->prepare($sql);
      $result->execute();
      
      if(!$result) {
        exit("Database query failed.");
      }
      $result->setFetchMode(PDO::FETCH_ASSOC); 
      while($record = $result->fetch()) {
		array_push($authors, $record['author_name']);
	}
	$source->authors = $authors;
  }
  static function hello(){
    echo "hello";
  }
}
?>
