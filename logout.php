<?php
    session_start();
    $lastpage = $_SESSION['currentpage'];
    session_destroy();
    
    $_SESSION['currentpage'] = $lastpage;

    header ("Location: $lastpage");
?>
