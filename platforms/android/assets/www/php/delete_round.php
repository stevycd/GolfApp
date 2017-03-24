<!-- Location: /home/student/x/xqb13173/DEVWEB/2015/Project/php/delete_round.php -->
<?php      
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $RID = mysql_real_escape_string($_POST['RID']);
    $Email =  mysql_real_escape_string($_POST['email']);
    $UID = get_UID($Email);
   
    delete_round($RID, $UID);
    
    function get_UID($Email) {
        $Result = mysql_query("SELECT * FROM users WHERE Email='$Email'");
        $row = mysql_fetch_array($Result);
        return $row['UserID'];
    } 
    
    function delete_round($RID, $UID) {
        $Query = "DELETE FROM rounds WHERE RoundID = '$RID' AND UserID = '$UID'";
        $Data = mysql_query($Query);
    }
?>

