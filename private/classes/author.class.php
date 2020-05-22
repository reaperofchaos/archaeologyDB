<?php
    class Author {
        public $authorName;
        public $articles;
        public $abstracts; 
        public $books;
        public $edBooks;
        public $chapters;
        public $posters;
        public $presentations;
        public $radio;
        public $theses;
        public $svTheses;
        public $dissertations;
        public $svDissertations;
        public $website;
        public $videos;
        static protected $database;

        static public function set_database($database) {
            self::$database = $database;
        }

        public function __construct($args=[])
        {
            $this->authorName = $args['authorName'] ?? '';
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

        

        static public function find_all_authors_by_limit($start, $limit)
        {
            $sql = "SELECT DISTINCT authorName ";
            $sql .= "FROM authors ";
            $sql .= "ORDER BY authorName ASC";
            $sql .= " Limit " . $start .", " . $limit;
            $obj_array = self::findBySql($sql);
            if(!empty($obj_array))
            {
                return $obj_array;
            } else {
                return false;
            } 
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
            
        static public function countAuthors(){
            $query = "SELECT count(DISTINCT authorName) FROM authors";
            $total = self::findBySqlCount($query);
            return $total;
        }
        
        public function displayAuthorRecord()
        {
            echo "<tr>
            <td>
                <input type='checkbox' class='authorRecord' value='" . $this->authorName . "'></input>
            </td>
            <td>"
                . $this->authorName .
            "</td>
        </tr>";
        }
    }
?> 