function initMap() {
    // Create a map object and specify the DOM element for display.
    map = new google.maps.Map(document.getElementById('google-map'), {
        center: {lat: 47.211835, lng: -1.540543},
        scrollwheel: true,
        zoom: 2
    });

    var styles = [{
        "featureType": "landscape",
        "stylers": [{"hue": "#FFBB00"}, {"saturation": 43.400000000000006}, {"lightness": 37.599999999999994}, {"gamma": 1}]
    }, {
        "featureType": "road.highway",
        "stylers": [{"hue": "#FFC200"}, {"saturation": -61.8}, {"lightness": 45.599999999999994}, {"gamma": 1}]
    }, {
        "featureType": "road.arterial",
        "stylers": [{visibility: 'off'}]
    }, {
        "featureType": "road.local",
        "stylers": [{visibility: 'off'}]
    }, {
        "featureType": "water",
        "stylers": [{"hue": "#0078FF"}, {"saturation": -13.200000000000003}, {"lightness": 2.4000000000000057}, {"gamma": 1}]
    }, {
        "featureType": "poi",
        "stylers": [{visibility: 'off'}]
    }];

    map.setOptions({styles: styles});

    return map;
}

function initClusters(map) {
    return {
        community: new MarkerClusterer(map)
    }
}

function createMarker(map, clusters, contribution) {
    var imageCommunity = '/bundles/app/img/marker-collaborators.png';
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

    marker.addListener('click', function () {
        infowindow.open(map, marker);
    });
    clusters.community.addMarker(marker);
}

$(document).ready(function (e) {
    var map = initMap();
    var clusters = initClusters(map);

    var locations = $.get('/rest/locations').done(function (response) {
        response.forEach(function (coordinates) {
            createMarker(map, clusters, coordinates);
        })
    });
});
