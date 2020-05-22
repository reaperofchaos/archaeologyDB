<?php
    class Source{
        //parameters
        public $id;
        public $srcId;
        public $srcType;
        public $title;
        public $srcLocation;
        public $webmasters;
        static protected $database;

        static public function set_database($database) {
            self::$database = $database;
        }
        
        //constructor
        public function __construct($args=[]) {
            $this->id = $args['id'] ?? '';
            $this->title = $args['title'] ?? '';
            $this->srcLocation = $args['srcLocation'] ?? '';
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
                echo $e . "<br />"; 
            }
            return $object_array;
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
        
        public function displayRecord(){
            echo "<tr>
            <td>
                <input type='checkbox' class='record' value='" .h($this->srcType) . "-". h($this->srcId). "' />
            </td>
            <td>"
                . h($this->id) .
            "</td>
            <td>"
               . h($this->srcType) . " - " . h($this->srcId) .
            "</td>
            <td>"
                . h($this->title) . 
            "</td>
        </tr>";
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

        //SQL queries
        static public function countSources(){
            $query = "SELECT count(*) FROM sources";
            $total = self::findBySqlCount($query);
            return $total;
        }
        
        static public function getAllTitlesAsJSON(){
            $query = "SELECT * FROM sources";
            $statement = self::$database->prepare($query);
            $statement->execute();
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $results[] = [
                                'srcID'   => $row['srcId'],
                                'srcType' => $row['srcType'],
                                'title'   => $row['title']
                ];
            }
            $json = json_encode(utf8ize($results), JSON_PRETTY_PRINT);

            return $json;
        }
        static public function getAllAuthors(){
            $query = "SELECT DISTINCT authorName FROM authors";
            $result = self::$database->prepare($query);
            $result->execute();
            if(!$result) {
                exit("Database query failed.");
            }     
            $result->setFetchMode(PDO::FETCH_ASSOC); 
            // results into objects
            $authors = [];
            while($record = $result->fetch()) {
                array_push($authors, $record['authorName']);
            }      
             return $authors;
        }
        //function to get sources within a range of source IDs (needed for record list in index.php)
        static public function find_all_sources_by_limit($start, $limit){    
            $query =  "SELECT * ";
            $query .= " FROM sources";
            $query .= " ORDER BY id ASC";
            $query .= " Limit " . $start .", " . $limit;
            $obj_array = self::findBySql($query);
            if(!empty($obj_array)) {
                return $obj_array;
            } else {
                return false;
            }
        }
        
        static public function createSourcePreview($source){
            $html = '<br />
            <input type="button" id="btnSourcePreview_'. $source->id . '" value="+"
             onclick=\'toggleShow("SourcePreview_'.$source->id. '")\' />
            Source Preview<br />
            <div id="SourcePreview_'.$source->id . '" style="display: none">
                <p>' . $source->srcLocation . '</p>
                <br />
                <br />
                <iframe src="https://docs.google.com/viewer?url=https://localhost/jomon/'. 
                  $source->srcLocation .'&embedded=true" style="width:600px; height:500px;" 
                  frameborder="0"></iframe>
            </div>';
            return $html;
        } 
        public function getCreators($authorType){
            $authors =[];
            $sql = "SELECT DISTINCT authorName ";
            $sql .= "FROM authors ";
            $sql .= "WHERE srcId = '" . $this->srcId . "'";
            $sql .= " AND srcType= '" . $this->srcType . "'";
            $sql .= " AND authorType= '$authorType'";
            $result = self::$database->prepare($sql);
            $result->execute();
            
            if(!$result) {
                exit("Database query failed.");
            }
            $result->setFetchMode(PDO::FETCH_ASSOC); 
            while($record = $result->fetch()) {
                array_push($authors, $record['authorName']);
            }
            switch($authorType)
            {
                case "author":
                    $this->authors = $authors;
                    break;
                case "presenter":
                    $this->presenters = $authors;
                    break;
                case "editor":
                    $this->editors = $authors;
                    break;
                case "supervisor":
                    $this->supervisors = $authors;
                    break;
                case "creator":
                    $this->creators = $authors;
                    break;
                case "uploader":
                    $this->uploaders = $authors;
                    break;
                case "webmaster":
                    $this->webmasters = $authors;
                    break;
                default:
            }    
        }
        static public function get_creators($authorType, $source)
        {
            $authors =[];
            $sql = "SELECT DISTINCT authorName ";
            $sql .= "FROM authors ";
            $sql .= "WHERE srcId = '" . $source->srcId . "'";
            $sql .= " AND srcType = '" . $source->srcType . "'";
            $sql .= " AND authorType = '". $authorType . "'";
            $result = self::$database->prepare($sql);
            $result->execute();
            if(!$result) {
                exit("Database query failed.");
            }

            $result->setFetchMode(PDO::FETCH_ASSOC); 
            while($record = $result->fetch()) 
            {
                array_push($authors, $record['authorName']);
            }
            return $authors; 
        }
        public function getSrcType()
        {
            return $this->srcType;
        }

        static public function getSourceByQuery($name, $srcType, $authorType)
        {
            $query = "SELECT * ";
            $query .= "FROM sources ";
            $query .= "INNER JOIN authors ";
            $query .= "ON sources.srcId = authors.srcId ";
            $query .= "AND sources.srcType = authors.srcType ";
            $query .= "WHERE authors.authorName ='". $name ."' ";
            $query .= "AND authors.authorType ='". $authorType . "' ";
            $query .= "AND authors.srcType  = '".  $srcType . "' ";
            $query .= "ORDER BY year ASC";
            return $query; 
        }
        
        static public function insert_creator($authorType, $source){
            $type = $authorType . "s";
            //print_r($source->{$type});
            echo $source->srcId;
            $existingCreators = Source::get_creators($authorType, $source);
            echo "<br />";
            print_r($existingCreators);
            echo "<br />";
            if(!is_array($existingCreators))
            {
                $existingCreators = [];
            }  
            foreach($source->{$type} as $creator){
            if(!in_array($creator, $existingCreators)){
              $query = "INSERT INTO authors";
              $query .= "(authorType, authorName, srcType, srcId)";
              $query .= " VALUES(";
              $query .=  "'". $authorType . "', '";
              $query .=  $creator . "', '";
              $query .= $source->srcType . "', '";
              $query .= $source->srcId;
              $query .= "')";
              try
              {
                $result = self::$database->prepare($query);
                $result->execute();
                if($result)
                {
                    $updateNote = $authorType . " " . $creator . " has been added to ". $source->title . " successfully.";
                    echo $updateNote . "<br />";
                    //Update::updateRecord($book->srcID, $book->srcType, "Add Author", TRUE, $updateNote);
                }
              }
              catch(PDOException $e)
              {
                //failed due to error
                $updateNote  = "Failed: " . $authorType . " " . $creator . " for " . $source->title . " was not inserted successfully <br />";
                $updateNote .= $e->getMessage();
                echo $updateNote;
                //Update::updateRecord($src->srcId, $src->srcType, "Creation", FALSE, $updateNote);
              }
            }
            else
            {
              $updateNote  = "Failed: " . $authorType . " ". $creator . " for " . $source->title . " was not inserted as it already exists. <br />";
              echo $updateNote;
              //Update::updateRecord($src->srcId, $src->srcType, "Creation", FALSE, $updateNote);
            }
          }
        }

        static public function insert($src, $query){
            $sourceTypeName = SourceCreator::getSourceType($src->srcType);
            if(!$src->checkIfExists())
            {
                echo "source does not exist <br />";
              try
              {
                  $result = self::$database->prepare($query);
                  $result->execute();
                  if(!$result)
                  {
                      //failed due to unknown DB error
                      exit("Database query failed.");
                      $updateNote = "Failed: ". $sourceTypeName . " ". $src->title . " was not inserted successfully.";
                      echo $updateNote . "<br />";
                  }
                  else
                  {
                      //Successfully inserted
                      $updateNote = $sourceTypeName . " " . $src->title . " was created successfully.";
                      echo $updateNote . "<br />";
  
                      $src->createCitation();
                      //Update::updateRecord($src->srcId, $src->srcType,"Creation", TRUE, $updateNote);    
                  }
              }
              catch(PDOException $e)
              {
                //failed due to error
                $updateNote  = $sourceTypeName . " ". $src->title . " was not inserted successfully <br />";
                $updateNote .= $e->getMessage();
                echo $updateNote;
                //Update::updateRecord($src->srcId, $src->srcType, "Creation", FALSE, $updateNote);
              }
          }
          else
          {
            //Try updating
              $updateNote  = $sourceTypeName . " ". $src->title . " was not inserted successfully because it already exists. Attempting to update<br />";
              $current = SourceCreator::findSource($src->srcType, $src->srcId);
              //fix update function
              /*if($current != FALSE){
                if(!SourceCreator::updateSource($current, $src))
                {
                    $updateNote  = $sourceTypeName . " ". $src->title . " was not inserted successfully because it already exists and could not be updated. <br />";
                    echo $updateNote;
                    //Update::updateRecord($src->srcID, $src->srcType, "Creation", FALSE, $updateNote);
                };
              }
              */
          }
        }

        static public function checkIfDirectoryExists($target_dir){
            if(!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
        }

        static public function createFolder($folderName, &$target_dir)
        {
            if(!empty($folderName)){
                $target_dir .= $folderName;
                //make folder if it does not exist
                Source::checkIfDirectoryExists($target_dir);
                $target_dir .= '/';
            }else{
                $target_dir .= "unknown";
                Source::checkIfDirectoryExists($target_dir);
                $target_dir .= '/';
            }   
        }

    static public function uploadSource($source, $file){
            //create directory to store files if the directory does not exist
            $target_dir = "../../source/";
            Source::checkIfDirectoryExists('../../source');
            switch($source->srcType){
                case "a":
                    Source::checkIfDirectoryExists('../../source/article');
                    $target_dir .= "article/";
                    Source::createFolder($source->journal, $target_dir);
                    Source::createFolder($source->year, $target_dir);
                    Source::createFolder($source->volume, $target_dir);
                    Source::createFolder($source->issue, $target_dir);
                    break;
                case "ab":
                    Source::checkIfDirectoryExists('../../source/abstract');
                    $target_dir .= "abstract/";

                    break;
                case "b":
                    Source::checkIfDirectoryExists('../../source/book');
                    $target_dir .= "book/";
                    Source::createFolder($source->year, $target_dir);
                    Source::createFolder($source->publisher, $target_dir);
                    break;
                case "d":
                    Source::checkIfDirectoryExists('../../source/dissertation');
                    $target_dir .= "dissertation/";
                    Source::createFolder($source->location, $target_dir);
                    Source::createFolder($source->year, $target_dir);
                    break;
                case "po":
                    Source::checkIfDirectoryExists('../../source/poster');
                    $target_dir .= "poster/";
                    Source::createFolder($source->conference, $target_dir);
                    Source::createFolder($source->year, $target_dir);
                    break;
                case "pr":
                    Source::checkIfDirectoryExists('../../source/presentation');
                    $target_dir .= "presentation/";
                    Source::createFolder($source->conference, $target_dir);
                    Source::createFolder($source->year, $target_dir);
                    break;
                case "r":
                    Source::checkIfDirectoryExists('../../source/radio');
                    $target_dir .= "radio/";
                    Source::createFolder($source->conference, $target_dir);
                    Source::createFolder($source->year, $target_dir);
                    break;
                case "t":
                    Source::checkIfDirectoryExists('../../source/thesis');
                    $target_dir .= "thesis/";
                    Source::createFolder($source->location, $target_dir);
                    Source::createFolder($source->year, $target_dir);
                    break;
                case "w":   
                    Source::checkIfDirectoryExists('../../source/website');
                    $target_dir .= "website/";
                    $website = camelCase($source->website);
                    htmlspecialchars($website);
                    Source::createFolder($website, $target_dir);
                    Source::createFolder($source->year, $target_dir);
                    break;
                case "v":
                    Source::checkIfDirectoryExists('../../source/videos');
                    $target_dir .= "video/";
                    $website = camelCase($source->publisher);
                    htmlspecialchars($website);
                    Source::createFolder($website, $target_dir);
                    Source::createFolder($source->year, $target_dir);
                    break;
                default:
                    return;
            }
                            

            
            if($file['name'] != ""){
                // No file was selected for upload, your (re)action goes here
                //get the file extension from the uploaded File name
                $tmp = explode(".", $file["name"]);
                $fileExtension = end($tmp); 
                //Set source location in Article Object
                $newFileName = $source->title; 
                $target_file = $target_dir . $newFileName . "." . $fileExtension;
                $source->srcLocation = $target_file;
                $uploadOk = 1; 
                $fileType = strtolower($fileExtension);
                // Check if valid filetype
                if ($fileType != 'pdf') {
                    echo "All uploaded articles must be .pdf files. File cannot be uploaded";
                    $uploadOk = 3;
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 2;
                }
                //Upload the file
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk != 1){
                    echo "Sorry, your file was not uploaded.<br />";
                    switch($uploadOk){
                    case 2: 
                        echo "Form Handling Error 2: 
                            <br />File already exists.";
                        break;
                    case 3: 
                        echo "Form Handling Error 3:<br />
                        Invalid File Type: All uploaded articles must be .pdf files. File cannot be uploaded";
                        break; 
                    case 1:
                        break; 
                    default:
                        echo "Form Handling Error: <br />
                            An unknown error occurred"; 
                    }
                // if everything is ok, try to upload file
                } else {
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    echo "The file ". $newFileName. $fileExtension .
                        " has been uploaded.<br />
                        <table class = 'table'>
                        <tr>
                        <td>File Name: </td> 
                        <td>".$target_file . "</td>
                        </tr>
                        <tr>
                        <td>File Type: </td>
                        <td>".$file["type"] . "</td>
                        </tr>
                        <tr>
                        <td>File Size: </td>
                        <td>".$file["size"] . "</td>
                        </tr>
                        </table>";
                } else {
                    echo "There was an server error uploading your file. <br/>
                        PHP Error: " .$file["error"];
                }
                }
            }else{
                echo "Error: No file was attached to be uploaded.";
            }
        }
    }
?>