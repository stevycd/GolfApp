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
    
    $Email = mysql_real_escape_string($_POST['email']);
    $Follow =  mysql_real_escape_string($_POST['follow']);
    add_follow($Email, $Follow);  

    function add_follow($Email, $Follow) {
        $Result = mysql_query("SELECT * FROM users WHERE Email = '$Email'");
        $row = mysql_fetch_array($Result);
        if($row['Following'] == NULL){
            $Following = json_encode($Follow);
        } else {
            $Following = json_encode($row['Following'] . $Follow);
        }
        $Query = "UPDATE users SET Following = '$Following' WHERE Email = '$Email'";
        $Data = mysql_query($Query);
        if($Data) { 
            echo $Follow; 
        } // Success
        else { echo $Data; } // Failure
    }
?>
?>