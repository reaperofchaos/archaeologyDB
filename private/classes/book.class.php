<?php 
    class Book extends Source {
        public $year; 
        public $publisher;
        public $location; 
        public $srcType;
        public $authors;
        public $editors;

        public function __construct($args=[]) {
            parent::__construct($args);
            $this->year = $args['year'] ?? '';
            $this->publisher = $args['publisher'] ?? '';
            $this->location = $args['location'] ?? '';
            $this->srcType = 'b';
            $this->srcId = $this->getSrcId();
            $this->authors = $args['authors'] ?? [];
            $this->editors = $args['editors'] ?? [];
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
        //SQL query
        static public function findById($srcType, $srcId) {
            $query = "SELECT * ";
            $query .= " FROM sources";
            $query .= " INNER JOIN authors";
            $query .= " ON authors.srcId = sources.srcId";
            $query .= " WHERE authors.srcId='" . $srcId . "'";
            $query .= " AND authors.srcType='" . $srcType . "'";
            $query .= " LIMIT 1";
            $obj_array = self::findBySql($query);
            if(!empty($obj_array)) {
                return array_shift($obj_array);
            } else {
                return false;
            }
    }
    static public function getEditors($source){
      $source->editors = Source::get_creators("editor", $source);
    }
    static public function getAuthors($source){
        $source->authors = Source::get_creators("author", $source);
    }
    
    static public function getSourceBy($name, $authorType){
      $query = Source::getSourceByQuery($name, "b", $authorType);
      $obj_array = self::findBySql($query);
      if(!empty($obj_array)) {
        return $obj_array;
      } else {
        return false;
      }
    }

    
    //member function for building a citation
    public function createCitation(){  
      $citation = "";
      
      !empty($this->editorList) ? $citation .= $this->editorList . "." : null; 
      if(!empty($this->editors)){
    $editors =$this->editors;
    $i = 1;
    $length = count($editors);
    foreach($editors as $a){
      if($i == $length){
        $citation .= $a . " Editors. ";
      }else{
        $citation .= $a . ", ";
        }
          $i++;
    }
  }
      if(!empty($this->authors)){
    $authors =$this->authors;
    $i = 1;
    $length = count($authors);
    foreach($authors as $a){
      if($i == $length){
        $citation .= $a . ". ";
      }else{
        $citation .= $a . ", ";
        }
          $i++;
    }
  }
      !empty($this->year) ?  $citation .= $this->year . ". " : null;
      !empty($this->title) ?$citation .= $this->title . ". " : null;
      !empty($this->publisher) ? $citation .= $this->publisher : null;
      !empty($this->location) ? $citation .= "(" . $this->location . ")" : null;
      return $citation;
  }

  //Static function for building a citation
    static public function create_citation($book){  
        $citation = "";
        
        !empty($book->editorList) ? $citation .= $book->editorList . "." : null; 
        if(!empty($book->editors)){
      $editors =$book->editors;
      $i = 1;
      $length = count($editors);
      foreach($editors as $a){
        if($i == $length){
          $citation .= $a . " Editors. ";
        }else{
          $citation .= $a . ", ";
          }
            $i++;
      }
    }
        if(!empty($book->authors)){
      $authors =$book->authors;
      $i = 1;
      $length = count($authors);
      foreach($authors as $a){
        if($i == $length){
          $citation .= $a . ". ";
        }else{
          $citation .= $a . ", ";
          }
            $i++;
      }
    }
        !empty($book->year) ?  $citation .= $book->year . ". " : null;
        !empty($book->title) ?$citation .= $book->title . ". " : null;
        !empty($book->publisher) ? $citation .= $book->publisher : null;
        !empty($book->location) ? $citation .= "(" . $book->location . ")" : null;
        return $citation;
    }

    static public function uploadSource($source, $file){
        //create directory to store files if the directory does not exist
        $target_dir = "../../source/book/";
            Article::checkIfDirectoryExists('../../source');
            Article::checkIfDirectoryExists('../../source/book');
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
            echo "All uploaded book must be .pdf files. File cannot be uploaded";
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

    static public function createChapterCitation($book){  
        $citation = "<h3>Chapters</h3>
                    <br />
                    <table class='table'>
                    <tr>
                    <th>Chapter ID</th>
                    <th>Chapter No</th>
                    <th>Citation</th>
                    <th>Source </th>
                    </tr>";
        if(!empty($book->editors)){
            $editors =$book->editors;
        }else{
            $editors = [];
        }
        $chapters =  Chapter::find_by_id($book->srcType, $book->srcId);
        if(!empty($chapters)){
        foreach ($chapters as $c){
            Chapter::get_authors($c, $c->subSrcType, $c->subSrcId);
            $citation .= "<tr>
                        <td>";
            !empty($c->subSrcId) ? $citation .= "c -" . $c->subSrcId : null; 
            $citation .= "</td>
                          <td>";
            !empty($c->chNo) ?  $citation .= $c->chNo : null;
            $citation .= "</td>
                          <td>";
            if(!empty($c->authors)){
                $authors = $c->authors;
            }else{
                $authors = [];
            }
          $i = 1;
            $length = count($authors);
            foreach($authors as $a){
                if($i == $length){
                    if($i > 1){
                        $citation .= " and " . $a . ". ";
                    }else{
                        $citation .= $a . ". ";
                    }
                }else{
                    $citation .= $a . ", ";
                    }
                        $i++;
            }

            !empty($book->year) ?  $citation .= $book->year . ". " : null;
            !empty($c->title) ?  $citation .= "\"" . $c->title . "\". " : null;
        
            $citation .= "In: ";
            $i = 1;
            $length = count($editors);
                foreach($editors as $e){
                    if($i == $length){
                        if($i > 1){
                            $citation .= $e . ", editors. ";
                        }else{
                            $citation .= $e . ", editor. ";
                        }
                    }else{
                        $citation .= $e . ", ";
                    }
                    $i++;   
                }
                
                !empty($book->title) ?$citation .= "<em>" . $book->title . "</em>. " : null;
                !empty($book->location) ? $citation .= $book->location . ": " : null;
                !empty($book->publisher) ? $citation .= $book->publisher . ". " : null;
                !empty($c->startPage) ? $citation .= "p " . $c->startPage : null;
                !empty($c->endPage) ? $citation .= "-" . $c->endPage . "." : null;
                $citation .= "</td>
                <td>";
                !empty($c->srcLocation) ? $citation .= "<a href='". $c->srcLocation . "'>English </a>" : $citation .= "No file attached";
                $citation .= "</td>
                </tr>";
        }
            $citation .="</table>";
            }else{
                $citation = ''; 
            }
            return $citation;    
        }
            
      static public function insertAuthors($source){
        Source::insert_creator("author", $source);			
      }
            
      static public function insertEditors($source){
        Source::insert_creator("editor", $source);			
      }
        
      //member method to check if source is in DB
      public function checkIfExists(){
        $query = "SELECT * ";
        $query .= " FROM sources ";
        $query .= " WHERE title= '" . $this->title . "'";
        $query .= " AND srcId = '" . $this->srcId . "'";
        $query .= " AND srcType = 'b'";  
        $total =  self::findBySqlCount($query);
        if($total > 0){
          return true;
        }
        return false;
      }  
      
      //Static method to check if a source is in DB
      static public function checkIfSrcExists($source)
      {
          $query = "SELECT * ";
          $query .= " FROM sources ";
          $query .= " WHERE title= '" . $source->title. "'";
          $query .= " AND year = '" . $source->year. "'";
          $query .= " AND srcType = 'b'";  
          $total =  self::findBySqlCount($query);
          if($total > 0){
            return true;
          }
          return false;
      }

      public function retrieveSrcID()
      {
          $query = "SELECT srcId ";
          $query .= " FROM sources ";
          $query .= " WHERE title= '" . $this->title. "'";
          $query .= " AND year = '" . $this->year. "'";
          $query .= " AND srcType = 'b'";
          $query .= " LIMIT 1";
          $result = self::$database->prepare($query);
          $result->execute();
          if($result)
          {
            $r =$result->fetch();
            return $r['srcId'];
          }
      }
          static public function findExistingAuthors($books){
            $sql = "SELECT * ";
            $sql .= "FROM authors ";
            $sql .= "WHERE source_type ='b' ";
            $sql .= "AND source_id = '". $books->srcId . "' ";
            $sql .= "AND author_type='author'";
      
           $result = self::$database->prepare($sql);
            $result->execute();
            if(!$result) {
              exit("Database query failed.");
            }
            $result->setFetchMode(PDO::FETCH_ASSOC); 
            $existingAuthors = [];
            while($record = $result->fetch()) {
                  $existingAuthors = $record['author_name'];
            }
            return $existingAuthors;
          }

          public function getSrcId(){
            //create if it does note exist;
            if(!Book::checkIfSrcExists($this))
            {
               $sql = "SELECT MAX(srcId) AS id ";
               $sql .= "FROM sources ";
               $sql .= "WHERE srcType ='". $this->srcType . "'";
               $result = self::$database->prepare($sql);
               $result->execute();
              if(!$result) {
                exit("Database query failed.");
              }
              $result->setFetchMode(PDO::FETCH_ASSOC); 
              while($record = $result->fetch()) {
                    $srcId = $record['id'];
              }
              return $srcId + 1;
            }else{
              return $this->retrieveSrcID();
            }  
          }
           

      static public function insertBook($book){
          $query = "INSERT INTO sources";
          $query .= "(srcType, srcId, year, title, publisher, location, srcLocation) ";
          $query .= "VALUES('";
          $query .= $book->srcType . "', '";
          $query .= $book->srcId . "', '";
          $query .= $book->year . "', '";
          $query .= $book->title . "', '";
          $query .= $book->publisher . "', '";
          $query .= $book->location . "', '";
          $query .= $book->srcLocation;
          $query .= "')";
          Source::insert($book, $query);
      }


      //UPDATE
    static public function updateSource($source, $update) {
      
      $attribute_pairs = [];
      foreach($update as $key => $value) {
        $attribute_pairs[] = "{$key}='{$value}'";
      }
      $query = "UPDATE sources SET ";
      $query .= join(', ', $attribute_pairs);      
      $query .= " WHERE srcType = '" . $source->srcType . "'";
      $query .= " AND srcid = '". $source->srcId . "'"; 
    
      $result = self::$database->prepare($query);
      $result->execute();
        
      if(!$result) {
        exit("Database query failed.");
        $updateNote = "Failed: " . $source->title . " did not update successfully.";
        echo $updateNote . "<br />";
        Update::updateRecord($source->srcID, $source->srcType, "Update Book", FALSE, $updateNote);
        return false; 
      }
      $updateNote = "Update success: " . Book::createCitation($source);
      $updateNote .= " has been updated to " . Book::createCitation($update);
      echo $updateNote . "<br />";
      Update::updateRecord($source->srcID, $source->srcType, "Update Book", TRUE, $updateNote);
      return true;
      }
      
      static public function uploadFile($source, $file){
        Source::uploadSource($source, $file);
      }
    }
?>