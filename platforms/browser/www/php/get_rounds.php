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
    
    $Email =  mysql_real_escape_string($_POST['email']);
    $UID = get_UID($Email);
    
    return_rounds($UID);
    
    function get_UID($Email) {
        $Result = mysql_query("SELECT * FROM users WHERE Email='$Email'");
        $row = mysql_fetch_array($Result);
        return $row['UserID'];
    }
    
    function return_rounds($UID) {
        $Data = mysql_query("SELECT * FROM rounds WHERE UserID='$UID'");
        
        if(mysql_num_rows($Data) != 0) {
            while($row = mysql_fetch_array($Data)){
                $array[] = $row;
            }
            echo json_encode($array);
        } else {
            echo "error";
        }
    }
?>
