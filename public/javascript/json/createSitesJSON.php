<?php
    require_once('../../../private/initialize.php');
    $response = array();
    $posts = array();
    $authors = Site::getAllSites();
    foreach($authors as $a){
        $author = h($a);
        $response[] = array('site'=> $author);
    }
    $fp = fopen('sites.json', 'w');
    fwrite($fp, json_encode($response));
    fclose($fp);
?> 