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
	<link rel="stylesheet" href="css/leaflet.css"/>
        <link rel="stylesheet" href="css/map.css"/> 
        <script src="js/leaflet.js"></script>
        <title><?php echo $row['Hole_Name'] ?></title>
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
                    <a id="club">
<!--                        <span>Name of Hole</span>-->
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
                    </a>
                </li>
                <li class="button">
                    <a id="next_hole_btn">
                        <span class="icon"><i aria-hidden="true" class="icon-arrow-right"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
        <p id="err_msg" class="err_msg"></p>
        <div id="container" style="position:relative;">
            <table class="hole_info">
                <tr class="heading"><td>Hole</td></tr>
                <tr>
                    <td id="hole_num" class="info"></td>
                </tr>
                <tr class="heading"><td>Total Yards</td></tr>
                <tr>
                    <td id="total_yrds" class="info">468</td>
                </tr>
                <tr class="heading"><td>Par</td></tr>
                <tr>
                    <td id="par" class="info">5</td>
                </tr>
            </table>
            <div id="map"></div>
        </div>
    </body>
    <script>    
        var CID = <?php echo $CID ?>;
        var HID = <?php echo $HID ?>;
        var shots = Array();
    
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
            document.getElementById('total_yrds').innerHTML = get_dist(new L.LatLng(teeLat, teeLng), new L.LatLng(holeLat, holeLng));
            document.getElementById('par').innerHTML = "<?php echo $row['Par'] ?>";
            
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
                var select = document.getElementById('club_select'),
                    club = select.options[select.selectedIndex].value;
                add_marker(e.latlng.lat, e.latlng.lng, club);
            });
            
            add_tee(teeLat, teeLng);
            add_hole(holeLat, holeLng);
        };
        
        var add_tee = function (teeLat, teeLng) {
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
                var dist = get_dist(markers[markers.length-2], newMarker.getLatLng());
                newMarker.bindPopup(dist + " ("+club+")").openPopup();
                
                shots.push({Lat: lat, Lng: lng, Club: club, Dist: dist});
                
                // Re-draw Polylines
                map.removeLayer(lines);
                markers.splice(markers.length-1,0,newMarker.getLatLng());
                lines = L.polyline(markers, {color: 'white'});
                lines.addTo(map);
                // Update Hole Yardage
                holeMarker._popup.setContent("" + get_dist(markers[markers.length-2], holeMarker.getLatLng()));
            } else {
                document.getElementById('err_msg').style.display = "block";
                document.getElementById('err_msg').innerHTML = "Not in Bounds ("+(Math.round(lat * 100) / 100)+", "+(Math.round(lng * 100) / 100)+")";
            }
        };
        
        var get_dist = function (from, to) {
            return Math.round((from.distanceTo(to)) * 1.09361);
        };
       
        document.getElementById('club_select').onchange = function() {
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(function(position) {
                    var select = document.getElementById('club_select'),
                        club = select.options[select.selectedIndex].value;
                    add_marker(position.coords.latitude, position.coords.longitude, club);
                });
            }
        };   
           
        document.getElementById('next_hole_btn').onclick = function() {
            if (typeof(Storage) !== "undefined") {
                localStorage.setItem("Map"+HID, JSON.stringify(shots));
            } else {
                console.log("No Support for Local Storage");
            }
            window.location = "score.php?cid="+CID+"&hid="+HID;
        };
        
        document.getElementById('prev_hole_btn').onclick = function() {
            if(HID > 1) window.location =  "score.php?cid="+CID+"&hid="+(HID-1); 
            else window.location = "index.php"; 
        };
        
        window.addEventListener("orientationchange", function() {
            window.location = "scorecard.php?cid="+CID+"&hid="+HID;
        }, false);
        
        window.onload = init_map;
    </script>
</html>