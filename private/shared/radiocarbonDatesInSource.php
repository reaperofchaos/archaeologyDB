    <?php
    //Connect to Database
    require_once(dirname(__FILE__)."/../../private/initialize.php");

    isset($_POST['src_id']) ? $ID = $_POST['src_id'] : null; 

    $pieces = explode("-", $ID);
    $src_type = $pieces[0];
    $src_id = $pieces[1];		

    $radioCarbonDates = Radiocarbon::find_by_id($src_type, $src_id); ?>
    <!-- tabs -->
    <ul id='radiocarbonMenu' class='nav nav-tabs'>
        <li class='active'>
            <a data-toggle='tab' href='#radiocarbonDates'>Radiocarbon Dates</a>
        </li>
    </ul>
    <div id='radiocarbon' class='tab-content'>
    <div id='radiocarbonDates' class='tab-pane fade in active'>
    <table class='table'>
        <thead>
            <tr>
            <th>Sample ID</th>
            <th>Date</th>
            <th>Material</th>
            <th>Site</th>
            <th>Context</th>
            <th>Obtained</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($radioCarbonDates as $radioCarbonDate){ ?>
            <tr>
                <td>
                    <?php echo !empty($radioCarbonDate->labNo)
                             ?  $radioCarbonDate->labNo 
                             : null; ?>
                </td>
                <td>
                    <?php echo empty($radioCarbonDate->date) 
                        ?  null
                        : !empty($radioCarbonDate->standardError) 
                            ?  $radioCarbonDate->date . " +/- " . $radioCarbonDate->standardError
                            : $radioCarbonDate->date; ?>
                </td>
                <td>
                    <?php echo !empty($radioCarbonDate->material) ? $radioCarbonDate->material : null; ?>
                </td>
                <td>
                    <?php echo !empty($radioCarbonDate->site) ? $radioCarbonDate->site : null; ?>
                </td>
                <td>
                    <?php echo !empty($radioCarbonDate->context) ?  $radioCarbonDate->context : null; ?>
                </td>
                <td>
                    <?php echo $radioCarbonDate->submittedBy != ""
                            ?   "Submitted by: " . $radioCarbonDate->submittedBy . "<br />"
                            : null;
                         echo $radioCarbonDate->collectedBy != ""
                            ?  "Collected by: " . $radioCarbonDate->collectedBy . "<br />"
                            : null; ?>
                </td>
            </tr>
    <?php } ?>
        </tbody>
    </table>
    <input type='button' id='addRadiocarbonDate' value='Add Radiocarbon Date' onclick='NewForm.buildForm("radioCarbonDateForm", "radiocarbon")'></input>
    </div>
    </div>