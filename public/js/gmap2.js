function initialize() {

    let mapOptions, map, marker, searchBox, city;
    infoWindow = '';
    addressEl = document.querySelector('#start-search');

    latEl = document.getElementById('x-lat');
    longEl = document.getElementById('x-long');

    element = document.getElementById('map');

    mapOptions = {
        // How far the maps zooms in.
        zoom: 10,
        // Current Lat and Long position of the pin/
        // center: new google.maps.LatLng(-5.450000, 105.266670),
        center: {
            lat: data.lat,
            lng: data.long
        },
        disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
        scrollWheel: true, // If set to false disables the scrolling on the map.
        draggable: true, // If set to false , you cannot move the map around.
        // mapTypeId: google.maps.MapTypeId.HYBRID, // If set to HYBRID its between sat and ROADMAP, Can be set to SATELLITE as well.
        // maxZoom: 11, // Wont allow you to zoom more than this
        // minZoom: 9  // Wont allow you to go more up.

    };

    /**
     * Creates the map using google function google.maps.Map() by passing the id of canvas and
     * mapOptions object that we just created above as its parameters.
     *
     */
    // Create an object map with the constructor function Map()
    map = new google.maps.Map(element, mapOptions); // Till this like of code it loads up the map.

    /**
     * Creates the marker on the map
     *
     */
    marker = new google.maps.Marker({
        position: mapOptions.center,
        map: map,
        // icon: 'http://pngimages.net/sites/default/files/google-maps-png-image-70164.png',
        draggable: true
    });

    /**
     * Creates a search box
     */
    searchBox = new google.maps.places.SearchBox(addressEl);

    /**
     * When the place is changed on search box, it takes the marker to the searched location.
     */
    google.maps.event.addListener(searchBox, 'places_changed', function () {
        let places = searchBox.getPlaces(),
            bounds = new google.maps.LatLngBounds(),
            i, place, lat, long, resultArray,
            addresss = places[0].formatted_address;

        for (i = 0; place = places[i]; i++) {
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location);  // Set marker position new.
        }

        map.fitBounds(bounds);  // Fit to the bound
        map.setZoom(15); // This function sets the zoom to 15, meaning zooms to level 15.
        // console.log( map.getZoom() );

        lat = marker.getPosition().lat();
        latEl.value = lat;
        long = marker.getPosition().lng();
        longEl.value = long;

        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ latLng: marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                if (results[0]) {
                    var address = results[0].formatted_address;
                    var pin =
                        results[0].address_components[
                            results[0].address_components.length - 1
                        ].long_name;
                }
                addressEl.value = address;

                latEl.value = lat;
                longEl.value = long;

            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }

            // Closes the previous info window if it already exists
            if (infoWindow) {
                infoWindow.close();
            }

            /**
             * Creates the info Window at the top of the marker
             */
            infoWindow = new google.maps.InfoWindow({
                content: address
            });

            infoWindow.open(map, marker);
        });
    });


    /**
     * Finds the new position of the marker when the marker is dragged.
     */
    google.maps.event.addListener(marker, "dragend", function (event) {
        let lat, long, address, resultArray, citi;


        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();

        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ latLng: marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                if (results[0]) {
                    var address = results[0].formatted_address;
                    var pin =
                        results[0].address_components[
                            results[0].address_components.length - 1
                        ].long_name;
                }
                addressEl.value = address;
                latEl.value = lat;
                longEl.value = long;

            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }

            // Closes the previous info window if it already exists
            if (infoWindow) {
                infoWindow.close();
            }

            /**
             * Creates the info Window at the top of the marker
             */
            infoWindow = new google.maps.InfoWindow({
                content: address
            });

            infoWindow.open(map, marker);
        });
    });
}