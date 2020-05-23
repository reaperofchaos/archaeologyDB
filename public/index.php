<?php 
require_once(dirname(__FILE__)."/../private/initialize.php");
?>
<!-- Doctype HTML5 -->
<!doctype html>
<html lang ='en'>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title> Jomon Database</title>
        <?php $r = rand(1,1000); ?>
        <meta name='description' content='Future database of articles and data related to the Jomon Culture in Japan'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script> 
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
         <script src='javascript/jomon.js?r=<?php echo $r; ?>'></script>
        <script src='javascript/formVariables.js?r=<?php echo $r; ?>'></script>
        <script src='javascript/tabs.js?r=<?php echo $r; ?>'></script>
        <script src='javascript/searchBoxes.js?r=<?php echo $r; ?>'></script>
        <script src='javascript/tagLogic.js?r=<?php echo $r; ?>'></script>
        <script src='javascript/Button.class.js?r=<?php echo $r; ?>'></script>
        <script src='javascript/ButtonGroup.class.js?r=<?php echo $r; ?>'></script>
        <script src='javascript/NewForm.class.js?r=<?php echo $r; ?>'></script>
        <script src='javascript/forms.json?r=<?php echo $r; ?>'></script>
        <link rel='icon' type='image/png' href='includes/favicon.ico'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
        <link rel='stylesheet' href='css/styles.css?r=<?php echo $r; ?>'>
        <link rel='stylesheet' href='css/tabs.css'>
        <link rel="stylesheet" href="css/jomondbMenu.css">
        <link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css'>
    </head>
    <body>
        <header class='bgimage' style='max-height: 100px;'>
        <div class='container'>
        <h1>Jomon Database</h1>  
        </div>
        </header>
        <!-- index page container element -->
        <div class='container'>
            <?php 
                //menu
                include 'includes/menu.php';
                include 'includes/datalists.php';
                //search box
                include 'includes/searchBox.php';
                //tab bar
                include 'includes/tabs.php';
                //list of records and pagination
                include 'includes/recordList.php';
                //author lists
                //include 'includes/authorList.php';
                //site lists
                //include 'includes/siteList.php';

            ?>
                    <!-- end tab content -->
                    </div>
                <!-- end div col-sm-8 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container div-->
        </div>
    </body>
</html>