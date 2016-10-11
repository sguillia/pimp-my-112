<?php

require("auth.php");
check_auth();
require("Private/sql.php");

// ******************************* //
// Retrieve ID either from -- ma current ID -- or from GET or something
// Later TODO: do not retrive from max ID
// ******************************* //

$n = $bdd->query("SELECT max(ID) FROM requests");

$data = $n->fetch();
$last_id = $data[0];

// Willingly put two equal symbols, not three
// Data is expected to be non-zero
if ($last_id == false)
{
	exit("Error while retrieving ID to be shown -- database seems empty\n");
}

// ******************************* //

$reponse = $bdd->query("SELECT * FROM requests WHERE ID='$last_id'");

if ($data = $reponse->fetch())
{


	if ($data['do_geoloc']) // this is used to know if coordinates has been received
	{
		?>
<html>
<body id='mybody'>
<!--__112_LOCALIZATION_WAITING__-->
<p>En attente de localisation ...</p>
<pre>
ID:_________________________   <?php echo $last_id; ?>&zwnj;
Numero:_____________________   <?php echo $data['phonenumber']; ?>&zwnj;
Heure de la demande:________   <?php echo $data['timestamp']; ?>&zwnj;
Dernier rafraichissement: __   <?php echo date('Y-m-d H:i:s'); ?>&zwnj;
Page visitee:_______________   <?php echo $data['visited']; ?>&zwnj;
</pre>
</body>
</html>
<?php
		exit();
		//exit("<html><body id='mybody'><img src='france.png'></body></html>");
	}

	$coord = $data['coord'];

}
else
{
	exit("Error for the ID '$last_id' : ID not found in database\n");
}



// --------- En attendant une carte valable

?>

<html>
<body id='mybody'>
<!--__112_LOCALIZATION_DONE__-->
<p>Ok ! Affichage de la carte [basique]</p>
<pre>
ID:_________________________   <?php echo $last_id; ?>&zwnj;
Numero:_____________________   <?php echo $data['phonenumber']; ?>&zwnj;
Heure de la demande:________   <?php echo $data['timestamp']; ?>&zwnj;
Dernier rafraichissement: __   <?php echo date('Y-m-d H:i:s'); ?>&zwnj;
Page visitee:_______________   <?php echo $data['visited']; ?>&zwnj;
[!] Coordonnees :___________   <?php echo $data['coord']; ?>&zwnj;
</pre>
<iframe
width="600"
height="450"
frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCumJJs-B-bUKKyKeidx9fXZdR2yXYe_yk
&q=<?php echo $coord; ?>" allowfullscreen>
</iframe>
</body>
</html>

<?php
exit();
// ---------



?>
<html>
<head>
<title>Map</title>

<style type="text/css">

#map_wrapper {
	height: 100%;
}

#map_canvas {
width: 100%;
height: 100%;
}

</style>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>








<script type="text/javascript">

jQuery(function($) {
		// Asynchronously Load the map API 
		var script = document.createElement('script');
		script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
		document.body.appendChild(script);
		});

function initialize() {
	var map;
	var bounds = new google.maps.LatLngBounds();
	var mapOptions = {
mapTypeId: 'roadmap'
	};

	// Display a map on the page
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	map.setTilt(45);

	// Multiple Markers
	//  ['London Eye, London', 51.503454,-0.119562],
	var markers = [

		['Appelant', <?php echo $coord; ?>]

	];

	// Info Window Content
	var infoWindowContent = [
		['<div class="info_content">' +
		'<h3>London Eye</h3>' +
		'<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>'],
		['<div class="info_content">' +
			'<h3>Palace of Westminster</h3>' +
			'<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
			'</div>']
	];

	// Display multiple markers on a map
	var infoWindow = new google.maps.InfoWindow(), marker, i;

	// Loop through our array of markers & place each one on the map  
	for( i = 0; i < markers.length; i++ ) {
		var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
		bounds.extend(position);
		marker = new google.maps.Marker({
position: position,
map: map,
title: markers[i][0]
});

// Allow each marker to have an info window    
google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
			infoWindow.setContent(infoWindowContent[i][0]);
			infoWindow.open(map, marker);
			}
			})(marker, i));

// Automatically center the map fitting all markers on the screen
map.fitBounds(bounds);
}

// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
		this.setZoom(14);
		google.maps.event.removeListener(boundsListener);
		});

}

</script>


</head>

<body>

<p>In show_coord.php : now showing map with coordinates, ID <?php echo $last_id; ?></p>

<!-- Caution: google maps api key is restricted to the domain name -->

<div id="map_wrapper">
<div id="map_canvas" class="mapping"></div>
</div>


</body>
</html>
