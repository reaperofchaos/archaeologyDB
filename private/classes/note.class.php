<?php

    class Note{
        public $high_theory;
        public $hypothesis;
        public $materials;
        public $methods;
        public $statistics;
        public $results;
        public $discussion;
        public $conclusion;
        public $misc_notes;
        static protected $database;

        public function __construct($args=[]) {
            $this->high_theory = $args['high_theory'] ?? ''; 
            $this->hypothesis = $args['hypothesis'] ?? ''; 
            $this->materials = $args['materials'] ?? ''; 
            $this->methods = $args['methods'] ?? '';
            $this->results = $args['results'] ?? ''; 
            $this->discussion = $args['discussion'] ?? ''; 
            $this->conclusion = $args['conclusion'] ?? ''; 
            $this->misc_notes = $args['misc_notes'] ?? ''; 
        }

        static public function set_database($database) {
            self::$database = $database;
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

        static public function findNotesBySrc($srcType, $srcId) {
            $query = "SELECT * ";
            $query .= "FROM source_notes ";
            $query .= "INNER JOIN sources ";
            $query .= "ON sources.srcId = source_notes.srcId ";
            $query .= "AND sources.srcType = source_notes.srcType ";
            $query .= "WHERE source_notes.srcType= '" . $srcType. "' ";  
            $query .= "AND source_notes.srcId= '" . $srcId. "'";  
            return self::findBySql($query);
        }

        public function displayNotes()
        {
            $html = "<h3>Source Notes</h3>";
            $html .= "<h2>High Theory</h3>";
            $html .= "<p>" . $this->high_theory . "</p>";
            $html .= "<h2>Hypothesis</h3>";
            $html .= "<p>" . $this->hypothesis . "</p>";
            $html .= "<h2>Materials</h3>";
            $html .= "<p>" . $this->materials . "</p>";
            $html .= "<h2>Methods</h3>";
            $html .= "<p>" . $this->methods . "</p>";
            $html .= "<h2>Statistics</h3>";
            $html .= "<p>" . $this->statistics . "</p>";
            $html .= "<h2>Results</h3>";
            $html .= "<p>" . $this->results . "</p>";
            $html .= "<h2>Discussion</h3>";
            $html .= "<p>" . $this->discussion . "</p>";
            $html .= "<h2>Conclusion</h3>";
            $html .= "<p>" . $this->conclusion . "</p>";
            $html .= "<h2>Miscellaneous Notes</h3>";
            $html .= "<p>" . $this->misc_notes . "</p>";
            echo $html; 
        }
    }


?>