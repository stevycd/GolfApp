<?php
    //start the session
    session_start();
        
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    //Connect to the database
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Email = mysql_real_escape_string($_SESSION['UserName']);
    delete_account($Email);  
    
    function delete_account($Email) {
        $Query = "DELETE FROM userAccounts WHERE Email = '$Email'";
        $Data = mysql_query($Query);
        
        if($Data) { 
            //destroy the session logging out the user
            session_destroy();
            echo 1; // Success
        } else { 
            echo $Data; // Failure
        } 
    }
?>
