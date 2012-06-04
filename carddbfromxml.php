
<?php
    include("users.php");
    if(isset($_SESSION['username']))
    {
        if($_SESSION['username'] != $admin)
        {
            die("You are not authorized to run that command.");
        }
    }
    else
    {
        die("You must be logged in to run that.");
    }
    
    
    $cardxml = 'carddata.xml';
    if(file_exists($cardxml))
    {
        $carddoc = simplexml_load_file($cardxml);
    }
    else
    {
        echo("<p>Unable to open the card data xml at this time.</p>");
        exit('Failed to open card data xml');
    }
    
    
    echo("<p>DROPPING CURRENT DATA...</p>");
    
    mysql_query("DELETE FROM lotrtcg_cards_decipher");
    echo("...complete.");
    
    echo("<p>BEGIN XML TO SQL CARD DUMP:<p><br>");
    
    $error = false;
    
    foreach($carddoc->card as $ccard)
    {
        $id = $ccard['id'];
        $collinfo = $ccard['collectors_info'];
        $title =  mysql_real_escape_string($ccard['title']);
        $subtitle =  mysql_real_escape_string($ccard['subtitle']);
        
        if($subtitle == "")
        {
            $cardname = $title;
        }
        else
        {
            $cardname = "$title, $subtitle";
        }
        
        $image = $ccard['image'];
        $side = $ccard['side'];
        $culture = $ccard['culture'];
        $cardtype = $ccard['card_type'];
        $twilight = $ccard['twilight'];
        $str = $ccard['str'];
        $vit = $ccard['vit'];
        $res = $ccard['res'];
        $signet = $ccard['signet'];
        $sitenum = $ccard['site_number'];
        $arrowdir = $ccard['arrow_dir'];
        $unique = $ccard['unique'];
        $set = $ccard['set'];
        $rarity = $ccard['rarity'];
        $number = $ccard['number'];
        $notes = mysql_real_escape_string($ccard['notes']);
        $lore = mysql_real_escape_string($ccard['lore']);
        $gametext = mysql_real_escape_string($ccard['game_text']);
        
        echo("<p>PROCESSING CARD: $id: $title, $subtitle ($collinfo)...");
        echo('<br>');
        
        
        $sql="INSERT INTO lotrtcg_cards_decipher SET " .
        "id=$id, " .
        "collectors_info='$collinfo', " .
        "card_name='$cardname', " .
        "title='$title', " .
        "subtitle='$subtitle', " .
        "image='$image', " .
        "side=$side, " .
        "culture=$culture, " .
        "card_type=$cardtype, " .
        "twilight=$twilight, " .
        "strength=$str, " .
        "vitality=$vit, " .
        "resistance=$res, " .
        "signet='$signet', " .
        "site_number=$sitenum, " .
        "arrow_dir=$arrowdir, " .
        "uniqueness=$unique, " .
        "set_number=$set, " .
        "rarity='$rarity', " .
        "number=$number, " .
        "notes='$notes', " .
        "lore='$lore', " .
        "game_text='$gametext';";
        
        
        if(mysql_query($sql))
        {
            echo('<p><FONT COLOR="00FF00">...TRANSFER COMPLETE</FONT>');
        }
        else
        {
            $error = true;
            echo('<p><FONT COLOR="FF0000">ERROR PERFORMING INSERT: </FONT>' .
            mysql_error() .'</p>');
            echo("id: $id, collinfo: $collinfo, cardname: $cardname, title: $title, subtitle: $subtitle, image: $image, " .
            "side: $side, culture: $culture, cardtype: $cardtype twilight: $twilight, str: $str, vit: $vit, res: $res, " .
            "signet: $signet, sitenum: $sitenum, arrowdir: $arrowdir, unique: $unique, set: $set, rarity: $rarity, " .
            "number: $number, notes: $notes, lore: $lore, gametext: $gametext");
            echo('<br>');
            echo('<br>');
        }
    }
    
    if(!$error)
    {
        header ("Location: ".$_POST['page']);
    }
    
?>

