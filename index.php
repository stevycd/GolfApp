<?php
    //Start the session
    session_start();
?> 

<!DOCTYPE HTML>

<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <link href='//fonts.googleapis.com/css?family=Coda' rel='stylesheet'>
        <link rel="stylesheet" href="css/index_style.css"/> 
        <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
        <link rel="shortcut icon" href="img/favicon-16x16.png"/>
        <link rel="apple-touch-icon" href="img/apple-icon-76x76.png"/>
        <title>Golf Caddie</title>
    </head>
    <body background="img/background.jpg">
        <h1 align="center">Golf App</h1>
        <nav class="nav">
            <ul>
                <li class="play_golf">
                    <a href="#">
                        <span class="icon"><i aria-hidden="true" class="icon-golf"></i></span><span>Play Golf</span>
                    </a>
                </li>
                <li class="prev_rounds">
                    <a href="#">
                        <span class="icon"><i aria-hidden="true" class="icon-folder-open"></i></span><span>Previous Rounds</span>
                    </a>
                </li>
                <li class="statistics">
                    <a href="#">
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
        $(document).ready(function() {
            if(<?php echo isset($_SESSION['UserName'])?>) {
                document.getElementById('account_btn').href = "account_in.php";
                document.getElementById('log_msg').style.display = "block";
                document.getElementById('log_msg').innerHTML = "Logged in as: "+"<?php echo $_SESSION['FullName']?>";
            } 
        });
    </script>
</html>