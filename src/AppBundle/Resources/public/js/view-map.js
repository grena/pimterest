function initMap() {
    // Create a map object and specify the DOM element for display.
    return new google.maps.Map(document.getElementById('google-map'), {
        center: {lat: 47.211835, lng: -1.540543},
        scrollwheel: true,
        zoom: 2
    });
}

function createMarker(map, contribution) {
    // Create a marker and set its position.
    var marker = new google.maps.Marker({
        map: map,
        position: contribution.position,
        title: 'Hello World!'
    });

    var contentTemplate = _.template(info_window_template);
    var contentString = contentTemplate({
        content: Autolinker.link(contribution.content),
        mediaUrl: contribution.media
    });

    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });
}

$(document).ready(function(e) {
    var map = initMap();

    var locations = $.get('/rest/locations').done(function(response){
        response.forEach(function(coordinates){
            createMarker(map, coordinates);
        })
    });
});
