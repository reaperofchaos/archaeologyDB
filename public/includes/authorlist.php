<?php
//$root = realpath($_SERVER["DOCUMENT_ROOT"]);

 //require_once($root.'\jomon\private\initialize.php');
 function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");
try
{
    include_once(dirname(__FILE__)."/./../private/initialize.php");
}
catch(ErrorException $ex)
{
    try
    {
        include_once(dirname(__FILE__)."/./../../private/initialize.php");
    }
    catch(ErrorException $e){
        echo "Unable to include initialization file <br />"; 
        echo $e . "<br />";
        $path = getcwd();
        echo "Current working directory = " . $path . "<br />";
    }
}
echo "<!-- Author tab with author records -->
        <div id='authorList' class='tab-pane fade' style='max-height: 500px;'>
                <!-- Authors list -->
                <div id='authorsList' style='height: 300px; overflow: scroll; width:800px;'>";
                ?>    
                    <!-- table for records -->`
                    <?php  $i = 0; 
                        $limit  = 50; //how many items to show per page
                        isset($_GET['authorPage']) ? $page = $_GET['authorPage'] : $page = 0;
                        $page != 0 ? $start = ($page - 1) * $limit : $start = 0;
                        $authors = Author::find_all_authors_by_limit($start, $limit);
                    ?>
                        
                    <?php foreach($authors as $a) {
                        if($i == 0 || $i % 50 == 0){ 
                        echo" <div id='results_" . $i ."' style='display: block;'>
                                <table class='table'> 
                                <tr>
                                    <th></th>
                                    <th>Author</th>
                                </tr>";
                        } 
                        $a->displayAuthorRecord(); 
                        $i++;
                    } 
                    echo"
                        </table>
                    </div>
                    <!-- end results div-->
                </div>
                <!-- end author list div -->";
                try
                {
                    include_once(dirname(__FILE__)."/./../private/shared/paginationAuthors.php");
                }
                catch(ErrorException $ex)
                {
                    try
                    {
                        include_once(dirname(__FILE__)."/./../../private/shared/paginationAuthors.php");
                    }
                    catch(ErrorException $e){
                        echo "Unable to include pagination"; 
                    }
                }

                //include($root.'\jomon\private\shared\paginationAuthors.php');
            echo "<!-- end author div -->
            </div>";
?>