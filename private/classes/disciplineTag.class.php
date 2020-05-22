<?php
    class DisciplineTag extends Tag{
        public $discipline;
        public $subDiscipline;
        public $technique;


        //constructor
        public function __construct($args=[]) {
            $this->discipline = $args['discipline'] ?? ''; 
            $this->discipline = $args['subDiscipline'] ?? ''; 
            $this->technique = $args['technique'] ?? ''; 
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
            $query .= "FROM disciplinetags ";
            $query .= "WHERE srcType = '" . $srcType. "' ";  
            $query .= "AND srcId= '" . $srcId. "'";  
            return self::findBySql($query);
        }
        public function display()
        {
            $string = ''; 
            !empty($this->discipline) ?  $string .= "Discipline: " . $this->discipline . "<br /> " : null;
            !empty($this->subDiscipline) ?  $string .= "Sub-Discipline: " . $this->subDiscipline . "<br /> " : null;
            !empty($this->technique) ?  $string .= "Technique: " . $this->technique . "<br /> " : null;
        }
    }
?>