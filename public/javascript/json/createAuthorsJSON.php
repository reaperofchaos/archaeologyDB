<?php
    require_once('../../../private/initialize.php');
    $response = array();
    $posts = array();
    $authors = Source::getAuthors();
    foreach($authors as $a){
        $author = h($a);
        $response[] = array('author'=> $author);
    }
    $fp = fopen('authors.json', 'w');
    fwrite($fp, json_encode($response));
    fclose($fp);
?> 