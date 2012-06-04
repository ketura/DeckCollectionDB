<HTML>
<TITLE>Lord of the Rings TCG Collection Database</TITLE>
<BODY>
<?php
    include("users.php");
    
    if(isset($_SESSION['username']) or isset($_POST['username']))
    {
        $username = $_SESSION['username'];
        
        echo('<h2>User Page</h2>' .
                "<h3>$username</h3>" .
                '<p>This is your private user page! You may change options below.</p>' .
                '<h4>Change password:</h4>' .
                '<form action="user.php" method="post"/>' .
                'Old Password: <input type ="password" name = "oldpassword"/>  ' .
                'New Password: <input type="password" name="newpassword" />  ' .
                'Retype Password: <input type="password" name="newpassword2"/>  ' .
                '<input type="hidden" name="username" value="'.$username.'"/>' .
                '<input type="submit" value="Submit" />' .
                '</form>' );
                
        if(isset($_POST['oldpassword']) and isset($_POST['newpassword']) and isset($_POST['newpassword2']))
        {
            $oldpass = $_POST['oldpassword'];
            $newpass1 = $_POST['newpassword'];
            $newpass2 = $_POST['newpassword2'];
            
            if(@user_login($username, $oldpass, true))
            {
                if($newpass1 == $newpass2)
                {
                    if(set_password($username, $newpass1))
                    {
                        echo("Password changed successfully!");
                    }
                    else
                    {
                        echo("Password change failed.");
                    }
                }
                else
                {
                    echo("New passwords do not match!");
                }   
            }
            else
            {
                echo("Incorrect Password.");
            }
        }
        
        if($username == $admin)
        {
            echo('<br><br><h2>Admin Control Panel</h2>' .
                    'Here you can perform some limited Administrator tasks:<br><br>' .
                    'WARNING: THE FOLLOWING WILL COMPLETELY DROP THE CARD DATABASE AND REGENERATE FROM XML:' . 
                    '<form action="carddbfromxml.php" method="post"/>' .
                    '<input type="hidden" name="page" value="/user.php"/>' .
                    '<input type="submit" value="Purge/Regen Card Data" />' .
                    '</form>');
        }
        
    }
    else
    {
        echo('<h3>You are not logged in!  Click on the link above to log in or register.<h3>');
    }
?>
<br><br><a href="/main.php">Return to the Main Page.</a>
</BODY>
</HTML>
