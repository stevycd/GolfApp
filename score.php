<?php
    //Start the session
    session_start();
    //Get IDs
    $CID = $_GET['cid'];
    $HID = $_GET['hid'];    
    //Connect to the database
    define('DB_HOST', 'devweb2015.cis.strath.ac.uk');
    define('DB_NAME', 'xqb13173');
    define('DB_USER','xqb13173');
    define('DB_PASSWORD','Ith0tooph0th');
					
    $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
    $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
				
    $result = mysql_query("SELECT * FROM courses WHERE CID='$CID' AND HID='$HID'");
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
                src:  url('css/fonts/map/icomoon.eot?gfrc43');
                src:  url('css/fonts/map/icomoon.eot?gfrc43#iefix') format('embedded-opentype'),
                      url('css/fonts/map/icomoon.ttf?gfrc43') format('truetype'),
                      url('css/fonts/map/icomoon.woff?gfrc43') format('woff'),
                      url('css/fonts/map/icomoon.svg?gfrc43#icomoon') format('svg');
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
                font-family:  Tahoma, Geneva, sans-serif;
                background-repeat: no-repeat;
                background-size: cover;
            }            
            
            .nav {
                margin-bottom: 5em;
            }
            
            ul {
                margin: 0;
                padding: 0;
                list-style-type: none;
                overflow: hidden;
                background-color: rgba(23, 207, 69, 0.85);
            }

            li {
                width: 20%;
                float: left;
            }

            li a {
                display: block;
                color: white;
                padding: 0;
                padding-top: .5em;
                padding-bottom: .5em;
                font-size: 3.5em;
                text-align: center;
                text-decoration: none;
            }
            
            .title {
                width: 59%;
                border-left: 1px solid white;
                border-right: 1px solid white;
            }
            
            #hole_num {
                float: left;
                padding-left: 1em;
            }
            
            .heading {
                background: rgba(23, 207, 69, 0.85);
                color: rgba(249, 249, 249, 0.9);
                border: 1px solid white;
                font-size: 4em;
                font-weight:normal;
                text-align: left;
            }
            
            select {
                width: 100%;
                font-size: 5em;
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
                <li class="title">
                    <a>
                        <span id="hole_num"></span><span id="hole_name"></span>
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
            <tr class="heading">
                <td>Score</td>
                <td>Putts</td> 
                <td>Tee</td>
            </tr>
            <tr>
                <td>
                    <select id="score" size="5"></select>
                </td>
                <td>
                    <select id="putts" size="5"></select>
                </td>
                <td>
                    <select id="tee" size="5">
                        <option value="1W">1W</option>
                        <option value="3W">3W</option>
                        <option value="5W">5W</option>
                        <option value="1Hy">1Hy</option>
                        <option value="2Hy">2Hy</option>
                        <option value="3i">3i</option>
                        <option value="4i">4i</option>
                        <option value="5i">5i</option>
                        <option value="6i">6i</option>
                        <option value="7i">7i</option>
                        <option value="8i">8i</option>
                        <option value="9i">9i</option>
                        <option value="Pw">Pw</option>
                        <option value="Gw">Gw</option>
                        <option value="Sw">Sw</option>
                        <option value="Lw">Lw</option>
                    </select>
                </td>
            </tr>           
        </table>
    </body>
    <script type="text/javascript">
        var create_score_slt = function () {
            var par = <?php echo $row['Par'] ?>;
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
        
        document.getElementById('next_hole_btn').onclick = function() {
            var CID = <?php echo $CID ?>;
            var HID = <?php echo $HID ?>;
            var score = {
                Score: document.getElementById('score').value,
                Putts: document.getElementById('putts').value,
                Tee: document.getElementById('tee').value
            };
            if (typeof(Storage) !== "undefined") {
                console.log(score.Score + " " + score.Putts + " " + score.Tee);
                localStorage.setItem("Scr"+HID, score);
            } else {
                console.log("No Support for Local Storage");
            }
            if(HID < 18) {
                window.location =  "map.php?cid="+CID+"&hid="+(HID+1);
            }
            else window.location = "index.php"; 
        };
        
        document.getElementById('prev_hole_btn').onclick = function() {
            var CID = <?php echo $CID ?>;
            var HID = <?php echo $HID ?>;
            if(HID >= 1) window.location =  "map.php?cid="+CID+"&hid="+HID; 
            else window.location = "index.php"; 
        };
        
        window.onload = function () {
            document.getElementById('hole_num').innerHTML = "<?php echo $HID ?>"; 
            document.getElementById('hole_name').innerHTML = "<?php echo $row['Hole_Name'] ?>"; 
            
            create_score_slt();
            create_putts_slt();
        };
    </script>
</html>

