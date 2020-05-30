<?php
    class Skeleton{
        public $individualId;
        public $siteName;
        public $siteId;
        public $labId; 
        public $sampleId;
        public $age;
        public $ageCategory;
        public $sex;
        public $collectionId;
        public $collection;
        public $sources = [];
        static protected $database;

        static public function set_database($database) {
            self::$database = $database;
        }

        //constructor
        public function __construct($args=[]) {
            $this->individualId = $args['individualId'] ?? '';
            $this->siteId = $args['siteId'] ?? '';
            $this->labId = $args['labId'] ?? '';
            $this->sampleId = $args['sampleId'] ?? '';
            $this->age = $args['age'] ?? '';
            $this->ageCategory = $args['ageCategory'] ?? '';
            $this->sex = $args['sex'] ?? '';
            $this->collectionId = $args['collectionId'] ?? '';
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
        //get all individuals
        public static function find_all_skeletons_by_limit($start, $limit)
        {
            $query =  "SELECT * ";
            $query .= " FROM individuals";
            $query .= " ORDER BY individualId ASC";
            $query .= " Limit " . $start .", " . $limit;
            $obj_array = self::findBySql($query);
            if(!empty($obj_array)) {
                return $obj_array;
            } else {
                return false;
            }
        }
        //find by skeletonId
        static public function findById($id) {
            $query = "SELECT * ";
            $query .= " FROM individuals ";
            $query .= " WHERE individualId= '" . $id. "'";
            return self::findBySql($query);
        }
        //find by sampleId
        static public function findBySampleId($id) {
            $query = "SELECT * ";
            $query .= " FROM individuals ";
            $query .= " WHERE sampleId= '" . $id. "'";
            return self::findBySql($query);
        }
      
        //find by labId
        static public function findByLabId($id) {
            $query = "SELECT * ";
            $query .= " FROM individuals ";
            $query .= " WHERE labId= '" . $id. "'";
            return self::findBySql($query);
        }
        
        //find by siteId
        static public function findBySiteId($siteID) {
            $query = "SELECT * ";
            $query .= " FROM individuals ";
            $query .= " WHERE siteId= '" . $id. "'";
            return self::findBySql($query);
        }
        
        //find by siteName
        static public function findBySiteName($siteName) {
            $query = "SELECT * ";
            $query .= " FROM individuals";
            $query .= " INNER JOIN jomon_sites";
            $query .= " ON jomon_sites.id = individuals.siteId";
            $query .= " WHERE siteName= '" . $siteName. "'";
            return self::findBySql($query);
        }
        //display individual
        public function display()
        {
            $record =  "<h3>Sample ID: " . $this->sampleId . "</h3>";
            $record .= "<h3>Lab ID: " . $this->labId . "</h3>";
            //biological profile
            $record .= "<h3>Biological Profile</h3>
            <table>
                <tr>
                    <th>Age</th>
                    <th>Age Category</th>
                    <th>Sex</th>
                </tr>
                <tr>";
                !empty($this->age) ?  $record .= "<td>" .$this->age . "</td>" : $record .= "<td></td>";
                !empty($this->ageCategory) ?  $record .= "<td>" .$this->ageCategory . "</td>" : $record .= "<td></td>";
                !empty($this->sex) ?  $record .= "<td>" .$this->sex . "</td>" : $record .= "<td></td>";
            $record .= "</table>";
            if(!empty($this->siteName))
            {
                $record .= "<h3> Site</h3>
                    <table>
                        <tr>
                            <td>
                                <input type='checkbox' class='siteRecord' value='" . $this->siteName . "' />
                            </td>
                            <td>"
                                . $this->siteName .
                            "</td>
                        </tr>
                    </table>";
                    //View Paleohealth
                    //View Measurements
                    //View Stable Isotopes
                    //Radiocarbon Dates
            } 
            if(!empty($this->collection))
            {
                $record .= "<h3> Site</h3>
                    <table>
                        <tr>
                            <td>
                                <input type='checkbox' class='collectionRecord' value='" . $this->collectionId . "' />
                            </td>
                            <td>"
                                . $this->collection .
                            "</td>
                        </tr>
                    </table>";
            }
            echo $record;
        }
        //display record label
        public function displayRecord()
        {
            echo "<tr>
                    <td>
                        <input type='checkbox' class='skeletonRecord' value='" .h($this->individualId) . "' />
                    </td>
                    <td>"
                        . h($this->labId) .
                    "</td>
                    <td>"
                    . h($this->sampleId) .
                    "</td>
                    <td>"
                        . h($this->site) . 
                    "</td>
            </tr>";
        }
    }
?>