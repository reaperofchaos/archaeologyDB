<?php
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

set_error_handler("exception_error_handler");
try
{
    include_once('./../private/initialize.php');
}
catch(ErrorException $ex)
{
    try
    {
        include_once('./../../private/initialize.php');
    }
    catch(ErrorException $e){
        echo "Unable to include initialization file <br />"; 
        echo $e . "<br />";
        $path = getcwd();
        echo "Current working directory = " . $path . "<br />";
    }
}
    
//$root = realpath($_SERVER["DOCUMENT_ROOT"]);
//echo $root . 'jomon\private\initialize.php';

echo "<!-- home tab with source records -->
            <div id='sourceList' class='tab-pane fade in active' style='max-height: 500px;'>
                <!-- Record buttons -->
                <div id='mainButtonList'>
                        <table class='table'>
                            <tr>
                                <td>
                                    <input type='button' class='addSource' value='Add Source' />
                                </td>
                            </tr>
                        </table>
                <!-- end record buttons -->
                </div>
                <!-- records list -->
                <div id='recordsList' style='height: 300px; overflow: scroll; width:800px;'>";
                ?>    
                    <!-- table for records -->`
                    <?php  $i = 0; 
                        $limit = 50; //how many items to show per page
                        isset($_GET['page']) ? $page = $_GET['page'] : $page = 0;
                        $page != 0 ? $start = ($page - 1) * $limit : $start = 0;
                        $sources = Source::find_all_sources_by_limit($start, $limit);
                        ?>
                        
                    <?php foreach($sources as $source) {
                        if($i == 0 || $i % 50 == 0){ 
                        echo" <div id='results_" . $i ."' style='display: block;'>
                                <table class='table'> 
                                <tr>
                                    <th></th>
                                    <th>Record ID</th>
                                    <th>Source ID</th>
                                    <th>Source Name</th>
                                </tr>";
                        } 
                        $source->displayRecord(); 
                        $i++;
                    } 
                    echo"
                        </table>
                    </div>
                    <!-- end results_ id -->
                </div>
                <!-- end record list div -->";
                try
                {
                    include_once('./../private/shared/pagination.php');
                }
                catch(ErrorException $ex)
                {
                    try
                    {
                        include_once('./../../private/shared/pagination.php');
                    }
                    catch(ErrorException $e){
                        echo "Unable to include pagination"; 
                    }
                }
                //include($root.'\jomon\private\shared\pagination.php');
            echo "</div>";
?>