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
        community: new MarkerClusterer(map, [], {
            gridSize: 30,
            maxZoom: 8
        })
    }
}

function createMarker(map, clusters, infowindow, contribution) {
    CB_Init();
    var imageCommunity = '/bundles/app/img/marker-collaborators.png';
    var imagePartners = '/bundles/app/img/marker-partners.png';
    var imageCustomers = '/bundles/app/img/marker-customers.png';

    var title = 'Community';

    var image = imageCommunity;
    if (contribution.userType === 'partner') {
        image = imagePartners;
        title = 'Partner';
    }
    if (contribution.userType === 'customer') {
        image = imageCustomers;
        title = 'Customer';
    }

    var marker = new google.maps.Marker({
        map: map,
        position: contribution.position,
        title: title,
        icon: image
    });

    var contentTemplate = _.template(info_window_template);
    var contentString = contentTemplate({
        content: Autolinker.link(contribution.content),
        mediaUrl: contribution.media,
        title: title,
        iwClass: contribution.userType
    });

    marker.addListener('click', function () {
        infowindow.setContent(contentString);
        infowindow.open(map, marker);
    });
    clusters.community.addMarker(marker);
}

$(document).ready(function (e) {
    var map = initMap();
    var clusters = initClusters(map);

    var infowindow = new google.maps.InfoWindow({
        content: ''
    });
    var var_infobox_props = {
        content: ""
        , disableAutoPan: false
        , maxWidth: 0
        , pixelOffset: new google.maps.Size(-10, 0)
        , zIndex: null
        , boxClass: "myInfobox"
        , closeBoxMargin: "0"
        , closeBoxURL: ""
        , infoBoxClearance: new google.maps.Size(20, 20)
        , visible: true
        , pane: "floatPane"
        , enableEventPropagation: false
    };

    infowindow = new InfoBox(var_infobox_props);

    google.maps.event.addListener(map, 'click', function () {
        if (infowindow) {
            infowindow.close();
        }
    });
    map.addListener('zoom_changed', function() {
        if (infowindow) {
            infowindow.close();
        }
    });

    var locations = $.get('/rest/locations').done(function (response) {
        response.forEach(function (coordinates) {
            createMarker(map, clusters, infowindow, coordinates);
        })
    });
});
