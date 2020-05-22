<!--build tabs-->
<!-- Main menu tab location -->
<div class='col-sm-12'>
    <ul id='recordMenu_<?php echo $srcId; ?>' class='nav nav-tabs'>
        <li class='nav-item'>
            <a data-toggle='tab' href='#general_<?php echo $srcId; ?>' class='nav-link active'>General</a>
        </li>
        
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#notes_<?php echo $srcId; ?>'>Notes</a>
        </li>
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#radiocarbon_<?php echo $srcId; ?>'>Radiocarbon Dates</a>
        </li>
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#stableIsotopes_<?php echo $srcId; ?>'>Stable Isotopes</a>
        </li>
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#plantRemains_<?php echo $srcId; ?>'>Plant Remains</a>
            <span>x</span>
        </li>
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#artifacts_<?php echo $srcId; ?>'>Artifacts</a>
        </li>
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#sites_<?php echo $srcId; ?>'>Sites</a>
        </li>
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#tags_<?php echo $srcId; ?>'>Tags</a>
        </li>
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#bibliography_<?php echo $srcId; ?>'>Bibliography</a>
        </li>
        <li class='nav-item'>
            <a data-toggle='tab' class='nav-link' href='#changeLog_<?php echo $srcId; ?>'>Change Log</a>
        </li>
    </ul>
    <div id='recordTab_<?php echo $srcId; ?>' class='tab-content'>
    <div id='general_<?php echo $srcId; ?>' class='tab-pane fade in active' style='max-height: 500px;'>

