<!-- Location: /home/student/x/xqb13173/DEVWEB/2015/Project/php/remove_follow.php -->
<?php 
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Email = mysql_real_escape_string($_POST['email']);
    $Follow =  mysql_real_escape_string($_POST['follow']);
    remove_follow($Email, $Follow);  

    function remove_follow($Email, $Follow) {
        $Result = mysql_query("SELECT * FROM users WHERE Email = '$Email'");
        $row = mysql_fetch_array($Result);

        $Array = str_getcsv($row['Following'], $delimiter = ',');
        if (($key = array_search($Follow, $Array)) !== false) {
            unset($Array[$key]);
        }
        $Following = implode(',', $Array);
        
        $Query = "UPDATE users SET Following = '$Following' WHERE Email = '$Email'";
        $Data = mysql_query($Query);
        if($Data) { 
            echo json_encode($Array); 
        }
        else { echo $Data; }
    }
?>
