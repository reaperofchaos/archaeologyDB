    <?php
    //Connect to Database
    require_once(dirname(__FILE__)."/../../private/initialize.php");

    isset($_POST['src_id']) ? $ID = $_POST['src_id'] : null; 

    $pieces = explode("-", $ID);
    $src_type = $pieces[0];
    $src_id = $pieces[1];		

    $stableIsotopes = StableIsotope::find_by_id($src_type, $src_id); 
    //print_r($stableIsotopes); ?>
    <!-- tabs -->
    <ul id='stableIsotopeMenu' class='nav nav-tabs'>
        <li class='active'>
            <a data-toggle='tab' href='#stableIsotopes'>Stable Isotopes</a>
        </li>
    </ul>
    <div id='stableIsotope' class='tab-content'>
    <div id='stableIsotopes' class='tab-pane fade in active'>
    <table class='table'>
        <thead>
            <tr>
            <th>Sample ID</th>
            <th>Species</th>
            <th>Element</th>
            <th>Age</th>
            <th>Sex</th>
            <th>C13</th>
            <th>N15</th>
            <th>Source</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($stableIsotopes as $si){ ?>
            <tr>
                <td>
                    <?php echo !empty($si->sampleId)
                             ?  $si->sampleId 
                             : null; ?>
                </td>
                <td>
                    <?php echo !empty($si->species) 
                        ?  $si->species
                        : null ?>
                </td>
                <td>
                    <?php echo !empty($si->element) 
                        ? $si->element
                        : null; ?>
                </td>
                <td>
                    <?php echo !empty($si->age)
                        ? $si->age
                        : null; ?>
                </td>
                <td>
                    <?php echo !empty($si->sex) 
                        ?  $si->sex 
                        : null; ?>
                </td>
                <td>
                    <?php echo $si->c13 != ""
                            ?   $si->c13
                            : null; ?>
                </td>
                <td>
                    <?php echo $si->n15 != ""
                            ?   $si->n15
                            : null; ?>
                </td>         
                <td>
                    <?php echo $si->srcType != ""
                            ?   $si->srcType . " - " . $si->srcId
                            : null; ?>
                </td>   
        </tr>
    <?php } ?>
        </tbody>
    </table>
    <input type='button' id='addStableIsotope' value='Add Stable Isotope Value' onclick='NewForm.buildForm("stableIsotopeForm", "stableIsotope")'></input>
    </div>
    </div>