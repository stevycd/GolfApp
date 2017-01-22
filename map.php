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
        <meta name="viewport" content="minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
        <link rel="shortcut icon" href="img/favicon-16x16.png"/>
        <link rel="apple-touch-icon" href="img/apple-icon-76x76.png"/>
	<link rel="stylesheet" href="css/leaflet.css"/>
        <title><?php echo $row['Hole_Name'] ?></title>
  	<script src="js/leaflet.js"></script>
  	<style>
            #map {
                z-index: 1;
                height: 100vh; 
            }
            #next_hole_btn {
                margin-top: 2vh;
                margin-left: 6vw;
            }
            #gps_btn {
                margin-top: 9vh;
                margin-left: 6vw;
            }
            input[type=button] {
                height: 5vh;
                width: 30vw;
                
                position: absolute;
                z-index: 2;
                margin-top: 0.4em;
                padding: 0.375em;
                background: rgba(23, 207, 69, 0.85);
                color: rgba(249, 249, 249, 0.9);
                font-size: 2.5em;
                border: 1px solid white;
                box-sizing: border-box;
                
                -webkit-appearance: none;
                border-radius: 0;
            }
  	</style>
    </head>
    <body>
        <div id="container" style="position:relative;">
            <input type="button" name="next_hole" id="next_hole_btn" value="Next Hole">
            <input type="button" name="gps" id="gps_btn" value="Mark Location">
            <div id="map"></div>
        </div>
    </body>
    <script>
        var map = L.map('map'), 
            markers = Array(),
            cenLat = <?php echo $row['Cen_lat'] ?>, cenLng = <?php echo $row['Cen_lng'] ?>,
            teeLat = <?php echo $row['Tee_lat'] ?>, teeLng = <?php echo $row['Tee_lng'] ?>,
            zoom = <?php echo $row['Zoom'] ?>;
        
        var init_map = function () {
            map.setView(new L.LatLng(cenLat, cenLng), zoom);
            map.dragging.disable();
            map.touchZoom.disable();

            // load a tile layer
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpandmbXliNDBjZWd2M2x6bDk3c2ZtOTkifQ._QA7i5Mpkd_m30IGElHziw', {
                maxZoom: 20,
                minZoom: 17,
                id: 'mapbox.streets'
            }).addTo(map);
            
            add_tee(teeLat, teeLng);
        };
        
        var add_tee = function (teeLat, teeLng) {
            teeMarker = L.marker(new L.LatLng(teeLat, teeLng), {clickable: true, draggable: true}).addTo(map);
            markers.push(teeMarker.getLatLng());
        };    
        
        document.getElementById('gps_btn').onclick = function() {
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(function(position) {
                    newMarker = L.marker(new L.LatLng(position.coords.latitude,position.coords.longitude), {draggable: true}).addTo(map);
                    markers.push(newMarker.getLatLng());
                    L.polyline(markers, {color: 'white'}).addTo(map);
                });
            }
        };
        
        document.getElementById('next_hole_btn').onclick = function() {
            var HID = <?php echo $HID ?>;
            if(HID < 18) window.location =  "map.php?id=" + (HID+1); 
        };
        
        window.onload = init_map;
    </script>
</html>