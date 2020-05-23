<?php
//Connect to Database
require_once(dirname(__FILE__)."/../../private/initialize.php");

isset($_POST['src_id']) ? $ID = $_POST['src_id'] : null; 

$pieces = explode("-", $ID);
$src_type = $pieces[0];
$src_id = $pieces[1];		
//echo "Source type is " . $src_type . " and source ID is " . $src_id;
$plants = Plant::find_by_id($src_type, $src_id);
?>
<!-- tabs -->
<ul id='plantMenu' class='nav nav-tabs'>
        <li class='active'>
            <a data-toggle='tab' href='#plantRemains'>Plant Remains</a>
        </li>
    </ul>
    <div id='plant' class='tab-content'>
    <div id='plantRemains' class='tab-pane fade in active'>
    
<table class='table'>
  <thead>
  	<tr>
     <th>Site</th>
	 <th>Plant Name</th>
     <th>Plant Type</th>
	<th>Quantity</th>
    </tr>
  </thead><tbody>
  
<?php
     foreach($plants as $plant){?>
        <tr> 
            <td>
                <?php echo $plant->siteName; ?>
            </td>
            <td>
                <?php echo $plant->plantName; ?>
            </td>
            <td>
                <?php echo $plant->plantType; ?>
            </td>
            <td>
                <?php echo $plant->quantity; ?>
            </td>
        </tr>
<?php } ?>
    </tbody>
</table><br />
		  <input type='button' id='addPlants' value='Add Plant Remains' onclick='NewForm.buildForm("plantForm", "plant")'></input>
    </div>
    </div>