<!--Builds form for source tags on the getRecord.php page -->
            <table class='table' id='recordTags'>
                <tr>
                    <td>
                        <div id='<?php echo $srcID; ?>l1Tag_1'>
                            <label for='tag'>Add a tag</label>
                            <select class='tag' name='tag_1' id='<?php echo $srcID; ?>tag_1'>
                                <option id=''></option>
                                <option id='Discipline'>Discipline</option>
                                <option id='Culture'>Culture</option>
                                <option id='Data'>Archaeology Data</option>
                                <option id='Image'>Image</option>
                                <option id='Bibliography'>Bibliography Reference</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div id='"<?php echo $srcID; ?>"l2Tag_1'></div>
                    </td>
                    <td>
                        <div id='<?php echo $srcID; ?>l3Tag_1'></div>
                    </td>
                    <td>
                        <div id='<?php echo $srcID; ?>l4Tag_1'></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id='<?php echo $srcID; ?>l5Tag_1'></div>
                    </td>
                    <td>
                        <div id='<?php echo $srcID; ?>l6Tag_1'></div>
                    </td>
                    <td>
                        <div id='<?php echo $srcID; ?>l7Tag_1'></div>
                    </td>
                    <td>
                        <div id='<?php echo $srcID; ?>l8Tag_1'></div>
                    </td>
                </tr>
            </table>
            <label for='status<?php echo $srcID; ?>'>Status</label>
            <select name='status<?php echo $srcID; ?>' id='status<?php echo $srcID; ?>'>
                    <option id='Completed' id='Completed'>Completed</option>
                    <option id='Not Related' id='Not Related'>Not Related</option>
                    <option id='Unworked' name='Not Worked'>Not Worked</option>
            </select>
            <input type='button' id='submit' value='submit' />
