<?php
    require_once(dirname(__FILE__)."/../../../private/initialize.php");
    $response = array();
    $posts = array();
    $authors = Source::getAllAuthors();
    foreach($authors as $a){
        $author = h($a);
        $response[] = array('author'=> $author);
    }
    $fp = fopen('authors.json', 'w');
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