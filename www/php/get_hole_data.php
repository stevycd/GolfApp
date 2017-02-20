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
    
    $CID =  mysql_real_escape_string($_POST['CID']);
    $HID =  mysql_real_escape_string($_POST['HID']);
    return_Hole_Data($CID, $HID);  
    
    function return_Hole_Data($CID, $HID) {		
        $Data = mysql_query("SELECT * FROM holes WHERE CID='$CID' AND HID='$HID'");
        echo json_encode(mysql_fetch_array($Data));
    }
?>

