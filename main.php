<?php
    include("users.php");

    include("lexical-analysis.php");
?>

<HTML>
<TITLE>Lord of the Rings TCG Collection Database</TITLE>
    <BODY> 
    <p>Welcome to the Lord of the Rings TCG Collection Database.  Make your selection below.<p>
    <br><br>
    <p><form action="main.php" method="get"/>
        Card Type: <input type ="text" name = "cardtype"/> From Set <input type ="text" name = "firstset"/>  to  <input type ="text" name = "lastset"/>
        <input type="submit" value="Submit" />
        </form></p>
    
    <p><form action="main.php" method="get"/>
        Card ID: <input type ="text" name = "cardid"/> 
        <input type="submit" value="Submit" />
        </form></p>

<?php
    if(isset($_GET['cardtype']))
    {
        $firstset = 0;
        $lastset = 19;
        
        if($_GET['cardtype'] != "all" and $_GET['cardtype'] != "everything")
        {
            $cardtype = card_type_number($_GET['cardtype']);
        }
        else
        {
            $cardtype = $_GET['cardtype'];
        }   
        
        
        

        if(isset($_GET['firstset']))
        {
            if(!is_numeric($_GET['firstset']) or $_GET['firstset'] < 0)
            {
                echo("Malformed From Set.  Defaulting to set 0.<br>");
                $firstset = 0;
            }
            
            $firstset = $_GET['firstset'];
        }
        
        if(isset($_GET['lastset']))
        {
            if(!is_numeric($_GET['lastset']) or $_GET['lastset'] > 19)
            {
                echo("Malformed Last Set.  Defaulting to set 19.<br>");
                $lastset = 19;
            }
            
            $lastset = $_GET['lastset'];
        }
        
        if($firstset > $lastset)
        {
            echo("First Set greater than Last Set.  Displaying all sets.");
        }

        if($cardtype == "all")
        {
            $sql = mysql_query("SELECT image FROM lotrtcg_cards_decipher WHERE set_number >='$firstset' AND set_number <='$lastset'");
        }
        else if($cardtype == "everything")
        {
            $sql = mysql_query("SELECT image FROM lotrtcg_cards_decipher");
        }
        else
        {
            $sql = mysql_query("SELECT image FROM lotrtcg_cards_decipher WHERE card_type='$cardtype' AND set_number >='$firstset' AND set_number <='$lastset'");
        }
            
        if(!$sql)
        {
            echo mysql_error();
        }
        while($row = mysql_fetch_array($sql))
        {
            $image = $row['image'];
            echo("<img src=\"http://lotrtcgwiki.com/wiki/_media/cards:$image.jpg\"/>");
        }
    }
    
    if(isset($_GET['cardid']))
    {
        $cardid = $_GET['cardid'];
        
        if(!$sql = mysql_query("SELECT * FROM lotrtcg_cards_decipher WHERE id ='$cardid';"))
        {
            echo mysql_error();
        }
        $row = mysql_fetch_array($sql);

        analyze_new_card($row);
    }
    
    
    
    


?>

    
    
    
    
    </BODY>
</HTML>
