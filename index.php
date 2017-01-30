<?php
    //Start the session
    session_start();  
    //Connect to the database
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
					
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
				
    $result = mysql_query("SELECT * FROM courses WHERE HID=1");
//    $row = mysql_fetch_array($result);
?> 

<!DOCTYPE HTML>

<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
        <link rel="shortcut icon" href="img/favicon-16x16.png"/>
        <link rel="apple-touch-icon" href="img/apple-icon-76x76.png"/>
        <link href='//fonts.googleapis.com/css?family=Coda' rel='stylesheet'>
        <link rel="stylesheet" href="css/index.css"/> 
        <title>Golf App</title>
    </head>
    <style>
        
    </style>
    <body background="img/background.jpg">
        <h1 align="center">Golf App</h1>
        <nav class="nav">
            <ul>
                <li class="play_golf">
                    <a id="play_golf_btn">
                        <span class="icon"><i aria-hidden="true" class="icon-golf"></i></span><span>Play Golf</span>
                    </a>
                </li>
                <p id="selector" class="selector">
                    <select id="course_select" class="course_select">
                        <option value="" disabled selected>Select a Course</option>
                    </select>
                </p>
                <li class="prev_rounds">
                    <a id="prev_rounds_btn" href="account_out.php">
                        <span class="icon"><i aria-hidden="true" class="icon-folder-open"></i></span><span>Previous Rounds</span>
                    </a>
                </li>
                <li class="statistics">
                    <a id="statistics_btn" href="account_out.php">
                        <span class="icon"><i aria-hidden="true" class="icon-stats-dots"></i></span><span>Statistics</span>
                    </a>
                </li>
                <li class="account">
                    <a id="account_btn" href="account_out.php">
                        <span class="icon"><i aria-hidden="true" class="icon-wrench"></i></span><span>Account</span>
                    </a>
                </li>
                <p id="log_msg" class="log_msg"></p>
            </ul>
        </nav>
    </body>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
        var create_course_slt = function () {
            var course_slt = document.getElementById('course_select');
            <?php 
                while($row = mysql_fetch_array($result)) {
                    echo "var o = document.createElement('option');\n";
                    echo "o.text = \"" . $row['Course_Name'] . "\";\n";
                    echo "o.value = \"" . $row['Course_Name'] . "\";\n";
                    echo "course_slt.add(o);\n";
                }
            ?>
        };
        
        $(document).ready(function() {
            <?php if (isset($_SESSION['UserName'])) { ?>
                create_course_slt();       
                
                document.getElementById('prev_rounds_btn').href = "#";
                document.getElementById('statistics_btn').href = "#";
                document.getElementById('account_btn').href = "account_in.php";
                document.getElementById('log_msg').style.display = "block";
                document.getElementById('log_msg').innerHTML = "Logged in as: "+"<?php echo $_SESSION['FullName']?>"; 
                
                document.getElementById('play_golf_btn').onclick = function () {
                    var select = document.getElementById('selector');
                    select.style.display = select.style.display === "block" ? "none" : "block";
                };
                
                document.getElementById('course_select').onchange = function() {
                    var course_slt = document.getElementById('course_select'),
                        course = course_slt.options[course_slt.selectedIndex].value;
                    $.post("php/get_cid.php", { Course: course },  
                    function(result) {  
                        window.location = "map.php?cid="+result+"&hid=1";
                    });  
                }; 
            <?php } else { ?> 
                document.getElementById('play_golf_btn').href = "account_out.php";
            <?php } ?>
        });
    </script>
</html>