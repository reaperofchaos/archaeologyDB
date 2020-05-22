<?php
    class update {
        private $srcId;
        private $srcType;
        private $updateDate;
        private $updateSuccess;
        private $updateType;
        private $updateNote;
        static protected $database;

        public function __construct($args=[]) {
            $this->srcId         = $args['srcId'] ?? '';
            $this->srcType       = $args['srcType'] ?? '';
            $this->updateDate    = $args['updateDate'] ?? '';
            $this->updateSuccess = $args['updateSuccess'] ?? '';
            $this->updateType    = $args['updateType'] ?? '';
            $this->updateNote    = $args['updateNote'] ?? '';
        }

        static public function set_database($database) {
            self::$database = $database;
        }

        //functions
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

        static public function updateRecord($srcId, $srcType, $updateType, $success, $updateNote)
        {
            $query = "INSERT INTO `updates`";
            $query = "(srcId, srcType, updateDate, updateType, updateSuccess, updateNote)";
            $query .= " VALUES('";
            $query .= $srcId . "', '";
            $query .= $srcType . "', '";
            $query .= "now(), '";
            $query .= $updateType . "', '";
            $query .= $success . "', '";
            $query .= $updateNote . "')";
            $result = self::$database->prepare($query);
            $result->execute();	
            if(!$result) {  
                exit("Database query failed.");
            }
            echo "An update record has been added to " .$srcType . " - " . $srcId . ".";
        }

        static public function getUpdateHistory($srcId, $srcType){
            
            $query   = "SELECT * FROM updates ";
            $query  .= "WHERE srcId = '" . $srcId . "'";
            $query  .= "AND srcType = '" . $srcType . "'";
            $query  .= "ORDER BY 'updateDate' DESC";
            $updates = self::findBySql($query);
            if(!empty($updates)) {
                return $updates;
            } else {
                return false;
            }
        }

        static public function display($srcId, $srcType)
        {
            $updates = Update::getUpdateHistory($srcId, $srcType);
            echo "<h3>Record Change Log</h3>
                 <table class='table'>
                    <tr>
                        <th>Date</th>
                        <th>Update Type</th>
                        <th>Description</th>
                    </tr>";
            if($updates)
            {
                foreach ($updates as $u)
                {
                    if(!$u->updateSuccess)
                    {
                        echo "<tr style={background-color:red}";
                    }
                    else
                    {
                        echo "<tr>";
                    }
                    echo "
                            <td>". $u->updateDate . "</td>
                            <td>". $u->updateType . "</td>
                            <td>". $u->updateDescription . "</td>
                        </tr>";
                }
            }
        }
    }
?>