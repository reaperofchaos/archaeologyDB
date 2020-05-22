<?php
    //Connect to Database
    require_once('../../private/initialize.php');

    isset($_POST['src_id']) ? $ID = $_POST['src_id'] : null; 

    $pieces = explode("-", $ID);
    $src_type = $pieces[0];
    $src_id = $pieces[1];	
    echo "<!-- tabs -->
    <ul id='tagsMenu' class='nav nav-tabs'>
        <li class='active'>
            <a data-toggle='tab' href='#tags'>Tags</a>
        </li>
    </ul>
    <div id='tags' class='tab-content'>
    <div id='tags' class='tab-pane fade in active'>
    <h3>Tags</h3>";
    $cultures = TagCreator::getTags($src_type, $src_id, "culture");
    if($cultures)
    {
        echo "<h3>Cultures</h3>";
        foreach($cultures as $culture)
        {
            echo $culture->culture . "<br/>";
        }
    }
    $disciplines = TagCreator::getTags($src_type, $src_id, "discipline");
    if($disciplines)
    {
        echo "<h3>disciplines</h3>";
        foreach($disciplines as $discipline)
        {
            echo $discipline->display() . "<br/>";
        }
    }
    
    $areas = TagCreator::getTags($src_type, $src_id, "area");
    if($areas)
    {
        echo "<h3>Area</h3>";
        foreach($areas as $area)
        {
            echo $area->display() . "<br/>";
        }
    }
    
    $timePeriods = TagCreator::getTags($src_type, $src_id, "time period");
    if($timePeriods)
    {
        echo "<h3>Time Period</h3>";
        foreach($timePeriods as $timePeriod)
        {
            echo $timePeriod->period . "<br/>";
        }
    }
    $theoreticalTopics = TagCreator::getTags($src_type, $src_id, "theoretical topic");
    if($theoreticalTopics)
    {
        echo "<h3>High Level Theory</h3>";
        foreach($theoreticalTopics as $theoreticalTopic)
        {
            echo $theoreticalTopic->theoretical_topic . "<br/>";
        }
    }
    $skeletalCollections = TagCreator::getTags($src_type, $src_id, "skeletal collection");
    if($skeletalCollections)
    {
        echo "<h3>Skeletal Collection</h3>";
        foreach($skeletalCollections as $skeletalCollection)
        {
            echo $skeletalCollection->collection . "<br/>";
        }
    }
    echo "<input type='button' id='addTag' value='Add Tag' onclick='NewForm.buildForm('tagForm', 'tag')'></input>
    </div>
    </div>";
?>
