<?php
    //Class is used to create various subClasses of Source
    class SourceCreator
    {
        //convert source abbreviation to name;
        static public $sourceTypes = [
            "a"  => "Article",
            "ab" => "Abstract",
            "b"  => "Book",
            "d"  => "Dissertation",
            "po" => "Poster",
            "pr" => "Presentation",
            "r"  => "Radio", 
            "t"  => "Thesis",
            "w"  => "Webpage",
            "v"  => "Video",
        ];
        public static function getSourceType($type)
        {
            return SourceCreator::$sourceTypes[$type];
        }

        public static function createSource($type, $args)
        {
            switch($type)
            {
                case "a":
                    return new Article($args);
                    break;
                case "ab":
                    return new Summary($args);
                    break;
                case "b":
                    return new Book($args);
                    break;
                case "d":
                    return new Dissertation($args);
                    break;
                case "po":
                    return new Poster($args);
                    break;
                case "pr":
                    return new Presentation($args);
                    break;
                case "r":
                    return new Radio($args);
                    break;
                case "t":
                    return new Thesis($args);
                    break;
                case "w":
                    return new Website($args);
                    break;
                case "v":
                    return new Video($args);
                    break;
                default:
                    return;
            }
        }
        
        public static function findSource($type, $id)
        {
            switch($type)
            {
                case "a":
                    return Article::findById($type, $id);
                    break;
                case "ab":
                    return Summary::findById($type, $id);
                    break;
                case "b":
                    return Book::findById($type, $id);
                    break;
                case "d":
                    return Dissertation::findById($type, $id);
                    break;
                case "po":
                    return Poster::findById($type, $id);
                    break;
                case "pr":
                    return Presentation::findById($type, $id);
                    break;
                case "r":
                    return  Radio::findById($type, $id);
                    break;
                case "t":
                    return Thesis::findById($type, $id);
                    break;
                case "w":
                    return Website::findById($type, $id);
                    break;
                case "v":
                    return Video::findById($type, $id);
                    break;
                default:
                    return;
            }
        }

        public static function updateSource($current, $new)
        {
            switch($current->getSrcType())
            {
                case "a":
                    return Article::update_article($current, $new);
                    break;
                case "ab":
                    return Summary::update_article($current, $new);
                    break;
                case "b":
                    return Book::updateSource($current, $new);
                    break;
                case "d":
                    return Dissertation::update_article($current, $new);
                    break;
                case "po":
                    return Poster::update_article($current, $new);
                    break;
                case "pr":
                    return Presentation::update_article($current, $new);
                    break;
                case "r":
                    return  Radio::update_article($current, $new);
                    break;
                case "t":
                    return Thesis::update_article($current, $new);
                    break;
                case "w":
                    return Website::update_article($current, $new);
                    break;
                case "v":
                    return Video::update_article($current, $new);
                    break;
                default:
                    return;
            }
        }

        public static function createCitation($srcType, $srcId){
            $chapterCitation = "";
            switch($srcType){
                case 'a':
                    $source = Article::findById($srcType, $srcId); 
                    Article::getAuthorsFromDB($source);
                    $citation = Article::create_citation($source); 
                    break;
                case 'ab':
                    $source = Summary::findById($srcType, $srcId); 
                    Summary::getAuthorsFromDB($source);
                    $citation = Summary::create_citation($source);
                    break;
                case 'b':
                    $source = Book::findById($srcType, $srcId); 
                    Book::getAuthors($source);
                    Book::getEditors($source);
                    $citation = Book::create_citation($source); 
                    //$chapterCitation = Book::createChapterCitation($source);
                    break;
                case 'd':
                    $source = Dissertation::findById($srcType, $srcId); 
                    Dissertation::getAuthors($source);
                    Dissertation::getSupervisors($source);
                    $citation = Dissertation::create_citation($source);
                    break;
                case 'po':
                    $source = Poster::findById($srcType, $srcId); 
                    Poster::getPresenters($source);
                    $citation = Poster::create_citation($source);
                    break;
                case 'pr':
                    $source = Presentation::findById($srcType, $srcId); 
                    Presentation::getPresenters($source);
                    $citation = Presentation::create_citation($source);
                    break;
                case 'r':
                    $source = Radio::findById($srcType, $srcId); 
                    Radio::getPresenters($source);
                    $citation = Radio::create_citation($source);
                    break;
                case 't':
                    $source = Thesis::findById($srcType, $srcId); 
                    Thesis::getAuthors($source);
                    Thesis::getSupervisors($source);
                    $citation = Thesis::create_citation($source);
                    break;
                case 'v':
                    $source = Video::findById($srcType, $srcId); 
                    Video::getCreators($source);
                    Video::getUploaders($source);
                    $citation = Video::create_citation($source);
                    break;
                case 'w':
                    $source = Website::findById($srcType, $srcId);
                    Website::getWebmasters($source);
                    $citation = Website::create_citation($source);
                    break;
                default:
            }
            return $citation;
        }

        public static function createRecord($source, $citation, $srcType, $srcId){
            echo "<table class='table table-bordered'>
                        <thead class='thead-inverse'>
                            <tr>
                                <th>ID</th>
                                <th>Article</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type='hidden' class='src_id' id='". $srcType . "-". $srcId . "' name='src_id' value='". $srcType . "-". $srcId . "' />" .
                                    $srcType . "-" . $srcId .
                                "</td>
                                <td>" . $citation .
                                "</td>
                                <td>
                                    <a href='jomon/";
                                    if(!empty($source->srcLocation)){
                                        echo $source->srcLocation;
                                    }else {
                                        echo ""; 
                                    }
                                echo "'>English</a>";
                                    if(!empty($source->website)){
                                        echo "<a href='" . $source->website . "' target='_blank'>Website</a>";
                                    }
                            echo "</td>
                            </tr>
                        </tbody>
                    </table>";
                    //print_r(var_dump($source));
                   // echo Source::createSourcePreview($source);
            }
        
        static public function uploadFile($source, $file){
            Source::uploadSource($source, $file);
        }

        static public function getSourceByAuthor($srcType, $name, $authorType)
    {
        switch($srcType){
            case 'a':
                $sources = Article::getSourceBy($name, $authorType);
                break;
            case 'ab':
                $sources = Summary::getSourceBy($name, $authorType);
                break;
            case 'b':
                $sources = Book::getSourceBy($name, $authorType);
                break;
            case 'd':
                $sources = Dissertation::getSourceBy($name, $authorType);
                break;
            case 'po':
                $sources = Poster::getSourceBy($name, $authorType); 
                break;
            case 'pr':
                $sources = Presentation::getSourceBy($name, $authorType); 
                break;
            case 'r':
                $sources = Radio::getSourceBy($name, $authorType); 
                break;
            case 't':
                $sources = Thesis::getSourceBy($name, $authorType); 
                break;
            case 'v':
                $sources = Video::getSourceBy($name, $authorType); 
                break;
            case 'w':
                $sources = Website::getSourceBy($name, $authorType); 
                break;
            default:
        }
        return $sources; 
    }
    static public function getAuthorHeading($sourceType, $authorType)
    {
        switch($authorType)
        {
            case "author":
                if($sourceType == 'Thesis')
                {
                    return "<h3>Theses</h3>";
                }
                return "<h3>" . $sourceType . "s</h3>";
            break;
            case "supervisor":
                if($sourceType == 'Thesis')
                {
                    return "<h3>Theses Supervised</h3>";
                }
                    return "<h3>" . $sourceType . "s Supervised</h3>";
            break;
            case "presenter":
                if($sourceType == 'Radio' )
                {
                    return "<h3>Radio and Podcast Presentations</h3>";
                }
                return "<h3>" . $sourceType . "s</h3>";
            break;
            case "creator":
                return "<h3>" . $sourceType . "s Created</h3>";
            break;
            case "uploader":
                return "<h3>" . $sourceType . "s Uploaded</h3>";
            break;
            case "webmaster":
                return "<h3>" . $sourceType . "s</h3>";
            break;
            default:
                return "<h3>" . $sourceType . "s Created</h3>";
        }
    }

    static public function createRecordByAuthor($srcType, $name, $authorType)
    {
        
        $sources = SourceCreator::getSourceByAuthor($srcType, $name, $authorType);
        if($sources)
        {
            echo SourceCreator::getAuthorHeading(SourceCreator::$sourceTypes[$srcType], $authorType);
            echo "<table class='table table-bordered' width='70%'>";
            if(is_array($sources))
            {
                foreach($sources as $source)
                {
                    echo "<tr>
                                <td class='col-md-2'>
                                    <input type='checkbox' class='record' value='" .h($source->srcType) . "-". h($source->srcId). "'></input> "
                                    . $source->srcType . " - " . $source->srcId . "</td>
                                <td>" . SourceCreator::createCitation($source->srcType, $source->srcId) . "</td>
                            </tr>";
                }
            }
            else
            {
                echo "<tr>
                                <td>" . $sources->srcType . " - " . $sources->srcId . "</td>
                                <td>" . SourceCreator::createCitation($sources->srcType, $sources->srcId) . "</td>
                            </tr>";
            }
            echo "</table>";
        }
    }
}

?>