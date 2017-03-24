<!-- Location: /home/student/x/xqb13173/DEVWEB/2015/Project/php/push_round_data.php -->
<?php  
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Email = mysql_real_escape_string($_POST['Email']);
    $UID = get_UID($Email);
    
    $CID = mysql_real_escape_string($_POST['CID']);
    $CourseName = get_course_name($CID);
    
    $Data = mysql_real_escape_string($_POST['Data']);
    $Private = mysql_real_escape_string($_POST['Private']) === 'true' ? 1 : 0;
    push_data($UID, $CourseName, $Data, $Private);  
    
    function get_UID($Email) {
        $Result = mysql_query("SELECT * FROM users WHERE Email='$Email'");
        $row = mysql_fetch_array($Result);
        return $row['UserID'];
    }
    
    function get_course_name($CID) {
        $Result = mysql_query("SELECT * FROM courses WHERE CourseID='$CID'");
        $row = mysql_fetch_array($Result);
        return $row['CourseName'];
    }
    
    function push_data($UID, $CourseName, $Data, $Private) {
        $Date = date("Y/m/d");
        mysql_query("INSERT INTO rounds (UserID, Played, CourseName, RoundData, Private) VALUES ('$UID', '$Date', '$CourseName', '$Data', '$Private')");
    }
?>

