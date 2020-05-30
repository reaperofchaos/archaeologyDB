<?php
    class AreaTag extends Tag{
        public $region;
        public $islandChain;
        public $island;
        public $country;
        public $sub_region;
        public $prefecture;
        public $sub_prefecture;
        public $city;

        //constructor
        public function __construct($args=[]) {
            $this->region = $args['region'] ?? ''; 
            $this->islandChain = $args['islandChain'] ?? ''; 
            $this->island = $args['island'] ?? ''; 
            $this->country = $args['country'] ?? ''; 
            $this->sub_region = $args['sub_region'] ?? ''; 
            $this->prefecture = $args['prefecture'] ?? ''; 
            $this->sub_prefecture = $args['sub_prefecture'] ?? ''; 
            $this->city = $args['city'] ?? ''; 
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
            $query .= "FROM area ";
            $query .= "WHERE srcType= '" . $srcType. "' ";  
            $query .= "AND srcId= '" . $srcId. "'";  
            return self::findBySql($query);
        }

        public function display()
        {
            $string = '';
            !empty($this->region) ?  $string .= "Global Region: " . $this->region . "<br /> " : null;
            !empty($this->country) ?  $string .= "Country: " . $this->country . "<br /> " : null;
            !empty($this->islandChain) ?  $string .= "Island Chain: " . $this->islandChain . "<br /> " : null;
            !empty($this->island) ?  $string .= "Island: " . $this->island . "<br /> " : null;
            !empty($this->sub_region) ?  $string .= "Local Region: " . $this->sub_region . "<br /> " : null;
            switch($this->country)
            {
                case "Japan":
                    !empty($this->prefecture) ?  $string .= "Prefecture: " . $this->prefecture . "<br /> " : null;
                break;
                case "United States":
                    !empty($this->prefecture) ?  $string .= "State: " . $this->prefecture . "<br /> " : null;
                break;
                case "Russia":
                    !empty($this->prefecture) ?  $string .= "Oblast: " . $this->prefecture . "<br /> " : null;
                break;
                default:
                    !empty($this->prefecture) ?  $string .= "Province: " . $this->prefecture . "<br /> " : null;
            }
            !empty($this->sub_prefecture) ?  $string .= "Sub Prefecture : " . $this->sub_prefecture . "<br /> " : null;
            !empty($this->city) ?  $string .= "City: " . $this->city . "<br /> " : null;
            return $string; 
        }

    }
?>