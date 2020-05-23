<?php
//Connect to Database
require_once(dirname(__FILE__)."/../../private/initialize.php");

isset($_POST['src_id']) ? $ID = $_POST['src_id'] : null; 

$pieces = explode("-", $ID);
$src_type = $pieces[0];
$src_id = $pieces[1];		

//echo "Source type is " . $src_type . " and source ID is " . $src_id;
$artifacts = Artifact::find_by_id($src_type, $src_id);
?>
<!-- tabs -->
<ul id='artifactMenu' class='nav nav-tabs'>
        <li class='active'>
            <a data-toggle='tab' href='#artifact'>Artifacts</a>
        </li>
    </ul>
    <div id='artifacts' class='tab-content'>
    <div id='artifact' class='tab-pane fade in active'>
    
<table class='table'>
  <thead>
  	<tr>
     <th>Artifact</th>
	 <th>Artifact Class</th>
     <th>Site Name</th>
	<th>Time Period</th>
    <th>Quantity</th>
    </tr>
  </thead><tbody>
  
<?php
     foreach($artifacts as $artifact){?>
        <tr> 
            <td>
                <?php echo $artifact->artifact; ?>
            </td>
            <td>
                <?php echo $artifact->artifactClass; ?>
            </td>
            <td>
                <?php echo $artifact->siteName; ?>
            </td>
            <td>
                <?php echo $artifact->timePeriod; ?>
            </td>
            <td>
                <?php echo $artifact->quantity; ?>
            </td>
        </tr>
<?php } ?>
    </tbody>
</table><br />

		  <input type='button' id='addArtifact' value='Add Artifact'onclick='NewForm.buildForm("artifactForm", "artifact")'></input>
    </div>
    </div>