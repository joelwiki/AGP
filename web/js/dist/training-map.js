function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: new google.maps.LatLng(45.189, 5.724),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(45.189, 5.724),
        draggable: true
    });

    var input = document.getElementById('training_location');

    var autocomplete = new google.maps.places.Autocomplete(input);

    // Bind the map's bounds (viewport) property to the autocomplete object,
    // so that the autocomplete requests use the current map bounds for the
    // bounds option in the request.
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);

    google.maps.event.addListener(marker, 'dragend', function(evt){
        var lat = document.getElementById('training_lat').value = evt.latLng.lat().toFixed(5);
        var lng = document.getElementById('training_lng').value = evt.latLng.lng().toFixed(5);
        $(function(){
            $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng +'&sensor=true', function(data) {
                document.getElementById('training_location').value = data['results'][0]['formatted_address'];
            });
        });
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("Aucun résultat pour : '" + place.name + "'");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(14);
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();

        document.getElementById('training_lat').value = lat.toFixed(5);
        document.getElementById('training_lng').value = lng.toFixed(5);

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-address'].textContent = address;
        infowindow.open(map, marker);
    });

    map.setCenter(marker.position);
    marker.setMap(map);
}