<?php
//Connect to Database
require_once('../../private/initialize.php');

isset($_POST['src_id']) ? $ID = $_POST['src_id'] : null; 

$pieces = explode("-", $ID);
$src_type = $pieces[0];
$src_id = $pieces[1];
echo Bibliography::display($src_id, $src_type);
?>

