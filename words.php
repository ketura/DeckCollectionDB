<?php
include("users.php");
$verbs = array("spot", "discard", "exert", "make", "play", "add", "remove", "draw", "wound", "start", "heal", "prevent", 
                "place", "move", "reveal", "take", "control", "transfer", "stack", "assign", "end", "return", "cancel", "reinforce", 
                "choose", "resolve", "replace", "liberate", "shuffle", "overwhelm", "kill", "gain", "lose", "wear", "use", "look", 
                "skip", "reconcile", "participate", "corrupt", "name");

$nouns = array("opponent", "this", "you", "card", "cards", "hand", "hands", "cost", "costs", "player", "players", "support area", 
                "support areas", "phase", "phases", "deck", "decks", "resistance", "discard pile", "x", "burden", "burdens", "bearer", 
                "strength", "fellowship", "starting fellowship", "twilight pool", "tokens", "token", "threat", "threats", "ring-bearer", 
                "site number", "archery total", "total", "wound", "wounds", "region", "regions", "initiative", "culture", "cultures", 
                "turn", "turns", "special ability", "dead pile", "adventure path", "ambush", "bonus", "damage bonus", "damage bonuses", 
                "strength bonus", "strength bonuses", "bonuses", "signet", "signets", "bottom", "game text", "text", "home site", "vitality", 
                "roaming penalty", "archery fire", "action", "owner", "[1]", "[2]", "[3]", "[4]", "[5]", "[6]", "[7]", "[8]", "[9]", "[X]", 
                "companion", "companions", "minion", "minions", "condition", "conditions", "site", "sites", "possession", "possessions", 
                "character", "characters", "ally", "allies", "follower", "followers", "event", "events", "artifact", "artifacts", "damage", 
                "damage+", "man", "men", "orc", "orcs", "hobbit", "hobbits", "dwarf", "dwarves", "nazgul", "archer", "archers", "ranger", 
                "rangers", "uruk-hai", "lurker", "lurkers", "southron", "southrons", "battleground", "battleground site", "forest", 
                "forest site", "spell", "spells", "underground", "underground site", "weapon", "weapons", "hand weapon", "hand weapons", 
                "ranged weapon", "ranged weapons","tale", "tales", "sanctuary", "tracker", "trackers", "knight", "knights", "ring", "rings", 
                "wizard", "wizards",  "besieger", "river", "river site", "easterling", "easterlings", "ent", "ents", "fortification", 
                "fortifications", "mount", "mounts", "elf", "elves", "pipeweed", "mountain", "mountain site", "marsh", "dwelling", "corsair", 
                "wraith", "troll", "warg-rider", "machine", "roaming", "weather", "pipe", "pipes", "shield", "shields", "staff", 
                "staves", "tentacle", "tentacles", "gandalf", "gollum", "smeagol", "aragorn", "frodo", "theoden", "gimli", "sam", "saruman", 
                "eomer", "faramir", "legolas", "arwen", "eowyn", "the balrog", "merry", "boromir", "pippin", "ulaire attea", "ulaire cantea", 
                "ulaire lemenya", "ulaire otsea", "ulaire toldea", "witch-king", "grima",  "treebeard", "bilbo",  "denethor", "lurtz", 
                "galadriel", "elrond", "haldir", "isildur", "sauron",  "bill ferny", "erkenbrand", "elendil", "grimbeorn", "gamling", "hama", 
                "madril", "goldberry", "sharku", "celeborn", "skinbark", "gorbag", "farmer maggot", "tom bombadil", "barliman butterbur", 
                "quickbeam", "gil-galad", "grishnakh", "watcher", "watcher in the water", "elladan", "elrohir");


$adjectives = array("twilight", "your", "free", "free peoples", "[gondor]", "rohan", "regroup", "skirmish", "fierce", "[sauron]", "shadow", 
                "another", "[men]", "[orc]", "unbound", "involving", "archery", "during", "hunter", "[elven]", "[isengard]", "top", "[wraith]",
                 "[gandalf]", "elf", "assigned", "[uruk-hai]", "[dwarven]", "[raider]", "[shire]", "stacked", "[moria]", "ring-bound", 
                 "maneuver", "non-hunter", "roaming", "bourne", "[gollum]", "[dunland]", "valiant", "mounted", 
                 "plains", "current", "enduring", "overwhelmed", "wounded", "at random", "random", "killed", "search", "beneath", "exhausted", 
                 "less", "wearing", "stealth", "assignment", "unwounded", "unhasty", "in addition", "[ringwraith]", "unable",
                 "support", "ulaire", "battleground", "forest", "underground", "hand", "ranged", "special", "dead", "adventure", "strength", 
                 "damage", "game");

$markers = array("to", "each", "may", "or", "if", "while", "skirmish:", "can", "for", "when", "regroup:", "maneuver:", "until", "fellowship:",
                "response:", "shadow:", "about", "limit", "assignment:", "archery:", "where");


foreach($verbs as $word)
{
    if(!$sql = mysql_query("INSERT INTO verbs SET word = '$word';"))
    {
        echo("Failed to insert word $word.");
        echo(mysql_error()."<br><br>");
    }
}

foreach($nouns as $word)
{
    if(!$sql = mysql_query("INSERT INTO nouns SET word = '$word';"))
    {
        echo("Failed to insert word $word.");
        echo(mysql_error()."<br><br>");
    }
}

foreach($adjectives as $word)
{
    if(!$sql = mysql_query("INSERT INTO adjectives SET word = '$word';"))
    {
        echo("Failed to insert word $word.");
        echo(mysql_error()."<br><br>");
    }
}

foreach($markers as $word)
{
    if(!$sql = mysql_query("INSERT INTO markers SET word = '$word';"))
    {
        echo("Failed to insert word $word.");
        echo(mysql_error()."<br><br>");
    }
}
?>

<br><br><a href="/main.php">Return to the Main Page.</a>
