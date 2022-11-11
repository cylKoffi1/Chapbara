function Geo(position) {

    var lat = position.coords.latitude;
    var lon = position.coords.longitude;

    google.maps.event.addDomListener("window", "load", loadmap(lat, lon))
    document.getElementById("latitude").innerHTML = lat;
    document.getElementById("longitude").innerHTML = lon;
}

function loadmap(lat, lon) {
    var options = {
        zoom: 8,
        center: new google.maps.LatLng(lat, lon),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map"), options)
var marker= new google.maps.Marker({
map: map,
title: "je t'ai trouvé",
position: new google.maps.LatLng(lat,lon)
});

}

function ErreurGeo() {
    var msg;
    switch (erreurcode) {
        case Error.TIMEOUT:
            msg = "Le temps de la requete a expiré";
            break;
        case Error.UNKNOWN_ERROR:
            msg = "Une erreur inconnue s'\est produite";
            break;
        case Error.POSITION_UNAVAILABLE:
            msg = "Une erreur technique s'\est produite";
            break;
        case Error.PERMISSION_DENIED:
            msg = "Vous avez reffusé la géolocalisation";
            break;
    }
    alert(msg);
}
if (navigator.geolocation) {//Si geolaclisation acivée

    navigator.geolocation.getCurrentPosition(Geo, ErreurGeo, { maximumAge: 120000 });
}
