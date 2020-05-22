<?php
    require_once('../private/initialize.php');
    isset($_POST['src_id']) ? $siteName = $_POST['src_id'] : $siteName = ""; 
    $site = Site::findBySiteName($siteName);
    $site[0]->getTimePeriods();
    Site::siteRecord($site[0]);
?>
