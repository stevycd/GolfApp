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
?> 

<!DOCTYPE HTML>

<html>
    <head>
        <style>
            /* Global Styles */
            html * {
                font-family:  Tahoma, Geneva, sans-serif;
                background-repeat: no-repeat;
                background-size: cover;
            }  
            table, th, td {
		background: white;
		border: 1px solid black;
		border-collapse: collapse;
		width: 100%;
		font-size: 1.3em;
            }
            th, td {
		padding: 5px;
		text-align: center;
		width: 5%;
            }
            .title {
                background: #17cf45;
                color: white;
            }
            .scr {
                color: white;
            }
            .total {
                background: #e6e6e6;
            }
            p {
		background: rgba(23, 207, 69, 0.85);
                color: rgba(249, 249, 249, 0.9);
		width: 100%;
		padding-bottom: .1em;
		margin-top: 0;
		margin-bottom: 1em;
		font-size: 3em;
		text-align: center;
            }
        </style>
    </head>
    <body background="img/background.jpg">
	<p id="course_name"></p>
        <table id="scorecard">
            <thead>
                <tr>
                    <th class="title"></th>
                    <th class="title">1</th>
                    <th class="title">2</th>
                    <th class="title">3</th>
                    <th class="title">4</th>
                    <th class="title">5</th>
                    <th class="title">6</th>
                    <th class="title">7</th>
                    <th class="title">8</th>
                    <th class="title">9</td>
                    <th class="title">10</th>
                    <th class="title">11</th>
                    <th class="title">12</th>
                    <th class="title">13</th>
                    <th class="title">14</th>
                    <th class="title">15</th>
                    <th class="title">16</th>
                    <th class="title">17</th>
                    <th class="title">18</th>
                    <th class="title">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr id="row_score">
                    <th class="title">Score</th>
                    <td id="scr1" class="scr"></td>
                    <td id="scr2" class="scr"></td>
                    <td id="scr3" class="scr"></td>
                    <td id="scr4" class="scr"></td>
                    <td id="scr5" class="scr"></td>
                    <td id="scr6" class="scr"></td>
                    <td id="scr7" class="scr"></td>
                    <td id="scr8" class="scr"></td>
                    <td id="scr9" class="scr"></td>
                    <td id="scr10" class="scr"></td>
                    <td id="scr11" class="scr"></td>
                    <td id="scr12" class="scr"></td>
                    <td id="scr13" class="scr"></td>
                    <td id="scr14" class="scr"></td>
                    <td id="scr15" class="scr"></td>
                    <td id="scr16" class="scr"></td>
                    <td id="scr17" class="scr"></td>
                    <td id="scr18" class="scr"></td>
                    <td id="total_score" class="total"></td>
                </tr>
                <tr id="row_putts">
                    <th class="title">Putts</th>
                    <td id="putt1"></td>
                    <td id="putt2"></td>
                    <td id="putt3"></td>
                    <td id="putt4"></td>
                    <td id="putt5"></td>
                    <td id="putt6"></td>
                    <td id="putt7"></td>
                    <td id="putt8"></td>
                    <td id="putt9"></td>
                    <td id="putt10"></td>
                    <td id="putt11"></td>
                    <td id="putt12"></td>
                    <td id="putt13"></td>
                    <td id="putt14"></td>
                    <td id="putt15"></td>
                    <td id="putt16"></td>
                    <td id="putt17"></td>
                    <td id="putt18"></td>
                    <td id="total_putts" class="total"></td>
                </tr>
            </tbody>
        </table>
    </body>
    <script type="text/javascript">
        var pars = [];
        
        <?php 
            $q1 = mysql_query("SELECT * FROM courses WHERE CID='$CID'"); 
            $row = mysql_fetch_array($q1);
            echo "document.getElementById('course_name').innerHTML = \"" . $row['Course_Name'] . "\";\n";
        ?>
        
        var table = document.getElementById('scorecard'),
            tbody = table.getElementsByTagName("tbody")[0];
        
        var row_par = tbody.insertRow(0),
            title = row_par.insertCell(0);
            title.innerHTML = "<b>Par</b>";
            title.style.background = "#17cf45";
            title.style.color = "white";
        <?php 				
            $q2 = mysql_query("SELECT * FROM courses WHERE CID='$CID'");
            $Par_total = 0; $i = 1;
            while($fetch = mysql_fetch_array($q2)) {
                echo "var par = " . $fetch['Par'] . ";\n" 
                . "var cell = row_par.insertCell(" . $i . ");\n"
                . "var node = document.createTextNode(par);\n"
                . "cell.appendChild(node);\n"
                . "pars[" . $i . "] = par;\n";
                $Par_total += $fetch['Par'];
                $i++;
            }
            echo "var par_total = " . $Par_total . ";\n";
        ?>
        var total = row_par.insertCell(19),
            node = document.createTextNode(par_total);
            total.style.background = "#e6e6e6";
            total.appendChild(node);
            
        var total_scr = 0,
            total_putt = 0;
        for(i = 1; i <= 18; i++) {
            var scr = JSON.parse(localStorage.getItem("Scr"+i));
            if(scr !== null) {
                var cell = document.getElementById('scr'+i);
                var score = parseInt(scr.Score);
                cell.innerHTML = ""+scr.Score;
                
                if(score === pars[i]) cell.style.background = "#1a75ff";
                else if(score === pars[i]-1) cell.style.background = "#b30000";
                else if(score < pars[i]-1) cell.style.background = "#ff6600";
                else if(score === pars[i]+1) cell.style.background = "#00b33c";
                else if(score === pars[i]+2) cell.style.background = "#808080";
                else if(score > pars[i]+2) cell.style.background = "#1a1a1a";
                
                document.getElementById('putt'+i).innerHTML = ""+scr.Putts;
                total_scr += parseInt(scr.Score);
                total_putt += parseInt(scr.Putts);
            }
        } 
        document.getElementById('total_score').innerHTML = total_scr;
        document.getElementById('total_putts').innerHTML = total_putt;
            
        window.addEventListener("orientationchange", function() {
            var CID = <?php echo $CID ?>;
            var HID = <?php echo $HID ?>;
            window.location = "map.php?cid="+CID+"&hid="+HID;
        }, false);
    </script>
</html>