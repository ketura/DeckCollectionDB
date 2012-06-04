<?php
include("card_info.php");

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

class Cost
{
    public $type = "";
    public $body = "";

    public static $cost_markers = array('^bearer must be', '^to play,');

    public static function iscost($sentence)
    {
        foreach(Cost::$cost_markers as $token)
        {
            if(preg_match("/$token/", $sentence))
            {
                return true;
            }
        }
        return false;
    }

    public function setcost($sentence)
    {
        foreach(Cost::$cost_markers as $token)
        {
            if(preg_match("/$token*/", $sentence))
            {
                $this->type = $token;

                $pos = strpos($sentence, $token);
                $this->body = substr($sentence, $pos + strlen($token));
                echo("COST FOUND: $token; THE REQUIREMENT IS: ".$this->body.".<br>");
                return true;
            }
        }

        return false;
    }
}

class WhileEffect
{
    public $type = "";
    public $header = "";
    public $body = "";

    public static $while_markers = array('^while', '^if bearer is');

    public static function iswhile($sentence)
    {
        foreach(WhileEffect::$while_markers as $token)
        {
            //echo("token: $token<br>");

            if(preg_match("/$token/", $sentence))
            {
                return true;
            }
        }
        return false;
    }

    public function setwhile($sentence)
    {
        foreach(WhileEffect::$while_markers as $token)
        {
            echo("token: $token");
            if(preg_match("/$token/", $sentence))
            {
                $this->type = $token;

                $pos = strpos($sentence, $token);
                $comma = strlen($sentence)-strpos($sentence, ",");
                $this->header = substr($sentence, $pos + strlen($token), $comma);
                $this->body = substr($sentence, $comma);
                echo("WHILE EFFECT FOUND: $token; CONDITION: ".$this->cost." IS TRUE, EFFECT: ".$this->body." IS IN FORCE.<br>");
                return true;
            }
        }

        return false;
    }
}

class WhenEffect
{
    public $type = "";
    public $header = "";
    public $body = "";

    public static $when_markers = array('^when', 'twilight cost.*is');

    public static function iswhen($sentence)
    {
        foreach(WhenEffect::$when_markers as $token)
        {
            if(preg_match("/$token/", $sentence))
            {
                return true;
            }
        }
        return false;
    }

    public function setwhen($sentence, $title)
    {
        foreach(WhenEffect::$when_markers as $token)
        {
            if(preg_match("/$token/", $sentence))
            {
                $this->type = $token;

                $pos = strpos($sentence, $token);
                $comma = strlen($sentence)-strpos($sentence, ",");
                $this->header = substr($sentence, $pos + strlen($token), $comma);
                $this->body = substr($sentence, $comma);
                echo("WHEN EFFECT FOUND: $token; CONDITION: ".$this->cost." HAPPENS: ".$this->body." FOLLOWS.<br>");
                return true;
            }
        }

        return false;
    }
}

class EachEffect
{
    public $type = "";
    public $header = "";
    public $body = "";

    public static $each_markers = array('^for each', '[^for ]each', '^at the start');

    public static function iseach($sentence)
    {
        foreach(EachEffect::$each_markers as $token)
        {
            if(preg_match("/$token/", $sentence))
            {
                return true;
            }
        }
        return false;
    }

    public function seteach($sentence, $cost = "")
    {
        foreach(EachEffect::$each_markers as $token)
        {
            if(preg_match("/$token/", $sentence))
            {
                $this->type = $token;

                $pos = strpos($sentence, $token);
                $comma = strlen($sentence)-strpos($sentence, ",");
                $this->header = substr($sentence, $pos + strlen($token), $comma);
                $this->body = substr($sentence, $comma);
                echo("FOR EACH EFFECT FOUND: $token; CONDITION: ".$this->cost.", EFFECT: ".$this->body." IS IN FORCE, LIMIT: $limit.<br>");
                return true;
            }
        }

        return false;
    }
}

class Action
{
    public $type = "";
    public $header = "";
    public $body = "";

    public static $action_markers = array("^fellowship:", "^shadow:", "^maneuver:", "^archery:", "^assignment:",
                                          "^skirmish:", "^regroup:", "^response:");

    public static function isaction($sentence)
    {
        foreach(Action::$action_markers as $token)
        {
            if(preg_match("/$token/", $sentence))
            {
                return true;
            }
        }
        return false;
    }

    public function setaction($sentence)
    {
        foreach(Action::$action_markers as $token)
        {
            if(preg_match("/$token/", $sentence))
            {
                $this->type = $token;

                $pos = strpos($sentence, $token);
                $comma = strlen($sentence)-strpos($sentence, ",");
                $this->header = substr($sentence, $pos + strlen($token), $comma);
                $this->body = substr($sentence, $comma);
                echo("ACTION FOUND: $token; COST: ".$this->cost." EFFECT: ".$this->body."<br>");
                return true;
            }
        }

        return false;
    }
}

function analyze_new_card($card)
{
    function isnoun($word)
    {
        if(empty($nouns))
        {
            $sql = mysql_query("SELECT word FROM nouns;");

            while($row = mysql_fetch_array($sql))
            {
                $nouns[] = $row['word'];
            }
        }

        return(in_array($word, $nouns));
    }

    function isnounphrase($phrase)
    {
        if(isnoun($phrase[0]))
        {
            return true;
        }
        else
        {
            while($phrase.next())
            {
                if(isnoun($phrase.current()))
                {
                    return true;
                }
                else if(!isadjective($phrase.current()))
                {
                    return false;
                }
            }
            return false;
        }
    }

    function isverb($word)
    {
        if(empty($verbs))
        {
            $sql = mysql_query("SELECT word FROM verbs;");

            while($row = mysql_fetch_array($sql))
            {
                $verbs[] = $row['word'];
            }
        }

        return(in_array($word, $verbs));
    }

    function isverbphrase($phrase)
    {
        if(isverb($phrase[0]))
        {
            return true;
        }
        else
        {
            while($phrase.next())
            {
                if(isverb($phrase.current()))
                {
                    return true;
                }
                else if(!isadjective($phrase.current()))
                {
                    return false;
                }
            }
            return false;
        }
    }

    function isadjective($word)
    {
        if(empty($adjectives))
        {
            $sql = mysql_query("SELECT word FROM adjectives;");

            while($row = mysql_fetch_array($sql))
            {
                $adjectives[] = $row['word'];
            }
        }

        return(in_array($word, $adjectives));
    }

    function ismarker($word)
    {
        if(empty($markers))
        {
            $sql = mysql_query("SELECT word FROM markers;");

            while($row = mysql_fetch_array($sql))
            {
                $markers[] = $row['word'];
            }
        }

        return(in_array($word, $markers));
    }



    global $card_types;

    $cid = $card['id'];
    $title = $card['title'];
    $cardtype = $card['card_type'];
    $gametext = $card['game_text'];

    $keywords = array();
    $costs = array();
    $when_effects = array();
    $each_time_effects = array();
    $while_effects = array();
    $actions = array();
    $passives = array();

    $nouns = array();
    $verbs = array();
    $adjectives = array();
    $markers = array();


    $primary_while_markers = array("while");
    $secondary_while_markers = array("skip");

    $sentences = explode(".", $gametext);
    $info_type = array();

    for($i = 0; $i < count($sentences); ++$i) #each($sentences as &$sentence)
    {
        echo("<br>");
        $sentences[$i] = strtolower($sentences[$i]);
    }

    for($i = 0; $i < count($sentences); ++$i)
    {
        if(trim($sentences[$i]) == "")
        {
            unset($sentences[$i]);
        }
        elseif(iskeyword(trim($sentences[$i])))
        {
            $info_type[$i] = "keyword";
        }

        elseif(Cost::iscost(trim($sentences[$i])))
        {
            $info_type[$i] = "cost";
        }

        elseif(WhileEffect::iswhile(trim($sentences[$i])))
        {
            $info_type[$i] = "while";
        }

        elseif(WhenEffect::iswhen(trim($sentences[$i])))
        {
            $info_type[$i] = "when";
        }

        elseif(EachEffect::iseach(trim($sentences[$i])))
        {
            $info_type[$i] = "each";
        }

        elseif(Action::isaction(trim($sentences[$i])))
        {
            $info_type[$i] = "action";
        }
        else
        {
            if($i > 0)
            {
                if($info_type[$i-1] == "cost" and preg_match("/\b(he|it|she)\b is.*/", $sentences[$i]))
                {
                    $info_type[$i] = "while";
                }
                if($info_type[$i-1] == "action")
                {
                    $sentences[$i-1] = $sentences[$i-1]." ".$sentences[$i].".";
                    echo("APPENDING:".$sentences[$i]);
                    unset($sentences[$i]);
                }
                else
                {
                    $info_type[$i] = "passive";
                }
            }
            else
            {
                $info_type[$i] = "passive";
            }
        }
        if(array_key_exists($i, $info_type))
        {
            echo(strtoupper($info_type[$i]).": ".$sentences[$i]."<br>");
        }
    }

    echo("<br><br>");

    for($i = 0; $i < count($sentences); ++$i)
    {
        if($sentences[$i] == 0)
        {
            //do nothing, it's being handled in another sentence index
        }

        //Search for keywords
        elseif($info_type[$i] == "keyword")
        {
            $keywords[]=$sentences[$i];
        }

        //Search for costs.
        elseif($info_type[$i] == "cost")
        {
            $costs[]=$sentences[$i];
        }

        //'When' effects
        elseif($info_type[$i] == "when")
        {
            $when_effects[]=$sentences[$i];
        }

        //'Each time' effects
        elseif($info_type[$i] == "each")
        {
            $each_time_effects[]=$sentences[$i];
        }

        //'While' effects
        elseif($info_type[$i] == "while")
        {
            $while_effects[]=$sentences[$i];
        }

        //Actions
        elseif($info_type[$i] == "action")
        {
            $actions[]=$sentences[$i];
        }

        //Fringe cases
        elseif($info_type[$i] == "passive")
        {
            $passives[]=$sentences[$i];
        }

        echo(":".$sentences[$i]."<br>");

    }

}

/*
Six broad categories of devices to be identified through analysis:

1- Passive keywords (loaded/unloaded keywords, etc)
    a- Permanent
    b- Conditional on the below

2- Costs (bearer must be, etc.)
    - "Bearer must be"

3- 'When' effects (one-time)
    a- Cost
    b- Effect
    c- Optional/Required

4- 'Each Time' effects (recurring, "At the start")
    a- Cost
    b- Effect
    c- Optional/Required

5- 'While' effects (continuous)
    a- Cost
    b- Effect
    c- Optional/Required

6- Actions (at-will)
    a- Phase/Response
    b- Cost
    c- Effect

~ Costs precede the word "to" and are followed by Effects
~ All Events are optional, as are abilities
~ Discard from play, as opposed to other locations

PASSIVE KEYWORDS:

==UNLOADED==
Battleground
Besieger
Corsair
Dwelling
Easterling
Engine
Forest
Fortification
Knight
Machine
Marsh
Mountain
Plains
Pipeweed
Ranger
Ring-bound
River
Search
Southron
Spell
Stealth
Tale
Tentacle
Tracker
Twilight
Valiant
Villager
Underground
Warg-rider
Balrog
Creature
Dwarf
Elf
Ent
Half-Troll
Hobbit
Maia
Man
Nazgul
Orc
Spider
Tree
Troll
Uruk-hai
Wizard
Wraith
[Dunland]
[Dwarf]
[Elf]
[Gandalf]
[Gollum]
[Gondor]
[Isengard]
[Men]
[Moria]
[Orc]
[Ringwraith]
[Rohan]
[Sauron]
[Shire]
[Uruk-hai]
==LOADED==
Armor
Brooch
Box
Cloak
Gauntlets
Hand Weapon
Helm
Mount
Palantír
Phial
Pipe
Ranged Weapon
Ring
Shield
Site
Staff
Support Area
Aid
Archer
Enduring
Fierce
Lurker
Muster
Sanctuary
Ring-bearer
Unhasty
Damage
Defender
Ambush
Hunter
Toil


*/

?>


