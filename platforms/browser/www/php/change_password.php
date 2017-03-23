<?php 
    session_start();

    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    //Connect to the database
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Old_Password = mysql_real_escape_string($_POST['old_password']);
    $New_Password = mysql_real_escape_string($_POST['new_password']);
    $Email = mysql_real_escape_string($_SESSION['UserName']);
  
    change_password($Old_Password, $New_Password, $Email);
    
    function change_password($Old_Password, $New_Password, $Email) {
        $query = mysql_query("SELECT * FROM users WHERE Email = '$Email'");
        $row = mysql_fetch_array($query);
        
        if(!empty($row['Email']) || !empty($row['Password'])) { 
            $Stored_Pass = $row['Password'];
            $Entered_Pass = crypt($Old_Password, $Stored_Pass);
            
            if(strcmp($Stored_Pass, $Entered_Pass) == 0) {
                $New_Crypt_Password = better_crypt($New_Password);
                $Query = "UPDATE users SET Password = '$New_Crypt_Password' WHERE Email = '$Email'";
                $Data = mysql_query($Query);
                if($Data) { echo "success"; } // Success
                else { echo $Data; } // Failure
            }
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