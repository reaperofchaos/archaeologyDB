<!--Build table of record buttons-->
    <div id='buttonList'>
		<table class='table'>
            <tr>
                <td>
                    <input type='button' onclick='buildPopup(\"notes\", \"Notes\")' value='Notes'></input>
                </td>
                <td>
                    <input type='button' class='radioCarbon' value='Radiocarbon Dates' id='<?php echo $srcID; ?>_radioCarbon'></input>
                </td>
                <td>
                    <input type='button' class='stableIsotopes' value='Stable Isotopes' id='<?php echo $srcID; ?>_stableIsotopes'></input>
                </td>
                <td>
                    <input type='button' class='plantRemains' value='Plant Remains' id='<?php echo $srcID; ?>_plantRemains'></input>
                </td>
                <td>
                    <input type='button' class='artifacts' value='Artifacts' id='<?php echo $srcID; ?>_artifacts'></input>
                </td>
                <td>
                    <input type='button' class='sites' value='Sites' id='<?php echo $srcID; ?>_sites'></input>
                </td>
                <td>
                    <input type='button' class='tags' value='Tags' id='<?php echo $srcID; ?>_tags'></input>
                </td>
                <td>
                    <input type='button' class='bibliography' value='Bibliography' id='<?php echo $srcID; ?>_bibliography'></input>
                </td>
                <td>
                    <input type='button' class='changeLog' value='Change Log' id='<?php echo $srcID; ?>_changeLog'></input>
                </td>
            </tr>
		</table>
		</div>
