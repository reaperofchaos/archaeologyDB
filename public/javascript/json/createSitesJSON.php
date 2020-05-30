<?php
    require_once(dirname(__FILE__)."/../../../private/initialize.php");
    $response = array();
    $posts = array();
    $authors = Site::getAllSites();
    foreach($authors as $a){
        $author = h($a);
        $response[] = array('site'=> $author);
    }
    $fp = fopen('sites.json', 'w');
    if(fwrite($fp, json_encode($response)))
    {
        echo "1";
    }
    else
    {
        echo "0";
    };
    fclose($fp);
?> 