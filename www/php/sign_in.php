<?php 
    header("Access-Control-Allow-Origin: *");
    session_start();

    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    //Connect to the database
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Email = mysql_real_escape_string($_POST['email']);
    $Password = mysql_real_escape_string($_POST['password']);
    
    sign_in($Email, $Password);
    
    function sign_in($Email, $Password) {
        $query = mysql_query("SELECT * FROM users WHERE Email = '$Email'");
        $row = mysql_fetch_array($query);
        
        if(!empty($row['Email']) || !empty($row['Password'])) { 
            $Stored_Pass = $row['Password'];
            $Entered_Pass = crypt($Password, $Stored_Pass);
            
            if(strcmp($Stored_Pass, $Entered_Pass) == 0) {                
                $_SESSION['UserName'] = $Email;
                $_SESSION['FullName'] = $row['FullName'];
                echo "success";
            } else {
                echo "error";
            }
        } 
    }
?>