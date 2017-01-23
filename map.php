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
            /* Global Styles */
            html * {
                font-family:  Tahoma, Geneva, sans-serif;
                background-repeat: no-repeat;
                background-size: cover;
            }
            #map {
                font-size: 2.5em;
                height: 94vh; 
            }
            input[type=button] {
                margin-bottom: 0.1em;
                margin-right: 0;
                height: 5vh;
                width: 24.2vw;
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
    <body background="img/background.jpg">
        <input type="button" name="prev_hole" id="prev_hole_btn" value="Prev Hole">
        <input type="button" name="home" id="home_btn" value="Home">
        <input type="button" name="gps" id="gps_btn" value="Mark">
        <input type="button" name="next_hole" id="next_hole_btn" value="Next Hole">
        <div id="container" style="position:relative;">
            <div id="map"></div>
        </div>
    </body>
    <script>
        var flagIcon = L.icon({
           iconUrl: 'img/flag.png',
           iconSize:     [38,106],
           iconAnchor:   [6,103],
           popupAnchor:  [6,-100]
        });
        
        var map = L.map('map'), 
            markers = Array(),
            lines = Array(),
            linesLayer = L.layerGroup(lines),
            holeLat = <?php echo $row['Hole_lat'] ?>, holeLng = <?php echo $row['Hole_lng'] ?>,
            cenLat = <?php echo $row['Cen_lat'] ?>, cenLng = <?php echo $row['Cen_lng'] ?>,
            teeLat = <?php echo $row['Tee_lat'] ?>, teeLng = <?php echo $row['Tee_lng'] ?>,  
            zoom = <?php echo $row['Zoom'] ?>;
        
        var init_map = function () {
            map.setView(new L.LatLng(cenLat, cenLng), zoom);
            map.dragging.disable();
            map.touchZoom.disable();

            // load a tile layer
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoic3RlcGhlbmR1bmRhcyIsImEiOiJjaXlhNzd1eTcwMDJmMndsdzNrNDc3a282In0.FI15WibAWtIOonIDt7J-FQ', {
                maxZoom: 19,
                minZoom: 17,
                id: 'mapbox.outdoors'
            }).addTo(map);
            
            add_tee(teeLat, teeLng);
            add_hole(holeLat, holeLng);
        };
        
        var add_tee = function (teeLat, teeLng) { // 55.74371, -4.14736
            teeMarker = L.marker(new L.LatLng(teeLat, teeLng), {clickable: true, draggable: true}).addTo(map);
            markers.push(teeMarker.getLatLng());
            
//            if(map.getBounds().contains(new L.LatLng(55.74371, -4.14736))) {
//                testMarker = L.marker(new L.LatLng(55.74371, -4.14736)).addTo(map);
//                testMarker.bindPopup("" + get_dist(teeMarker, testMarker)).openPopup();
//                markers.push(testMarker.getLatLng());
//            }
//            L.polyline(markers, {color: 'white'}).addTo(map);  
        };  
        
        var add_hole = function (holeLat, holeLng) {
            holeMarker = L.marker(new L.LatLng(holeLat, holeLng), {icon: flagIcon, clickable: true}).addTo(map);
            holeMarker.bindPopup("" + get_dist(markers[markers.length-1], holeMarker.getLatLng())).openPopup();
            
            markers.push(holeMarker.getLatLng());
            lines = L.polyline(markers, {color: 'white'}).addTo(map);
        };
        
        document.getElementById('gps_btn').onclick = function() {
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(function(position) {
                    var LatLng = new L.LatLng(position.coords.latitude,position.coords.longitude);
                    if(map.getBounds().contains(LatLng)) {
                        newMarker = L.marker(LatLng, {draggable: true}).addTo(map);
                        newMarker.bindPopup("" + get_dist(markers[markers.length-2], newMarker.getLatLng())).openPopup();
                        // Re-draw Polylines
                        map.removeLayer(lines);
                        markers.splice(markers.length-1,0,newMarker.getLatLng());
                        lines = L.polyline(markers, {color: 'white'});
                        lines.addTo(map);
                        // Update Hole Yardage
                        holeMarker._popup.setContent("" + get_dist(markers[markers.length-2], holeMarker.getLatLng()));
                    } else {
                        alert("Not in Bounds");
                    }
                });
            }
        };
        
        var get_dist = function (from, to) {
            return Math.round((from.distanceTo(to)) * 1.09361);
        };
        
        document.getElementById('next_hole_btn').onclick = function() {
            var HID = <?php echo $HID ?>;
            if(HID < 18) window.location =  "map.php?id=" + (HID+1); 
        };
        
        document.getElementById('prev_hole_btn').onclick = function() {
            var HID = <?php echo $HID ?>;
            if(HID > 1) window.location =  "map.php?id=" + (HID-1); 
        };
        
        document.getElementById('home_btn').onclick = function() {
            window.location = "index.php"; 
        };
        
        window.onload = init_map;
    </script>
</html>