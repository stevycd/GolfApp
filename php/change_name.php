<?php
    session_start();

    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    //Connect to the database
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Fullname = mysql_real_escape_string($_POST['fullname']);
    $Email = mysql_real_escape_string($_SESSION['UserName']);
  
    change_name($Fullname, $Email);
    
    function change_name($Fullname, $Email) {
        $Query = "UPDATE userAccounts SET FullName = '$Fullname' WHERE Email = '$Email'";
        $Data = mysql_query($Query);
        if($Data) { echo 1; } // Success
        else { echo $Data; } // Failure
    }
?>