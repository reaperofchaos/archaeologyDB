<?php     
    require_once(dirname(__FILE__)."/../../private/initialize.php");
$id = $_POST['id'];
?>
        <!-- Source Selector -->
        <label for='srcType_<?php echo $id; ?>'>Source Type:</label>
                    <select id='srcType_<?php echo $id; ?>' onChange='selectFormType(<?php echo $id; ?>)'>
                        <option value=''></option>
                        <option value='a'>Article</option>
                        <option value='b'>Book</option>
                        <option value='pr'>Presentation</option>
                        <option value='po'>Poster</option>
                        <option value='ab'>Abstract</option>
                        <option value='t'>Thesis</option>
                        <option value='d'>Dissertation</option>
                        <option value='v'>Video</option>
                        <option value='w'>Website</option>
                        <option value='r'>Radio Broadcast</option>
                    </select>
<br />
<div id='sourceForm_<?php echo $id; ?>'>
</div>