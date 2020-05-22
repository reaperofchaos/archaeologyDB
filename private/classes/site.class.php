<?php
    class Site{
        public $siteId;
        public $siteName; 
        public $island;
        public $prefecture;
        public $subPrefecture;
        public $ryukyu_island;
        public $kuril_island;
        public $latitude;
        public $longitude;
        public $timePeriods = [];
        public $cultures = [];
        public $occupations = [];
        static protected $database;

        public function __construct($args=[]) {
            $this->siteName = $args['siteName'] ?? ''; 
            $this->island = $args['island'] ?? ''; 
            $this->prefecture = $args['prefecture'] ?? ''; 
            $this->subPrefecture = $args['subPrefecture'] ?? '';
            $this->ryukyu_island = $args['ryukyu_island'] ?? ''; 
            $this->kuril_island = $args['kuril_island'] ?? ''; 
            $this->latitude = $args['latitude'] ?? ''; 
            $this->longitude = $args['longitude'] ?? ''; 
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

        static public function getAllSites(){
            $sites = [];
            $query  = "SELECT site_name ";
            $query .= "FROM jomon_sites ";
            $query .= "ORDER BY site_name ASC";
            try{
                $result = self::$database->prepare($query);
                $result->execute();
                $result->setFetchMode(PDO::FETCH_ASSOC); 
                while($record = $result->fetch()) {
                    array_push($sites, $record['site_name']);
                }
            }
            catch(PDOException $e)
            {
                echo "Unable to get sites from jomon_sites table <br />";
                echo $e->getMessage() . "<br />";
            }
            return $sites;
        }

        static public function findBySiteName($name) {
            $query = "SELECT * ";
            $query .= " FROM jomon_sites ";
            $query .= " WHERE siteName= '" . $name. "'";  
            return self::findBySql($query);
        }

        static public function findBySiteId($id) {
            $query = "SELECT * ";
            $query .= " FROM jomon_sites ";
            $query .= " WHERE siteId= '" . $id. "'";  
            return self::findBySql($query);
        }

        static public function findSitesBySrc($srcType, $srcId) {
            $query = "SELECT * ";
            $query .= "FROM jomon_sites ";
            $query .= "INNER JOIN sites_tags ";
            $query .= "ON sites_tags.siteId = jomon_sites.siteId ";
            $query .= "WHERE sites_tags.srcType= '" . $srcType. "' ";  
            $query .= "AND sites_tags.srcId= '" . $srcId. "'";  
            return self::findBySql($query);
        }

        static public function findSourcesAboutSite($id) {
            $obj_array = [];
            $query = "SELECT * ";
            $query .= " FROM jomon_sites ";
            $query .= " INNER JOIN sites_tags ";
            $query .= " ON jomon_sites.siteId = sites_tags.siteId";
            $query .= " INNER JOIN sources ";
            $query .= " ON sites_tags.srcType = sources.srcType";
            $query .= " AND sites_tags.srcId = sources.srcId";
            $query .= " WHERE sites_tags.siteId = '" . $id. "'"; 
            try{
                $result = self::$database->prepare($query);
                $result->execute();
                $result->setFetchMode(PDO::FETCH_ASSOC); 
                while($record = $result->fetch()) {
                    array_push($obj_array, $record);
                }
            }
            catch(PDOException $e)
            {
                echo "Error: Unable to get sources for site. <br />";
                echo $e->getMessage() . "<br />";
            }
            return $obj_array;
        }

        static public function findBySqlCount($sql) {
            $result = self::$database->prepare($sql);
            try{
                $result->execute();
                if(!$result) {
                    exit("Database query failed.");
                }
                // results into value
                $count = $result->fetchColumn();
                return $count;
            }
            catch(PDOException $e)
            {
                echo "Unable to retrieve total number of Jomon sites <br />";
                echo $e->getMessage() . "<br />";
            }
            
        }
        static public function countSites(){
            $query = "SELECT count(DISTINCT siteName) FROM jomon_sites";
            $total = self::findBySqlCount($query);
            return $total;
        }

        public function getTimePeriods()
        {
            $timePeriods = [];
            $cultures = [];
            $query = "SELECT timePeriod, culture ";
            $query .= "FROM time_period_sites ";
            $query .= "INNER JOIN  jomon_sites ";
            $query .= "ON time_period_sites.siteId = jomon_sites.siteId ";
            $query .= "WHERE jomon_sites.siteName = '". $this->siteName . "'";
            try{
                $result = self::$database->prepare($query);
                $result->execute();
                $result->setFetchMode(PDO::FETCH_ASSOC); 
                while($record = $result->fetch()) {
                    array_push($timePeriods, $record['timePeriod']);
                    if(!in_array($record['culture'], $cultures))
                    {
                        array_push($cultures, $record['culture']);
                    }
                }
            }
            catch(PDOException $e)
            {
                echo "Error: Unable to get time periods for site. <br />";
                echo $e->getMessage() . "<br />";
            }
            $this->timePeriods = $timePeriods;
            $this->cultures = $cultures; 
        }
        static public function find_all_sites_by_limit($start, $limit)
        {
            $sql = "SELECT DISTINCT siteName ";
            $sql .= "FROM jomon_sites ";
            $sql .= "ORDER BY siteName ASC";
            $sql .= " Limit " . $start .", " . $limit;
            $obj_array = self::findBySql($sql);
            if(!empty($obj_array))
            {
                return $obj_array;
            } else {
                return false;
            }
        }
        public function displaySiteRecord()
        {
            echo "<tr>
                <td>
                    <input type='checkbox' class='siteRecord' value='" . $this->siteName . "' />
                </td>
                <td>"
                    . $this->siteName .
                "</td>
            </tr>";
        }

        static public function siteRecord($site)
        {
            echo "<h3>" . $site->siteName . "<h3>";
            if(is_array($site->timePeriods))
            {
                echo "Time Periods: <br />";
                echo "<table class = 'table' width = '70%'>";
                foreach($site->timePeriods as $timePeriod)
                {
                    echo "<tr>
                            <td>" . $timePeriod . "</td>
                          </tr>";
                }
                echo "</table>";
            }
            if(is_array($site->timePeriods))
            {
                echo "Cultures: <br />";
                echo "<table class = 'table' width = '70%'>";
                foreach($site->cultures as $culture)
                {
                    echo "<tr>
                            <td>" . $culture . "</td>
                          </tr>";
                }
                echo "</table>";
            }
            $location = "Location: <br />"; 
            !empty($site->island) ?  $location .= "Island: " . $site->island . " <br />" : null;
            !empty($site->prefecture) ?  $location .= "Prefecture: " . $site->prefecture . " <br />" : null;
            !empty($site->subPrefecture) ?  $location .= "SubPrefecture: " . $site->subPrefecture . " <br />" : null;
            !empty($site->ryukyu_island) ?  $location .= "Ryukyu Island: " . $site->ryukyu_island . " <br />" : null;
            !empty($site->kuril_island) ?  $location .= "Kuril Island: " . $site->kuril_island . " <br />" : null;
            !empty($site->latitude) ?  $location .= "GPS: " . $site->latitude . ", " . $site->longitude . " <br />" : null;
            echo $location;
        }
    }
?>
