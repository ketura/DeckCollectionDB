<?php
include("users.php");


$all_keywords = array("battleground", "besieger", "corsair", "dwelling", "easterling", "engine", "forest", "fortification", "knight",
                            "machine", "marsh", "mountain", "plains", "pipeweed", "ranger", "ring-bound", "search", "southron", "spell", 
                            "stealth", "tale", "tentacle", "tracker", "twilight", "valiant", "villager", "underground", "warg-rider", 
                            "balrog", "dwarf", "elf", "ent", "half-troll", "hobbit", "maia", "orc", "spider", "tree", "troll", "uruk-hai", 
                            "wizard", "wraith", "[dunland]", "[dwarf]", "[elf]", "[gandalf]", "[gollum]", "[gondor]", "[isengard]", "[men]", 
                            "[moria]", "[orc]", "[ringwraith]", "[rohan]", "[sauron]", "[shire]", "[uruk-hai]", "armor", "brooch", "box", 
                            "cloak", "gauntlets", "hand weapon", "helm", "mount", "palantir", "phial", "pipe", "ranged weapon", "ring", 
                            "shield", "site", "staff", "support area", "aid", "archer", "enduring", "fierce", "lurker", "muster", "sanctuary", 
                            "ring-bearer", "unhasty", "damage","defender", "ambush", "hunter", "toil"); 
                            
$unloaded_keywords = array("battleground", "besieger", "corsair", "dwelling", "easterling", "engine", "forest", "fortification", "knight", 
                            "machine", "marsh", "mountain", "plains", "pipeweed", "ranger", "ring-bound", "search", "southron", "spell", 
                            "stealth", "tale", "tentacle", "tracker", "twilight", "valiant", "villager", "underground", "warg-rider", "balrog", 
                            "dwarf", "elf", "ent", "half-troll", "hobbit", "maia", "orc", "spider", "tree", "troll", "uruk-hai", "wizard", "wraith", 
                            "[dunland]", "[dwarf]", "[elf]", "[gandalf]", "[gollum]", "[gondor]", "[isengard]", "[men]", "[moria]", "[orc]", 
                            "[ringwraith]", "[rohan]", "[sauron]", "[shire]", "[uruk-hai]"); 
                            
$race_keywords = array("balrog", "dwarf", "elf", "ent", "half-troll", "hobbit", "maia", "orc", "spider", "tree", "troll", "uruk-hai", 
                            "wizard", "wraith"); 
                            
$culture_keywords = array("[dunland]", "[dwarf]", "[elf]", "[gandalf]", "[gollum]", "[gondor]", "[isengard]", "[men]", "[moria]", 
                            "[orc]", "[ringwraith]", "[rohan]", "[sauron]", "[shire]", "[uruk-hai]"); 
                            
$loaded_keywords = array("armor", "brooch", "box", "cloak", "gauntlets", "hand weapon", "helm", "mount", "palantir", "phial", "pipe", 
                            "ranged weapon", "ring", "shield", "site", "staff", "support area", "aid", "archer", "enduring", "fierce", "lurker", 
                            "muster", "sanctuary", "ring-bearer", "unhasty", "damage", "defender", "ambush", "hunter", "toil"); 
                            
$item_keywords = array("armor", "brooch", "box", "cloak", "gauntlets", "hand weapon", "helm", "mount", "palantir", "phial", "pipe", 
                            "ranged weapon", "ring", "shield", "site", "staff", "support area"); 
                            
$nonnumeric_loaded_keywords = array("aid", "archer", "enduring", "fierce", "lurker", "muster", "sanctuary", "ring-bearer", "unhasty"); 

$numeric_loaded_keywords = array("damage", "defender", "ambush", "hunter", "toil");

mysql_query("DELETE FROM all_keywords");
foreach($all_keywords as $keyword)
{
    if(!$sql = mysql_query("INSERT INTO all_keywords SET keyword = '$keyword';"))
    {
        echo("Failed to insert keyword $keyword.");
        echo(mysql_error()."<br><br>");
    }
}

mysql_query("DELETE FROM unloaded_keywords");
foreach($unloaded_keywords as $keyword)
{
    if(!$sql = mysql_query("INSERT INTO unloaded_keywords SET keyword = '$keyword';"))
    {
        echo("Failed to insert keyword $keyword.");
        echo(mysql_error()."<br><br>");
    }
}

mysql_query("DELETE FROM race_keywords");
foreach($race_keywords as $keyword)
{
    if(!$sql = mysql_query("INSERT INTO race_keywords SET keyword = '$keyword';"))
    {
        echo("Failed to insert keyword $keyword.");
        echo(mysql_error()."<br><br>");
    }
}

mysql_query("DELETE FROM culture_keywords");
foreach($culture_keywords as $keyword)
{
    if(!$sql = mysql_query("INSERT INTO culture_keywords SET keyword = '$keyword';"))
    {
        echo("Failed to insert keyword $keyword.");
        echo(mysql_error()."<br><br>");
    }
}

mysql_query("DELETE FROM loaded_keywords");
foreach($loaded_keywords as $keyword)
{
    if(!$sql = mysql_query("INSERT INTO loaded_keywords SET keyword = '$keyword';"))
    {
        echo("Failed to insert keyword $keyword.");
        echo(mysql_error()."<br><br>");
    }
}

mysql_query("DELETE FROM item_keywords");
foreach($item_keywords as $keyword)
{
    if(!$sql = mysql_query("INSERT INTO item_keywords SET keyword = '$keyword';"))
    {
        echo("Failed to insert keyword $keyword.");
        echo(mysql_error()."<br><br>");
    }
}

mysql_query("DELETE FROM nonnumeric_loaded_keywords");
foreach($nonnumeric_loaded_keywords as $keyword)
{
    if(!$sql = mysql_query("INSERT INTO nonnumeric_loaded_keywords SET keyword = '$keyword';"))
    {
        echo("Failed to insert keyword $keyword.");
        echo(mysql_error()."<br><br>");
    }
}

mysql_query("DELETE FROM numeric_loaded_keywords");
foreach($numeric_loaded_keywords as $keyword)
{
    if(!$sql = mysql_query("INSERT INTO numeric_loaded_keywords SET keyword = '$keyword';"))
    {
        echo("Failed to insert keyword $keyword.");
        echo(mysql_error()."<br><br>");
    }
}
?>
