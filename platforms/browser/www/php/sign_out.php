<?php
    //start the session
    session_start();
    //destroy the session logging out the user
    session_destroy();
    //redirect the user to the homepage
    header("Location: https://devweb2015.cis.strath.ac.uk/~xqb13173/Project/index.php");
?>

