//Waiting for Page to be ready
jQuery(document).ready(function(){
	getData();
	setSize();
	initializeMap();
	resetControl();
	startControl();
});

//Attributes
var map;
var latlng = new google.maps.LatLng(Math.random() * 70, Math.random() * 150);
var listener = null;
var elevationListerner = false;
var operation = "move";
var elevator = null;
var oldinfo = null;

var actionFile = null;
var mapID = null;
var userid = null;

var markerArr = new Array();
markerArr[0] = new Array(); // the latlng
markerArr[1] = new Array();	// the object
markerArr[2] = new Array(); // data -> link
markerArr[3] = new Array(); // data -> id
markerArr[4] = new Array(); // data -> elevation
var infoArr = new Array(); // infoboxes

//Functions
function initializeMap(){		
	if(markerArr[0].length > 0){
		start = markerArr[0].length - 1;
		latlng = markerArr[0][start];
		zoom = 10;
	}
	else{
		zoom = 3;
	}

	var options = {
		zoom: zoom,
		center: latlng,
 		mapTypeId: google.maps.MapTypeId.TERRAIN,
		streetViewControl: false
	}
	map = new google.maps.Map(document.getElementById('mixare-poi-map'), options);
	
	for(i = 0; i < markerArr[0].length; i++){
		markerArr[1][i].setMap(map);

		if(markerArr[1][i].getTitle() != "")
			var icon = "http://google-maps-icons.googlecode.com/files/beautiful.png";
		else
			var icon = "http://google-maps-icons.googlecode.com/files/accident.png";

		markerArr[1][i].setOptions({
			icon: icon
		});
		attachMarkerMessage(i);
	}
	
	elevator = new google.maps.ElevationService();
}
function attachMarkerMessage(marker){
	var infomessage = 'Name:<br /><input type="text" id="marker_name" value="' + markerArr[1][marker].getTitle() + '" onkeyup="getPoiTitle(' + marker + ');" /><br />Link:<br /><input type="text" id="marker_link" value="' + markerArr[2][marker] + '" onkeyup="getPoiLink(' + marker + ')" />';
	var infowindow = new google.maps.InfoWindow(
	{ 	content: infomessage,
		maxWidth: 200,
		size: new google.maps.Size(50,50)
	});

	listener = google.maps.event.addListener(markerArr[1][marker], 'click', function(event){
		if(operation == "delete"){
        	markerArr[1][marker].setVisible(false);
			resetControl();
		}else if(operation == "modify"){
			
			if(oldinfo != null){
				infoArr[oldinfo].close();
				markerArr[1][oldinfo].setDraggable(false);
			}

			elevationListener = true;
			oldinfo = marker;
			infoArr[marker].open(map, markerArr[1][marker]);
			infoArr[marker].setContent('Name:<br /><input type="text" id="marker_name" value="' + markerArr[1][marker].getTitle() + '" onkeyup="getPoiTitle(' + marker + ');" /><br />Link:<br /><input type="text" id="marker_link" value="' + markerArr[2][marker] + '" onkeyup="getPoiLink(' + marker + ')" />');
			markerArr[1][marker].setDraggable(true);

			google.maps.event.addListener(markerArr[1][marker], 'dragend', function(event){
				if(elevationListener){
					markerArr[4][marker] = getElevation(event.latLng, marker);
				}
			});
			google.maps.event.addListener(markerArr[1][marker], 'click', function(event){
				if(elevationListener){
					markerArr[4][marker] = getElevation(event.latLng, marker);
				}
			});
		}
    });

	infoArr[marker] = infowindow;
}
function setSize(){
	jQuery('#mixare-poi-map').css('height', '500px');
}
function addMarker(location) {
	var marker = new google.maps.Marker({
		position: location,
		map: map,
		animation: google.maps.Animation.DROP,
		title: "",
		icon: "http://google-maps-icons.googlecode.com/files/accident.png"
	});
	var infowindow = new google.maps.InfoWindow(
	{ content: 'Name:<br /><input type="text" id="marker_name" onkeyup="getPoiTitle(' + markerArr[1].length + ')" /><br />Link:<br /><input type="text" id="marker_link" onkeyup="getPoiLink(' + marker + ')" />',
	size: new google.maps.Size(50,50),
	});

	//infowindow.open(map,marker);
	marker.setMap(map);

	markerArr[0][markerArr[0].length] = location;
	markerArr[1][markerArr[1].length] = marker;
	markerArr[2][markerArr[2].length] = "";
	markerArr[3][markerArr[3].length] = null;
	getElevation(location, markerArr[4].length);
	infoArr[infoArr.length] = infowindow;

	attachMarkerMessage(infoArr.length - 1);
	resetControl();
}
function startControl(){
	jQuery('#mixare-move').click(function(){
		resetControl();
		operation = "move";
	});
	jQuery('#mixare-insert').click(function(){
		operation = "insert";
		insertListener = google.maps.event.addListener(map, 'click', function(event) {
			if(operation == "insert")				
				addMarker(event.latLng);
  		});
	});
	jQuery('#mixare-delete').click(function(){
		operation = "delete";
	});
	jQuery('#mixare-modify').click(function(){
		operation = "modify";
	});
	jQuery('#mixare-save').click(function(){
		saveState();
	});
}
function resetControl(){

	if(operation == "insert"){
		google.maps.event.removeListener(insertListener);
	}	

	for(i = 0; i < markerArr[1].length; i++){
		if(markerArr[1][i] != null){
			markerArr[1][i].setDraggable(false);
			infoArr[i].close();
		}
	}

	elevationListener = false;
	operation = "move";
	jQuery('#mixare-move').attr('checked', 'checked');
	jQuery('#mixare-move').focus();
}
function saveState(){
	//saving MAP data
	var category = jQuery('#mixare-category').val();
	var redundancyCheck = 0;
	var mapName = jQuery('#mixare-name').val();
	if(jQuery('#mixare-public').attr('checked')){
		var mapState = 1;
	}else{
		var mapState = 0;
	}

	if(mapID != null)
		var data = "action=save&save=map&name=" + mapName + "&state=" + mapState + "&userid=" + userid + "&id=" + mapID + "&category=" + category;
	else
		var data = "action=save&save=new&name=" + mapName + "&state=" + mapState + "&userid=" + userid + "&category=" + category;
	
	jQuery.ajax({
		url: actionFile,
		type: "POST",
		data: data,
		cache: false,
		success: function(html){
			if(mapID == null){
				mapID = parseInt(html);
				var neu = true;
			}
			//saving MARKER data
			for(i = 0; i < markerArr[1].length; i++){
				if(markerArr[1][i].getVisible())
					var del = false;
				else
					var del = true;
				
				var latlng = markerArr[1][i].getPosition().toString();
				var elevation = markerArr[4][i];
				var distance = "9.777";
				var title = markerArr[1][i].getTitle();
				jQuery.ajax({
					url: actionFile,
					type: "POST",
					data: "action=save&save=marker&latlng=" + latlng + "&elevation=" + elevation + "&distance=" + distance + "&webpage=" + markerArr[2][i] + "&title=" + title + "&mapid=" + mapID + "&poiid=" + markerArr[3][i] + "&del=" + del,
					cache: false,
					success: function(html){
						if(markerArr[3][i] == null){
							markerArr[3][i] = parseInt(html);
							alert(typeof markerArr[3][i] + " -> " + "action=save&save=marker&latlng=" + latlng + "&elevation=" + elevation + "&distance=" + distance + "&webpage=" + markerArr[2][i] + "&title=" + title + "&mapid=" + mapID + "&poiid=" + markerArr[3][i] + "&del=" + del);
						}else if(typeof markerArr[3][i] == "number"){						
							jQuery('#map-message').html(html);
						}
						setTimeout("clearMessage(" + neu + ", " + mapID + ")", 2000);				
					}
				});
			}	
		}
	});
}

//crazy actions
function clearMessage(neu){
	jQuery('#map-message').html("");
	if(neu){
		var weck = self.location.toString();
		document.location.href = weck.split("new").join(mapID);
	}
}
function getPoiTitle(mark){
	title = jQuery('#marker_name').val();
	markerArr[1][mark].setTitle(title);

	if(title != ""){
		var icon = "http://google-maps-icons.googlecode.com/files/beautiful.png";
	}else{
		var icon = "http://google-maps-icons.googlecode.com/files/accident.png";
	}

	markerArr[1][mark].setOptions({
		icon: icon	
	});
}
function getPoiLink(mark){
	link = jQuery('#marker_link').val();
	markerArr[2][mark] = link;
}
function getElevation(event, marker) {

var locations = [];

locations.push(event);

// Create a LocationElevationRequest object using the array's one value
var positionalRequest = {
'locations': locations
}

// Initiate the location request
	elevator.getElevationForLocations(positionalRequest, function(results, status) {
		if (status == google.maps.ElevationStatus.OK) {

		// Retrieve the first result
		if (results[0]) {

			// Open an info window indicating the elevation at the clicked position
			markerArr[4][marker] = results[0].elevation;
		} else {
			return 0;
		}
		} else {
			return 0;
		}
	});
}

