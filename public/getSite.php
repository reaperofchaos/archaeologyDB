<?php
    require_once(dirname(__FILE__)."/../private/initialize.php");
    isset($_POST['siteName']) ? $siteName = $_POST['siteName'] : $siteName = ""; 
    $site = Site::findBySiteName($siteName);
    $site[0]->getTimePeriods();
    Site::siteRecord($site[0]);
?>
