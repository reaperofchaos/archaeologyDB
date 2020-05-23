<?php
    require_once(dirname(__FILE__)."/../private/initialize.php");
    isset($_POST['ID']) ? $id = $_POST['ID'] : $id = ""; 
    $n = preg_replace('/(?<!\ )[A-Z]/', ' $0', $id);
    $name = trim($n);
    echo "<h2>" .$name . "</h2>";
    
    //get Articles
    SourceCreator::createRecordByAuthor('a', $name, 'author');
    
    //get abstracts
    SourceCreator::createRecordByAuthor('ab', $name, 'author');

    //get Books
    SourceCreator::createRecordByAuthor('b', $name, 'author');
    SourceCreator::createRecordByAuthor('b', $name, 'editor');

    //get dissertations authored
    SourceCreator::createRecordByAuthor('d', $name, 'author');
    SourceCreator::createRecordByAuthor('d', $name, 'supervisor');

    //get theses authored
    SourceCreator::createRecordByAuthor('t', $name, 'author');
    SourceCreator::createRecordByAuthor('t', $name, 'supervisor');

    //get Posters 
    SourceCreator::createRecordByAuthor('po', $name, 'presenter');

    //get Presentations 
    SourceCreator::createRecordByAuthor('pr', $name, 'presenter');
    
    //get radio Presentations 
    SourceCreator::createRecordByAuthor('r', $name, 'presenter');
    
    //get videos created 
    SourceCreator::createRecordByAuthor('v', $name, 'creator');
    SourceCreator::createRecordByAuthor('v', $name, 'uploader');

    //get Websites 
    SourceCreator::createRecordByAuthor('w', $name, 'webmaster');
   
?>