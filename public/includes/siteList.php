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
        $path = getcwd();
        echo "Current working directory = " . $path . "<br />";
    }
}
echo "<!-- Site tab with site records -->
        <div id='siteList' class='tab-pane fade' style='max-height: 500px;'>
                <!-- sitesList list -->
                <div id='sitesList' style='height: 300px; overflow: scroll; width:800px;'>";
                    //table for records
                    $i = 0; 
                        $limit  = 50; //how many items to show per page
                        isset($_GET['sitePage']) ? $page = $_GET['sitePage'] : $page = 0;
                        $page != 0 ? $start = ($page - 1) * $limit : $start = 0;
                        $sites = Site::find_all_sites_by_limit($start, $limit);
                    ?>
                        
                    <?php foreach($sites as $a) {
                        if($i == 0 || $i % 50 == 0){ 
                        echo" <div id='results_" . $i ."' style='display: block;'>
                                <table class='table'> 
                                <tr>
                                    <th></th>
                                    <th>Site</th>
                                </tr>";
                        } 
                        $a->displaySiteRecord(); 
                        $i++;
                    } 
                    echo"
                        </table>
                    </div>
                    <!-- end results div-->
                </div>
                <!-- end site list div -->";
                try
                {
                    include_once(dirname(__FILE__)."/./../private/shared/paginationSites.php");
                }
                catch(ErrorException $ex)
                {
                    try
                    {
                        include_once(dirname(__FILE__)."/./../../private/shared/paginationSites.php");
                    }
                    catch(ErrorException $e){
                        echo "Unable to include pagination"; 
                    }
                }
                //include($root.'\jomon\private\shared\paginationSites.php');
            echo "<!-- end site div -->
            </div>";
?>