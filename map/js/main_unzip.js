var map;
$(function () {
	var options = {
		enableHighAccuracy: true,
		timeout: 5000,
		maximumAge: 0
	};
	$(document).on('click', '#btnInit', function () {
		//navigator.geolocation.getCurrentPosition(displayPosition, error, options);
	});
	/*if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(displayPosition, error, options);
	}*/
	var markers = []; //User location marker array
	var addAlertMarker = []; //Alert marker array
	var imagemarker = {	//Current position marker icon
		url: 'assets/icons/ico_curr_pos.png',
		size: new google.maps.Size(64, 64),
		scaledSize: new google.maps.Size(32, 32),
		origin: new google.maps.Point(0, 0),
	};

	function error(error) {		//Error when geolocation is not available
		switch (error.code) {
		case error.PERMISSION_DENIED:
			console.log("Ο χρήστης δεν επιτρέπει την χρήση της τοποθεσίας.");
			break;
		case error.POSITION_UNAVAILABLE:
			console.log( "Η τοποθεσία του χρήστη δεν είναι διαθέσιμη");
			break;
		case error.TIMEOUT:
			console.log("Η αίτηση τοποθεσίας έληξη.");
			break;
		case error.UNKNOWN_ERROR:
			console.log("Άγνωστο σφάλμα.");
			break;
		}
	};

	function displayPosition(pos) {
		setlocation(pos.coords.latitude, pos.coords.longitude, 10);
	}

	function setlocation(lat, lng, zom) {
		setAllMap(null);
		var myLatlng = new google.maps.LatLng(lat, lng);
		map.setCenter(myLatlng);
		map.setZoom(zom);
		var markera = new google.maps.Marker({
			position: myLatlng,
			map: map,
			icon: imagemarker, //'assets/icons/ico_curr_pos.png', //lineSymbol ,
			optimized: true,
			zIndex: 100000
		});
		markers.push(markera);
		var infowindow = new google.maps.InfoWindow({
			pixelOffset: new google.maps.Size(-16, 0),
		})
		google.maps.event.addListener(markera, 'mousedown', function () {
			infowindow.setContent("<b>Βρισκόσαστε εδώ ");
			infowindow.open(map, markera);
		});
		google.maps.event.addListener(markera, 'mouseup', function () {
			infowindow.close();
		});
	}
	
	var arrMarkers = [];
	var arrInfoWindows = [];
	var marker = null;
	var infowindow = new google.maps.InfoWindow({});	//The default infowindow for all markers
	var input = document.getElementById('searchTextField');	//The search input
	var options = { 
        bounds:google.maps.LatLngBounds(google.maps.LatLng(40.650906,22.88229),google.maps.LatLng(40.601918,23.011723)),
        componentRestrictions: {country: 'gr'},
        types: ["geocode"]       
        };
        
	var autocomplete = new google.maps.places.Autocomplete(input,options );
	google.maps.event.addListener(infowindow, 'closeclick', function () {
		for (var i = 0; i < addAlertMarker.length; i++) {
			addAlertMarker[i].setMap(null);
		}
	});
	//When user starts typing the search box
	google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
		var place = autocomplete.getPlace();
		if (place.geometry) {
			map.panTo(place.geometry.location);
			map.setZoom(17);
			search();
		} else {
			document.getElementById('searchTextField').placeholder = '';
		}
	});

	/*function moveMarker(placeName, latlng) {
		marker.setPosition(latlng);
		infowindow.setContent(placeName);
		infowindow.open(map, marker);
	}*/

	function dam(latLng) {	//Get address of marker placed on map(by user)
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({
			"latLng": latLng
		}, function (results, status) {
			//console.log(results, status);
			if (status == google.maps.GeocoderStatus.OK) {
				console.log(results);
				var lat = results[0].geometry.location.lat(),
					lng = results[0].geometry.location.lng(),
					addr_name = results[0].address_components[1].long_name,
					town = results[0].address_components[2].long_name
					addr_num = results[0].address_components[0].long_name
					latlng = new google.maps.LatLng(lat, lng);
				$("#searchTextField").val(results[0].formatted_address);
				infowindow.setContent(addr_name + " " + addr_num + "<br><a href='submit_alert.php?lat=" + lat + "&lng=" + lng + "&adr=" + addr_name + " " + addr_num + "," + town + "'/>Προσθήκη συμβάντος</a>");
				infowindow.open(map, marker);
			} else if (status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
				setTimeout(function () {
					dam(latLng);
				}, 200);
			}
		});
	}

	//Add marker when user clicks on map
	function createMarker(latlng, name, html) {
		var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			zIndex: Math.round(latlng.lat() * -100000) << 5,
			draggable: false
		});
		addAlertMarker.push(marker);
		google.maps.event.addListener(marker, 'rightclick', function (event) {
			marker.setMap(null);
		});
		google.maps.event.trigger(marker, 'click');
		return marker;
	}
	
	//Lets initialize the map
	function mapInit() {
		//What we want to include
		var styles = [
		{
		featureType: "poi",
		elementType: "labels",
		stylers: [{visibility: "off"}]
		},{
		featureType: "transit.station",
   		stylers:[{visibility: "off" }]
		},{
 		featureType: "poi.attraction",
    		stylers: [{ visibility: "off" }]
  		}
		]
		var styledMap = new google.maps.StyledMapType(styles, {
			name: "Styled Map"
		});
		google.maps.visualRefresh = true; //Enable visual refresh&lng=23.816874600000006
		var centerCoord = new google.maps.LatLng(39.074208, 23.824312);
		var mapOptions = {
			zoom: 7,
			center: centerCoord,
			disableDoubleClickZoom: true,
			draggableCursor: 'crosshair',
			mapTypeControl: true,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.LEFT_BOTTOM
			},
			panControl: false,
			zoomControl: true,
			zoomControlOptions: {
				 style: google.maps.ZoomControlStyle.LARGE
			},
			streetViewControl: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map"), mapOptions);
		map.mapTypes.set('map', styledMap);
		map.setMapTypeId('map');
		$.getJSON("markers_json.php?alt=" + complex, {}, function (data) {
			$.each(data.places, function (i, item) {
				$("#markers").append('<li><a href="#" rel="' + i + '">' + item.title + '</a></li>');
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng( parseFloat(item.lat) + parseFloat((Math.random() * (0.0200) + 0.0200)), parseFloat(item.lng) + parseFloat((Math.random() * (0.0200) + 0.0200))),//item.lat , item.lng),
					map: map,
					title: item.title,
					//TODO Add custom icon from DB query
					//icon: item.alert_icon,
					animation: google.maps.Animation.DROP,
					optimized: true,
				});
				arrMarkers[i] = marker;
				var article_content=window.atob(item.content).substring(0,1000);
				
				var infowindow = new google.maps.InfoWindow({
				content: "<div class='media' style='line-height:1.35;overflow:hidden;white-space:nowrap;'><div class='media-body'><h5 class='media-heading'>" + item.title + " <small>" + item.date + "</small></h5><em><p class='text-left'>" + item.town + "</p></em><div class='alert alert-warning'><div id='message_div'>" + window.atob(item.content)  + "</div></div><p><div class='addrdiv'>" + item.source + "</div><p><a id='various' href='"+ item.link+"'/><input name='envier' type='submit' class='btn btn-default' id='form2' value='Σύνδεσμος πηγής'/></a> <input align='right' name='envier' type='submit' class='btn btn-success' id='form1' value='Κλείσιμο'/></p></div></div><br>"
				});
				function showform(marker, handler) {
					if (infowindow) infowindow.close();
					if (handler) {
						google.maps.event.addListener(infowindow, 'domready', handler);
					}
				}
				arrInfoWindows[i] = infowindow;
				google.maps.event.addListener(marker, 'mouseover', function () {
					showform(marker, function () {
						$("#form1").click(function () {
							showform();
						});
					});
					for (x = 0; x < arrInfoWindows.length; x++) {
						arrInfoWindows[x].close();
					}
					infowindow.open(map, marker);
				});
				google.maps.event.addListener(infowindow, 'click', function () {
					alert("asd");
				});
				
			});
		});
		google.maps.event.addListener(map, 'click', function (event) {
			/*if (marker) {
				marker.setMap(null);
				marker = null;
			}
			marker = createMarker(event.latLng, "name", dam(event.latLng));
			*/
		});
	}
	function setAllMap(map) {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(map);
		}
	}
	$(function () {
		mapInit();
		$("#markers").on("click", "a", function () {
			var i = $(this).attr("rel");
			// this next line closes all open infowindows before opening the selected one
			for (x = 0; x < arrInfoWindows.length; x++) {
				arrInfoWindows[x].close();
			}
			arrInfoWindows[i].open(map, arrMarkers[i]);
		});
	});
});
$('navbar-form').submit(function () {
	return false;
});
$(document).ready(function () {
	$("#various").fancybox({
		autoSize: false,
		padding: 0,
		helpers: {
			title: null
		}
	});
});
