var latLngService;
var map;
var coordonneesDepart, markerDepart, markerDepartOptions;
var coordonneesArrivee, markerArrivee, markerArriveeOptions;
//var directionsRenderer, directionsRendererOptions, directionsService;

function chargerCarte() {

    latLngService = new google.maps.Geocoder();
    latLngService.geocode({address:"Sophia Antipolis"}, callback) 
 
   	function callback(ret) {
   		// Création de la carte
   		var lat = ret[0].geometry.location.Ya;
   		var lng = ret[0].geometry.location.Za; 
   		var latLng = new google.maps.LatLng(lat,lng); 
   		var myOptions = {zoom:10, center:latLng, mapTypeId:google.maps.MapTypeId.HYBRID}; 
   		map = new google.maps.Map(document.getElementById("carte"), myOptions);
   		
   		latLng = new google.maps.LatLng (43.70298596667489, 7.26009883593747); // Coordonnées Nice
   		coordonneesDepart = new google.maps.LatLng(latLng.lat() ,latLng.lng());
   		markerDepartOptions = {position:coordonneesDepart, map:map, draggable:true, icon:"ress/marker_greenA.png"};
		markerDepart = new google.maps.Marker(markerDepartOptions);
			
		// Ajout du Listener au marqueur de départ
		google.maps.event.addListener(markerDepart, "dragend", function() {
			CoordonneesToString(markerDepart.getPosition(), "A");
			calculerItineraire(markerDepart, markerArrivee);
		});
			
		CoordonneesToString(markerDepart.getPosition(), "A");
		
		latLng = new google.maps.LatLng (43.603326351946905, 7.010610873046858); // Coordonnées Mougins
		coordonneesArrivee = new google.maps.LatLng(latLng.lat() ,latLng.lng());
   		markerArriveeOptions = {position:coordonneesArrivee, map:map, draggable:true, icon:"ress/marker_greenB.png"};
		markerArrivee = new google.maps.Marker(markerArriveeOptions);
		
		// Ajout du Listener au marqueur d'arrivée
		google.maps.event.addListener(markerArrivee, "dragend", function() {
			CoordonneesToString(markerArrivee.getPosition(), "B");
			calculerItineraire();
		});
			
		CoordonneesToString(markerArrivee.getPosition(), "B");
		
		calculerItineraire();	
   	}

	// Initialisation du service de calcul d'itinéraire
	directionsRendererOptions = {draggable : true};
	directionsRenderer = new google.maps.DirectionsRenderer(directionsRendererOptions);
	directionsService = new google.maps.DirectionsService();

}


function calculerItineraire() {
	
	directionsRenderer.setMap(map);
	
	var departPosition = markerDepart.getPosition();
	var arriveePosition = markerArrivee.getPosition();
	
	var parametresTrajet = {origin:departPosition, destination:arriveePosition, travelMode:google.maps.DirectionsTravelMode.DRIVING};
	
	directionsService.route(parametresTrajet, function(reponse, statut) {
		if (statut == google.maps.DirectionsStatus.OK) {
			calculerEtAfficherDistance(reponse);
		}
	});
	
}


function calculerEtAfficherDistance(resultat) {
	var total = 0;
	var route = resultat.routes[0];
	for (i = 0; i < route.legs.length; i++) {
		total += route.legs[i].distance.value;
	}
	total = Math.floor(total / 10) / 100;
	document.getElementById("distanceTotale").innerHTML = total + " km";
}


function CoordonneesToString(coordonnees, idHtml) {

	document.getElementById("lat" + idHtml).innerHTML = coordonnees.lat();
	document.getElementById("long" + idHtml).innerHTML = coordonnees.lng();

	latLngService.geocode({location:coordonnees}, function(reponse, statut) {
		if (google.maps.GeocoderStatus.OK) {
			var test = reponse[0].address_components;
			var numero = "";
			var rue = "";
			var codePostal = "";
			var ville = "";
			for(var i = 0; i < test.length; i++){
				if(test[i].types[0] == "street_number") { numero = test[i].long_name; }
				if(test[i].types[0] == "route") { rue = test[i].long_name; }
				if(test[i].types[0] == "locality") { ville = test[i].long_name; }
				if(test[i].types[0] == "postal_code") { codePostal = test[i].long_name; }
				}
			document.getElementById("adresse" + idHtml).value = numero + " " + rue + " " + ville;
			}
		});
}

function changerPoint(element, point) {

	// SECURITE A IMPLEMENTER
	var nouvelleAdresse = element.value;
	
	latLngService.geocode({address:nouvelleAdresse}, function(reponse, statut) {
		if (google.maps.GeocoderStatus.OK) {
			if (point == 'depart') {
				markerDepart.setPosition(reponse[0].geometry.location);
			} else if (point == 'arrivee') {
				markerArrivee.setPosition(reponse[0].geometry.location);
			}
			calculerItineraire();
		}
	});
	
}
