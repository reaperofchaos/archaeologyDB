<?php
    //Connect to Database
    require_once('../../private/initialize.php');

    isset($_POST['src_id']) ? $ID = $_POST['src_id'] : null; 

    $pieces = explode("-", $ID);
    $src_type = $pieces[0];
    $src_id = $pieces[1];	

    $notes = Note::findNotesBySrc($src_type, $src_id); ?>
    <!-- tabs -->
    <ul id='noteMenu' class='nav nav-tabs'>
        <li class='active'>
            <a data-toggle='tab' href='#notes'>Notes</a>
        </li>
    </ul>
    <div id='noteTabs' class='tab-content'>
    <div id='notes' class='tab-pane fade in active'>
        <?php
             if(is_array($notes))
            {
                foreach($notes as $note)
                {
                    $note->displayNotes();
                }
            }
            else
            {
                $notes->displayNotes();
            }
        ?>
        <input type='button' id='addNote' value='Add Note' onclick='NewForm.buildForm("noteForm", "note")'></input>
    </div>
    </div>