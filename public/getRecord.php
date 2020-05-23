<?php
    require_once(dirname(__FILE__)."/../private/initialize.php");
    isset($_POST['ID']) ? $ID = $_POST['ID'] : $ID = ""; 

	if ($ID != ''){
        $pieces = explode('-', $ID);
    $srcType = $pieces[0];
    $srcId = $pieces[1];
    $srcID = $ID;
    ?>
    <!--Build table of buttons -->
    <?php include_once(dirname(__FILE__)."/../private/shared/recordTabs.php"); ?>

       <?php 
        $source = SourceCreator::findSource($srcType, $srcId);
        $citation = SourceCreator::createCitation($srcType, $srcId);
        SourceCreator::createRecord($source, $citation, $srcType, $srcId); ?>
            <!--build the form to add source tags -->
    <?php 
        include_once(dirname(__FILE__)."/../private/shared/recordTagForm.php");
        include_once(dirname(__FILE__)."/../private/shared/recordTabDivs.php");
        }else{}
    ?>