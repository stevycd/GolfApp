<?php
    //Start the session
    session_start();
    //Get Hole ID
    $HID = $_GET['id'];    
    //Connect to the database
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
					
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
				
    $result = mysql_query("SELECT * FROM torranceInfo WHERE HID = '$HID'");
    $row = mysql_fetch_array($result);
?> 

<!DOCTYPE HTML>

<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
        <link rel="shortcut icon" href="img/favicon-16x16.png"/>
        <link rel="apple-touch-icon" href="img/apple-icon-76x76.png"/>
        <title><?php echo $row['Hole_Name'] ?></title>
        <style>
            @font-face {
                font-family: 'icomoon';
                src:  url('css/fonts/map_fonts/icomoon.eot?gfrc43');
                src:  url('css/fonts/map_fonts/icomoon.eot?gfrc43#iefix') format('embedded-opentype'),
                      url('css/fonts/map_fonts/icomoon.ttf?gfrc43') format('truetype'),
                      url('css/fonts/map_fonts/icomoon.woff?gfrc43') format('woff'),
                      url('css/fonts/map_fonts/icomoon.svg?gfrc43#icomoon') format('svg');
                font-weight: normal;
                font-style: normal;
            }

            [class^="icon-"], [class*=" icon-"] {
                font-family: 'icomoon' !important;
                speak: none;
                font-style: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                line-height: 1;
            }

            .icon-compass:before {
                content: "\e949";
            }
            .icon-menu:before {
                content: "\e9bd";
            }
            .icon-arrow-right:before {
                content: "\ea34";
            }
            .icon-arrow-left:before {
                content: "\ea38";
            }
            
            /* Global Styles */
            html * {
                background-repeat: no-repeat;
                background-size: cover;
            }
            
            .nav {
                width: 100%;
                margin-top: 2em;
                margin-bottom: 2em;
            }
            
            .nav a {
                display: inline;
                background: rgba(23, 207, 69, 0.85);
                color: rgba(249, 249, 249, 0.9);
                font-size: 2.5em;
                border: 1px solid white;
                box-sizing: border-box;
            }   

            .nav li {
                display: inline;
                color: rgba(249, 249, 249, 0.9);
                text-decoration: none;
            }  

            .nav ul {
                list-style-type: none;
                list-style: none;
                font-size: 1.5em;
                font-weight: 300;
            }

            .nav li span {
                display: inline;
                padding: 1em;
                margin: 0 auto;
            }

            .nav i {
                position: relative;
                padding: 0.5em;
                display: inline;
                font-size: 1em;
            }
            
            #headings {
                font-size: 4em;
            }
            
            select {
                -webkit-appearance: none;
                width: 100%;
                font-size: 6em;
            }
            
            option {
                padding-top: 0.4em;
                padding-bottom: 0.4em;
            }
        </style>
    </head>
    <body background="img/background.jpg">
        <nav class="nav">
            <ul>
                <li class="button">
                    <a id="prev_hole_btn">
                        <span class="icon"><i aria-hidden="true" class="icon-arrow-left"></i></span>
                    </a>
                </li>
                <li class="button">
                    <a id="account_btn" href="account_out.php">
                        <span>Account</span>
                    </a>
                </li>
                <li class="button">
                    <a id="next_hole_btn">
                        <span class="icon"><i aria-hidden="true" class="icon-arrow-right"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
        <table style="width:100%">
            <tr id="headings">
                <th>Score</th>
                <th>Putts</th> 
                <th>Club</th>
            </tr>
            <tr>
                <th>
                    <select id="score" size="5"></select>
                </th>
                <th>
                    <select id="putts" size="5"></select>
                </th>
                <th>
                    <select id="club" size="5">
                        <option value="1">1W</option>
                        <option value="2">3W</option>
                        <option value="3">5W</option>
                        <option value="4">1Hy</option>
                        <option value="5">2Hy</option>
                        <option value="3i">3i</option>
                        <option value="4i">4i</option>
                        <option value="5i">5i</option>
                        <option value="6i">6i</option>
                        <option value="7i">7i</option>
                        <option value="8i">8i</option>
                        <option value="9i">9i</option>
                        <option value="3i">Pw</option>
                        <option value="3i">Gw</option>
                        <option value="3i">Sw</option>
                        <option value="3i">Lw</option>
                    </select>
                </th>
            </tr>           
        </table>
    </body>
    <script type="text/javascript">
        var par = <?php echo $row['Par'] ?>;
        
        var create_score_slt = function () {
            var score_slt = document.getElementById('score');
            for(i = 0; i < 11; i++) {
                o = document.createElement('option');
                o.text = i; o.value = i;
                if(i === 0)
                    o.text = "Did Not Play";
                if(i === 1)
                    o.text = "In one: " + o.text;
                if((par-3) === i && i > 1)
                    o.text = "Albatross: " + o.text;
                if((par-2) === i && i > 1)
                    o.text = "Eagle: " + o.text;
                if((par-1) === i && i > 1)
                    o.text = "Birdie: " + o.text;
                if(par === i) {
                    o.text = "Par: " + o.text;
                    o.selected = true;
                }
                if((par+1) === i)
                    o.text = "Bogey: " + o.text;
                if((par+2) === i)
                    o.text = "2 Bogey: " + o.text;
                if((par+3) === i)
                    o.text = "3 Bogey: " + o.text;
                if((par+4) === i)
                    o.text = "4 Bogey: " + o.text;
                if((par+5) === i)
                    o.text = "5 Bogey: " + o.text;
                if((par+6) === i)
                    o.text = "6 Bogey: " + o.text;
                if((par+7) === i)
                    o.text = "7 Bogey: " + o.text;
                score_slt.add(o);
            }
        };
        
        var create_putts_slt = function () {
            var putts_slt = document.getElementById('putts');
            for(j = 0; j < document.getElementById('score').selectedIndex ; j++) {
                o = document.createElement('option');
                o.text = j; o.value = j;
                putts_slt.add(o);
            }
        };
        
        document.getElementById('score').onchange = function() {
            var putts_slt = document.getElementById('putts');
            for (i = putts_slt.options.length; i >= 0; i--) {
                putts_slt.remove(i);
            }
            create_putts_slt();
        };
        
        window.onload = function () {
            create_score_slt();
            create_putts_slt();
        };
    </script>
</html>

