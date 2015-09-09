function initMap() {
    // Create a map object and specify the DOM element for display.
    return new google.maps.Map(document.getElementById('google-map'), {
        center: {lat: 0, lng: 0},
        scrollwheel: true,
        zoom: 2
    });
}

function createMarker(map, coordinates) {
    // Create a marker and set its position.
    var marker = new google.maps.Marker({
        map: map,
        position: coordinates,
        title: 'Hello World!'
    });
}
$(document).ready(function(e) {
    var map = initMap();

    var locations = $.get('/app_dev.php/rest/locations').done(function(response){
        response.forEach(function(coordinates){
            createMarker(map, coordinates);
        })
    });
});
