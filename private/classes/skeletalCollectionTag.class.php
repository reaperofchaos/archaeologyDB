<?php
    class SkeletalCollectionTag extends Tag{
        public $collection;
        
        //constructor
        public function __construct($args=[]) {
            $this->collection = $args['collection'] ?? ''; 
            $this->srcId = $args['srcId'] ?? '';
            $this->srcType = $args['srcType'] ?? '';
        }

        //functions
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
                echo $e->getMessage() . "<br />"; 
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

        static public function findTags($srcType, $srcId) {
            $query = "SELECT * ";
            $query .= "FROM skeletal_collection_tags ";
            $query .= "WHERE srcType= '" . $srcType. "' ";  
            $query .= "AND srcId= '" . $srcId. "'";  
            return self::findBySql($query);
        }

    }
?>