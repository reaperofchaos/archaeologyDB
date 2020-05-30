<?php

function absolute_url($page = 'index.php')
{
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    return $url;
}

function check_login($dbc, $email= '', $pass = '')
{
    $errors = array(); //initialize error array
    if(empty($email))
    {
        $errors[] = 'You forgot to enter your email address';
    }
    else
    {
        $e = trim($email);
    }

    $errors = array(); //initialize error array
    if(empty($pass))
    {
        $errors[] = 'You forgot to enter your password';
    }
    else
    {
        $p = trim($pass);
    }

    if(empty($errors))
    {
        $q  = "SELECT user_id, first_name ";
        $q .= "FROM users ";
        $q .= "WHERE email = '" . $e . "' ";
        $q .= "AND pass=SHA1('". $p . "') ";
        $q .= "LIMIT 1";
        $r = LOGIN::$database->prepare($q);
        $result->execute();
        $row = $result->fetch();
        return array(TRUE, $row);
    }
    else
    {
        $errors = "The email address and password entered do not match those on file.";
    }
}
?>
