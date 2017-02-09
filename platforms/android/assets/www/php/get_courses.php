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
    
    return_Courses();  
    
    function return_Courses() {		
        $Data = mysql_query("SELECT * FROM courses");
        while ($row = mysql_fetch_array($Data)) {
            echo json_encode($row['Course_Name']);
        }
    }
?>