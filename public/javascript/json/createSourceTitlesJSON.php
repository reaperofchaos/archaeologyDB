<?php
    require_once(dirname(__FILE__)."/../../../private/initialize.php");
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