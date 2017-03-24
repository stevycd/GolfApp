<!-- Location: /home/student/x/xqb13173/DEVWEB/2015/Project/php/get_cid.php -->
<?php      
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Course =  mysql_real_escape_string($_POST['Course']);
    return_CID($Course);  
    
    function return_CID($Course) {
        $Data = mysql_query("SELECT * FROM courses WHERE CourseName = '$Course'");
        $row = mysql_fetch_array($Data);
        echo $row['CourseID'];
    }
?>

