<?php
    require_once('../../../private/initialize.php');
    /*
    $response = array();
    $posts = array();
    $sourceTitles = Source::getAllTitles();
    foreach($sourceTitles as $sourceTitle){
        $title = h($sourceTitle.title);
        $response[] = array('title'=> $title,
                            'srcId'=>$srcType);
    }
    */
    $response = Source::getAllTitlesAsJSON();
    $fp = fopen('sourceTitles.json', 'w');
    fwrite($fp, $response);
    fclose($fp);
?> 