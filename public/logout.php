<?php
    session_start();
    if(!isset($_SESSION['user_id']))
    {
        require_once(dirname(__FILE__)."/../private/initialize.php");
        $url = Login::absolute_url();
        header("Location: $url");
        exit();
    }
    else
    {
        $_SESSION = array();
        session_destroy();
        setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
    }

    $page_title = 'Logged Out!';
    echo "<h1>Logged Out!</h1>
    <p>You are now logged out!</p>";
?>