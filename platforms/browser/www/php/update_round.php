<!-- Location: /home/student/x/xqb13173/DEVWEB/2015/Project/php/update_round.php -->
<?php         
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $RID = mysql_real_escape_string($_POST['RID']);
    $Data = mysql_real_escape_string($_POST['Data']);
    $Private = mysql_real_escape_string($_POST['Private']) === 'true' ? 1 : 0;
    
    update_data($RID, $Data, $Private);
    
    function update_data($RID, $Data, $Private) {
        mysql_query("UPDATE rounds SET RoundData = '$Data', Private = '$Private' WHERE RoundID = '$RID'");
    }    
?>

