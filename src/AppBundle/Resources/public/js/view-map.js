function initMap() {
    // Create a map object and specify the DOM element for display.
    return new google.maps.Map(document.getElementById('google-map'), {
        center: {lat: 47.211835, lng: -1.540543},
        scrollwheel: true,
        zoom: 2
    });
}

function createMarker(map, contribution) {
    var imageCommunity = '/bundles/app/img/marker-violet.png';
    var imagePartners = '/bundles/app/img/marker-partners.png';
    var imageCustomers = '/bundles/app/img/marker-customers.png';

    var image = imageCommunity;
    if (contribution.userType === 'partner') {
        image = imagePartners;
    }
    if (contribution.userType === 'customer') {
        image = imageCustomers;
    }

    var marker = new google.maps.Marker({
        map: map,
        position: contribution.position,
        title: contribution.userType,
        icon: image
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
