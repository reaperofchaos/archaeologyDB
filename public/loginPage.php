<?php 
    $page_title = 'Login'; 
?>
<h1> Login</h1>
<form action='login.php' method='post'>
    <p>Username: 
        <input type='text' name='username' size='20' maxlength='80' /> 
    </p>
    <p>Password: 
        <input type='password' name='pass' size='20' maxlength='20' /> 
    </p>
    <p>
        <input type='submit' name='submit' value='login' /> 
    </p>
    <input type='hidden' name='submitted' value='TRUE' />
</form>
<a href='register.php'>Sign Up for Account </a>