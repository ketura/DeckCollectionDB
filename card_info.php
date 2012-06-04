<?php
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


$card_types = array("the one ring" => 1,
                "site" => 2,
                "companion" => 3,
                "ally"  => 4,
                "minion" => 5,
                "event" => 6,
                "artifact"  => 7,
                "possession" => 8,
                "condition" => 9,
                "follower" => 10);
                
$sides = array("free" => 0,
                "freeps" => 0,
                "free peoples" => 0,
                "shadow" => 1,
                "site" => 2,
                "the one ring" => 2);

$cultures = array("the one ring" => 1,
                    "site" => 2,
                    "dwarven" => 3,
                    "elven" => 4,
                    "gandalf" => 5,
                    "gondor" => 6,
                    "isengard" => 7,
                    "moria" => 8,
                    "wraith" => 9,
                    "ringwraith" => 9,
                    "sauron" => 10,
                    "shire" => 11,
                    "dunland" => 12,
                    "rohan" => 13,
                    "gollum" => 14,
                    "men" => 15,
                    "orc" => 16,
                    "uruk-hai"=> 17);
                    
$all_keywords = array();
$unloaded_keywords = array();
$race_keywords = array();
$culture_keywords = array();
$loaded_keywords = array();
$item_keywords = array();
$nonnumeric_loaded_keywords = array();
$numeric_loaded_keywords = array();

function iskeyword($word)
{
    if(empty($all_keywords))
    {
        $sql = mysql_query("SELECT keyword FROM all_keywords;");
            
        while($row = mysql_fetch_array($sql))
        {
            $all_keywords[] = $row['keyword'];
        }
    }
    return(in_array(trim($word), $all_keywords) or isnumerickeyword($word));
}

function isunloadedkeyword($word)
{
    if(empty($unloaded_keywords))
    {
        $sql = mysql_query("SELECT keyword FROM unloaded_keywords;");
            
        while($row = mysql_fetch_array($sql))
        {
            $unloaded_keywords[] = $row['keyword'];
        }
    }
    return(in_array(trim($word), $unloaded_keywords));
}

function isracekeyword($word)
{
    if(empty($race_keywords))
    {
        $sql = mysql_query("SELECT keyword FROM race_keywords;");
            
        while($row = mysql_fetch_array($sql))
        {
            $race_keywords[] = $row['keyword'];
        }
    }
    return(in_array(trim($word), $race_keywords));
}

function isculturekeyword($word)
{
    if(empty($culture_keywords))
    {
        $sql = mysql_query("SELECT keyword FROM culture_keywords;");
            
        while($row = mysql_fetch_array($sql))
        {
            $culture_keywords[] = $row['keyword'];
        }
    }
    return(in_array(trim($word), $culture_keywords));
}

function isloadedkeyword($word)
{
    if(empty($loaded_keywords))
    {
        $sql = mysql_query("SELECT keyword FROM loaded_keywords;");
            
        while($row = mysql_fetch_array($sql))
        {
            $loaded_keywords[] = $row['keyword'];
        }
    }
    return(in_array(trim($word), $loaded_keywords));
}

function isitemkeyword($word)
{
    if(empty($item_keywords))
    {
        $sql = mysql_query("SELECT keyword FROM item_keywords;");
            
        while($row = mysql_fetch_array($sql))
        {
            $item_keywords[] = $row['keyword'];
        }
    }
    return(in_array(trim($word), $item_keywords));
}

function isnonnumerickeyword($word)
{
    if(empty($nonnumeric_keywords))
    {
        $sql = mysql_query("SELECT keyword FROM nonnumeric_keywords;");
            
        while($row = mysql_fetch_array($sql))
        {
            $nonnumeric_keywords[] = $row['keyword'];
        }
    }
    return(in_array(trim($word), $nonnumeric_keywords));
}

function isnumerickeyword($word)
{
    if(empty($numeric_keywords))
    {
        $sql = mysql_query("SELECT keyword FROM numeric_loaded_keywords;");
            
        while($row = mysql_fetch_array($sql))
        {
            $numeric_keywords[] = $row['keyword'];
        }
    }
    if(in_array(trim($word), $numeric_keywords))
    {
        return true;
    }
    else 
    {
        foreach($numeric_keywords as $keyword)
        {
            if(preg_match("/$keyword \+?\[?\d]?/", $word))
            {
                return true;
            }
        }
    }
    
    return false;
}



                           
                            
                
function card_type_number($string)
{
    global $card_types;
                
    return $card_types[strtolower($string)];
}

?>
