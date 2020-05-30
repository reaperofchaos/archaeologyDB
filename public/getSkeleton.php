<?php
    require_once(dirname(__FILE__)."/../private/initialize.php");
    isset($_POST['id']) ? $individualId = $_POST['id'] : $individualId = ""; 
    $skeleton = Skeleton::findById($individualId);
    $skeleton->display();
?>
