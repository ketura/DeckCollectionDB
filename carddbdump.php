<?php
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
    
    $dbcx = @mysql_connect("localhost", "root", "");
    if(!$dbcx)
    {
        echo("<p>Unable to connect to the Card Database server at this time.</p>");
        
        exit('Failed to connect to LotR-TCG-CDB');
    }
    
    if(!@mysql_select_db("LotR-TCG", $dbcx))
    {
        echo("<p>Unable to locate the lotrtcg_cards_decipher table at this time.</p>");
        exit();
    }
    
    foreach($carddoc->card as $currentCard)
    {
        echo $currentCard['id'];
        echo '<br>';
    }
?>
