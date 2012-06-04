<?php
    session_start();
    $admin = "ketura";
    
    $dbcx = @mysql_connect("localhost", "root", "");
    if(!$dbcx)
    {
        echo("<p>Unable to connect to the Card Database server at this time.</p>");
        
        exit('Failed to connect to LotR-TCG-CDB');
    }
    
    if(!@mysql_select_db("LotR-TCG", $dbcx))
    {
        echo("<p>Unable to locate the LotR-TCG schema at this time.</p>");
        exit();
    }
    
    function user_login($username, $password, $silent = false)
    {
        $username = mysql_real_escape_string($username);
        $password = sha1("$username:" . mysql_real_escape_string($password));
        
        $sql = mysql_query("SELECT * FROM usersystem WHERE username = '$username' AND password = '$password' LIMIT 1");
        
        $rows = mysql_num_rows($sql);
        if($rows <=0)
        {
            if(!$silent)
            {
                echo("Incorrect username or password.");
            }
            
            return false;
        }
        else
        {
            $_SESSION['username'] = $username;
            if(!$silent)
            {
                echo("Login Successful.");
            }
            
            return true;
        }
    }
    
    function user_logout()
    {
        session_destroy();
    }
    
    function set_password($username, $password)
    {
        $username = mysql_real_escape_string($username);
        $password = sha1("$username:" . mysql_real_escape_string($password));
        
        $sql = mysql_query("SELECT * FROM usersystem WHERE username = '$username' LIMIT 1");
        
        $rows = mysql_num_rows($sql);
        if($rows <=0)
        {
            echo("No such username");
            return false;
        }
        else
        {
            return mysql_query("UPDATE usersystem SET password = '$password' WHERE username = '$username';");
        }
    }
        
    function curPageName() 
    {
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }
    
    
    
    if(isset($_SESSION['username']))
    {
        echo('Logged in as: <a href="/user.php">' . $_SESSION['username'] . '</a>');
        echo('<form action="logout.php" method="post">' .
            '<input type="submit" value="Logout" /></form>');
        $_SESSION['currentpage'] = curPageName();
    }
    else
    {
        if(curPageName() != "login.php")
        {
            echo('<a href="/login.php">Hello!  Log in or Register.</a><br>');
        }
    }
    
    
?>
