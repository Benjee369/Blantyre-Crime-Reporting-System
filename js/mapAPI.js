document.addEventListener("DOMContentLoaded", function () {
    // Initialize the map
    const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 8,
    });

    // Initialize the Places service
    const placesService = new google.maps.places.PlacesService(map);

    // Create a marker for the selected location
    const marker = new google.maps.Marker({ map, draggable: true });

    // Listen for the dragend event on the marker
    google.maps.event.addListener(marker, 'dragend', function () {
        updateCoordinates(marker.getPosition());
    });

    // Listen for the click event on the map
    google.maps.event.addListener(map, 'click', function (event) {
        marker.setPosition(event.latLng);
        updateCoordinates(marker.getPosition());
    });

    function updateCoordinates(position) {
        // Update the input field with the new coordinates
        document.getElementById('coordinates').value = position.lat() + ', ' + position.lng();
    }
});
