var map;
var latLngService;
var directionsRendererOptions, directionsRenderer, directionsService;
var coordonneesDepart, coordonneesArrivee;

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
		
		// Initialisation du service de calcul d'itinéraire
		directionsRendererOptions = {draggable:true, map:map};
		directionsRenderer = new google.maps.DirectionsRenderer(directionsRendererOptions);
		directionsService = new google.maps.DirectionsService();
		
		init();	
   	}

}

function calculerDistanceEtTemps() {
	
	var total = 0;
	var temps = 0; // secondes
	
	var resultat = directionsRenderer.getDirections();
	var route = resultat.routes[0];
	
	for (i = 0; i < route.legs.length; i++) {
		total += route.legs[i].distance.value;
		temps += route.legs[i].duration.value;
	}
	
	total = Math.floor(total / 10) / 100;
	temps = Math.floor(temps / 60); // minutes
	document.getElementById("distanceTotale").innerHTML = total + " km";
	document.getElementById("dT").value = total;
	document.getElementById("tempsTotal").innerHTML = temps + " min";
	document.getElementById("tT").value = temps;
}

function mettreAJourInputs() {

	var resultat = directionsRenderer.getDirections();
	var points = resultat.routes[0].overview_path;

	var depart = points[0];
	CoordonneesToString(depart, "A");

	var arrivee = points[points.length - 1];
	CoordonneesToString(arrivee, "B");
}

function init() {

	var departPosition = new google.maps.LatLng (43.70298596667489, 7.26009883593747); // Coordonnées Nice
	var arriveePosition = new google.maps.LatLng (43.603326351946905, 7.010610873046858); // Coordonnées Mougins
	coordonneesDepart = departPosition;
	coordonneesArrivee = arriveePosition;
	
	var parametresTrajet = {origin:departPosition, destination:arriveePosition, travelMode:google.maps.DirectionsTravelMode.DRIVING};
	
	directionsService.route(parametresTrajet, function(reponse, statut) {
		if (statut == google.maps.DirectionsStatus.OK) {
			directionsRenderer.setDirections(reponse);
			
			// Ajout du Listener
			google.maps.event.addListener(directionsRenderer, "directions_changed", function() {
				calculerDistanceEtTemps();
				mettreAJourInputs();
			});
			
			calculerDistanceEtTemps();
			mettreAJourInputs();
		}
	});
}

function calculerItineraire() {

	var parametresTrajet = {origin:coordonneesDepart, destination:coordonneesArrivee, travelMode:google.maps.DirectionsTravelMode.DRIVING};
	
	directionsService.route(parametresTrajet, function(reponse, statut) {
		if (statut == google.maps.DirectionsStatus.OK) {
		
			directionsRenderer.setDirections(reponse);
		}
	});

}

function CoordonneesToString(coordonnees, idHtml) {

	var lat = Math.ceil(coordonnees.lat() * 1000000000) / 1000000000;
	var lng = Math.ceil(coordonnees.lng() * 1000000000) / 1000000000;
	document.getElementById("lat" + idHtml).innerHTML = lat;
	document.getElementById("long" + idHtml).innerHTML = lng;

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
				coordonneesDepart = reponse[0].geometry.location;
			} else if (point == 'arrivee') {
				coordonneesArrivee = reponse[0].geometry.location;
			}
			calculerItineraire();
		}
	});
	
}
