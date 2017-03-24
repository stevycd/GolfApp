<!-- Location: /home/student/x/xqb13173/DEVWEB/2015/Project/php/delete_account.php -->
<?php    
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Email = mysql_real_escape_string($_POST['email']);
    $UID = get_UID($Email);
    delete_account($Email, $UID);  
    
    function get_UID($Email) {
        $Query = mysql_query("SELECT * FROM users WHERE Email = '$Email'");
        $row = mysql_fetch_array($Query);
        return $row['UserID'];
    }
    
    function delete_account($Email, $UID) {
        $Query1 = "DELETE FROM users WHERE Email = '$Email'";
        $Result1 = mysql_query($Query1);
        if($Result1) {
            $Query2 = "DELETE FROM rounds WHERE UserID = '$UID'";
            $Result2 = mysql_query($Query2);
            if($Result2) {
                echo "success";
            } else { 
                echo $Result2;
            } 
        } else { 
            echo $Result1;
        } 
    }
?>
