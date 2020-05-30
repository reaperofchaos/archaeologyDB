<?php
    session_start(); 
    
    if(isset($_SESSION['user_id']))
    {
        require_once(dirname(__FILE__)."/../private/initialize.php");
        $url = Login::absolute_url(); 
        header("Location: $url");
        exit();
    }
    /*
    if(!isset($_COOKIE['user_id']))
    {
        require_once(dirname(__FILE__)."/../private/initialize.php");
        Login::absolute_url();
        header("Location: $url");
        exit();
    }
    
    $page_title = 'Logged In!';
    echo "<h1>Logged In!</h1>
          <p>You are now logged in, {$_COOKIE['name']}!</p>
          <p><a href='\"logout.php\">Logout</a></p>";
    */
    $page_title = 'Logged In!';
    echo "<h1>Logged In!</h1>
          <p>You are now logged in, {$_SESSION['name']}!</p>
          <p><a href='\"logout.php\">Logout</a></p>";
?>