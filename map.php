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
	<link rel="stylesheet" href="css/leaflet.css"/>
        <!--<link rel="stylesheet" href="css/map.css"/>--> 
        <script src="js/leaflet.js"></script>
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
                font-family:  Tahoma, Geneva, sans-serif;
                background-repeat: no-repeat;
                background-size: cover;
            }

            #map {
                z-index: 1;
                font-size: 2.5em;
                height: 91vh; 
            }

            .nav a {
                display: inline;
                margin: 0 auto;
                padding: 0.5em;
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
                max-width: 1240px;
                padding: 0;
                margin: 0 auto;
                list-style-type: none;
                list-style: none;
                font-size: 1.5em;
                font-weight: 300;
            }

            .nav li span {
                display: inline;
            }

            .nav i {
                position: relative;
                display: inline;
                margin: 0 auto;
                padding: 0.4em;
                font-size: 1em;
            }
            
            .club_select {
                font-size: 2.5em;
                width: 60%;
                margin: 0 auto;
                margin-right: -0.15em;
                padding: 0.5em;
                padding-left: 0.6em;
                background: rgba(23, 207, 69, 0.85);
                color: rgba(249, 249, 249, 0.9);
                border: 1px solid white;
                box-sizing: border-box;
            }

            .hole_num {
                z-index: 2;
                position: absolute;
                margin-left: 5vw;
                margin-top: 1vh;
                color: rgb(249, 249, 249);
                font-size: 10em;
                text-shadow: 2px 2px black;
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
                    <select id="club_select" class="club_select">
                        <option value="" disabled selected>Mark your Shot</option>
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
                </li>
                <li class="button">
                    <a id="next_hole_btn">
                        <span class="icon"><i aria-hidden="true" class="icon-arrow-right"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
        <div id="container" style="position:relative;">
            <p id="hole_num" class="hole_num"></p>
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
            document.getElementById('hole_num').innerHTML = "<?php echo $HID ?>";
            
            map.setView(new L.LatLng(cenLat, cenLng), zoom);
            map.dragging.disable();
            map.touchZoom.disable();
            map.doubleClickZoom.disable();
            map.scrollWheelZoom.disable();
            map.boxZoom.disable();
            map.keyboard.disable();
            
            // load a tile layer
            var token = "pk.eyJ1Ijoic3RlcGhlbmR1bmRhcyIsImEiOiJjaXlhNzd1eTcwMDJmMndsdzNrNDc3a282In0.FI15WibAWtIOonIDt7J-FQ";
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token='+token, {
                maxZoom: zoom,
                minZoom: zoom,
                id: 'mapbox.outdoors'
            }).addTo(map);
            
            map.on('click', function(e) {
                console.log("LAT: " + e.latlng.lat + " || LNG: " + e.latlng.lng);
                add_marker(e.latlng.lat, e.latlng.lng);
            });
            
            add_tee(teeLat, teeLng);
            add_hole(holeLat, holeLng);
//            add_marker(55.74251, -4.14712);
        };
        
        var add_tee = function (teeLat, teeLng) { // 55.74371, -4.14736
            teeMarker = L.marker(new L.LatLng(teeLat, teeLng), {clickable: true, draggable: true}).addTo(map);
            markers.push(teeMarker.getLatLng()); 
        };  
        
        var add_hole = function (holeLat, holeLng) {
            holeMarker = L.marker(new L.LatLng(holeLat, holeLng), {icon: flagIcon, clickable: true}).addTo(map);
            holeMarker.bindPopup("" + get_dist(markers[markers.length-1], holeMarker.getLatLng())).openPopup();
            
            markers.push(holeMarker.getLatLng());
            lines = L.polyline(markers, {color: 'white'}).addTo(map);
        };
        
        var add_marker = function (lat, lng, club) {
            var LatLng = new L.LatLng(lat, lng);
            if(map.getBounds().contains(LatLng)) {
                newMarker = L.marker(LatLng, {draggable: true}).addTo(map);
                newMarker.bindPopup(get_dist(markers[markers.length-2], newMarker.getLatLng()) + " ("+club+")").openPopup();
                // Re-draw Polylines
                map.removeLayer(lines);
                markers.splice(markers.length-1,0,newMarker.getLatLng());
                lines = L.polyline(markers, {color: 'white'});
                lines.addTo(map);
                // Update Hole Yardage
                holeMarker._popup.setContent("" + get_dist(markers[markers.length-2], holeMarker.getLatLng()));
            } else {
                alert("Not in Bounds ("+lat+", "+lng+")");
            }
        };
        
        var get_dist = function (from, to) {
            return Math.round((from.distanceTo(to)) * 1.09361);
        };
        
//        document.getElementById('gps_btn').onclick = function() {
//            if(navigator.geolocation){
//                navigator.geolocation.getCurrentPosition(function(position) {
//                    add_marker(position.coords.latitude, position.coords.longitude);
//                });
//            }
//        };
        document.getElementById('club_select').onchange = function() {
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(function(position) {
                    var select = document.getElementById('club_select'),
                        club = select.options[select.selectedIndex].value;
                    add_marker(position.coords.latitude, position.coords.longitude, club);
//                    add_marker(55.74527, -4.14554, club);
                });
            }
        };   
           
        document.getElementById('next_hole_btn').onclick = function() {
            var HID = <?php echo $HID ?>;
            if(HID < 18) window.location =  "score.php?id=" + (HID);
            else window.location = "index.php"; 
        };
        
        document.getElementById('prev_hole_btn').onclick = function() {
            var HID = <?php echo $HID ?>;
            if(HID > 1) window.location =  "map.php?id=" + (HID-1); 
            else window.location = "index.php"; 
        };
        
//        document.getElementById('home_btn').onclick = function() {
//            window.location = "index.php"; 
//        };
        
        window.onload = init_map;
    </script>
</html>