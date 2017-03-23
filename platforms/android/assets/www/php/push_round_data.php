<?php  
    session_start();

    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
    //Connect to the database
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Customer Database: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to Customer Database: " . mysql_error());
    
    $Email = mysql_real_escape_string($_POST['Email']);
    $UID = get_UID($Email);
    
    $CID = mysql_real_escape_string($_POST['CID']);
    $CourseName = get_course_name($CID);
    
    $Data = mysql_real_escape_string($_POST['Data']);
    push_data($UID, $CourseName, $Data);  
    
    function get_UID($Email) {
        $Result = mysql_query("SELECT * FROM users WHERE Email='$Email'");
        $row = mysql_fetch_array($Result);
        return $row['UserID'];
    }
    
    function get_course_name($CID) {
        $Result = mysql_query("SELECT * FROM courses WHERE CID='$CID'");
        $row = mysql_fetch_array($Result);
        return $row['Course_Name'];
    }
    
    function push_data($UID, $CourseName, $Data) {
        $Date = date("Y/m/d");
        mysql_query("INSERT INTO rounds (UserID, Played, Course_Name, Round_Data) VALUES ('$UID', '$Date', '$CourseName', '$Data')");
    }
?>

