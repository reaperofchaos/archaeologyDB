<?php
    //Connect to Database
    require_once('../../private/initialize.php');

    isset($_POST['src_id']) ? $ID = $_POST['src_id'] : null; 

    $pieces = explode("-", $ID);
    $src_type = $pieces[0];
    $src_id = $pieces[1];	

    $sites = Site::findSitesBySrc($src_type, $src_id); ?>
    <!-- tabs -->
    <ul id='siteMenu' class='nav nav-tabs'>
        <li class='active'>
            <a data-toggle='tab' href='#sites'>Sites</a>
        </li>
    </ul>
    <div id='siteTabs' class='tab-content'>
    <div id='sites' class='tab-pane fade in active'>
    <table class='table'>
        <thead>
            <tr>
            <th>Site ID</th>
            <th>Site Name</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($sites as $site){ ?>
            <tr>
                <td>
                    <?php echo !empty($site->siteId)
                             ?  $site->siteId 
                             : null; ?>
                </td>
                <td>
                    <?php echo !empty($site->siteName) 
                        ?  $site->siteName
                        : null; ?>
                </td>
            </tr>
    <?php } ?>
        </tbody>
    </table>
    <input type='button' id='addSite' value='Add Site' onclick='NewForm.buildForm("siteForm", "site")'></input>
    </div>
    </div>