<?php 
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script> 
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css'>";
    require_once(dirname(__FILE__)."/../private/initialize.php");
    $loginErrors = array();
    if(isset($_POST['submitted']))
    {
        list ($check, $data) = Login::check_login($_POST['username'], $_POST['pass'], $loginErrors);
        
        if($check)
        {
            if (session_status() == PHP_SESSION_ACTIVE) {
                echo 'Session is active';
           
            }else
            {
                session_start();
                $_SESSION['user_id'] = $data['userID'];
                $_SESSION['name'] = $data['name'];
                echo $_SESSION['name'];
                /*
                //using cookies
                setcookie('user_id', $data->getUserID(), time()+3600, '/', '', 0, 0);
                setcookie('name', $data->getName(), time()+3600, '/', '', 0, 0);
                */
                echo "Successfully logged in " . $_SESSION['name'] . "!<br />";
                //$url = Login::absolute_url('loggedin.php');
                //header("Location: $url");
            }
        }
    }
     
    //include('loginPage.php');
    foreach($loginErrors as $error)
    {
        echo "<div class=\"alert alert-danger alert-dismissible\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
        <strong>Error</strong>    
        <p>" . $error . "</p> 
        </div>"; 
    }
?>