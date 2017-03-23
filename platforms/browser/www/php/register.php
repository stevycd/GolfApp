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
    
    $Fullname = mysql_real_escape_string($_POST['fullname']);
    $Email = mysql_real_escape_string($_POST['email']);
    $Password = mysql_real_escape_string($_POST['password']);
    
    add_user($Fullname, $Email, better_crypt($Password));
    
    function add_user($Fullname, $Email, $Password) {
        $Email_Query_Result = mysql_query("SELECT * FROM users WHERE Email = '$Email' LIMIT 1");
	if(mysql_fetch_array($Email_Query_Result)) {
            echo "error";
	} else {
            $Query = "INSERT INTO users (FullName, Email, Password Following) VALUES ('$Fullname', '$Email', '$Password', NULL)";
            $Data = mysql_query ($Query) or die(mysql_error());
            if($Data) { echo "success"; }
        }
    }
   
    //function which creates a salted crypt to be saved to keep the password secure
    function better_crypt($input, $rounds = 7) {
	$salt = "";
	$salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
	for($i=0; $i < 22; $i++) {
	  $salt .= $salt_chars[array_rand($salt_chars)];
	}
	return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
    }
?>