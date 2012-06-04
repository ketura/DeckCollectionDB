<?php
    include("users.php");
    

    if(isset($_POST['rusername']) and isset($_POST['rpassword']) and isset ($_POST['rpassword2']))
    {
        $username = mysql_real_escape_string($_POST['rusername']);
        if(isset($_POST['remail']))
        {
            $email = mysql_real_escape_string($_POST['remail']);
        }
        else
        {
            $email = "";
        }
        
        
        $password = sha1($username . ":" . $_POST['rpassword']);
        $password2 = sha1($username . ":" . $_POST['rpassword2']);
        
        $sql = mysql_query("SELECT username FROM usersystem WHERE username = '$username'");
        if(mysql_num_rows($sql) > 0)
        {
            die("Username already in use.  Please select a unique username.");
        }
        else if($password != $password2)
        {
            die("Passwords do not match.  Please try again.");
        }
        else
        {
            $sql = "INSERT INTO usersystem SET " .
                    "username = '$username', " .
                    "password = '$password', " .
                    "email = '$email';" ; 
            
            if(@mysql_query($sql))
            {
                echo("Account successfully created.");
            }
            else
            {
                die(mysql_error());
            }
        }
    }
    else if(isset($_POST['username']) and isset($_POST['password']))
    {
        if(user_login($_POST['username'], $_POST['password']))
        {
            header ("Location: /main.php");
        }
    }
?>

<html>
    <H2>Login:</H2>
    <form action="login.php" method="post">
    Username: <input type="text" name="username"/>
    Password: <input type="password" name="password" />
    <input type="submit" value="Submit" />
    </form>
    
    
    <H2>Register:</H2>
    <form action="login.php" method="post">
    Username: <input type="text" name="rusername"/>
    Password: <input type="password" name="rpassword" />
    Retype Password: <input type="password" name="rpassword2"/>
    Email: <input type="text" name="remail"/>
    <input type="submit" value="Submit" />
    </form>
    
    
</html>
