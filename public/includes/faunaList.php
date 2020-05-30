<?php
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
    }
}

echo "<!-- home tab with source records -->
            <div id='faunaList' class='tab-pane fade in active' style='max-height: 500px;'>    
            <!-- Record buttons -->
                <div id='mainButtonList'>
                        <table class='table'>
                            <tr>
                                <td>
                                    <input type='button' class='addFauna' value='Add Fauna' />
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
                        isset($_GET['faunaPage']) ? $page = $_GET['faunaPage'] : $page = 0;
                        $page != 0 ? $start = ($page - 1) * $limit : $start = 0;
                        $animals = Fauna::find_all_species_by_limit($start, $limit);
                        ?>
                        
                    <?php foreach($animals as $animal) {
                        if($i == 0 || $i % 50 == 0){ 
                        echo" <div id='results_" . $i ."' style='display: block;'>
                                <table class='table'> 
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Genus</th>
                                    <th>Specie</th>
                                </tr>";
                        } 
                        $animal->displayRecord(); 
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
                    include_once(dirname(__FILE__)."/./../private/shared/pagination.php");
                }
                catch(ErrorException $ex)
                {
                    try
                    {
                        include_once(dirname(__FILE__)."/./../../private/shared/pagination.php");
                    }
                    catch(ErrorException $e){
                        echo "Unable to include pagination"; 
                    }
                }
                //include($root.'\jomon\private\shared\pagination.php');
            echo "</div>";
?>
?>