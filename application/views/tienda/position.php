<html>

<head>
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
    <button id="find-me">Show my location</button><br />
    <p id="status"></p>
    <a id="map-link" target="_blank"></a>

    <script>
        function geoFindMe() {

            const status = document.querySelector('#status');
            const mapLink = document.querySelector('#map-link');

            mapLink.href = '';
            mapLink.textContent = '';

            function success(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                // Envia las coordenadas para que ubique
                coordenadas(latitude, longitude);
            }

            function error() {
                status.textContent = 'No acepto, debo direccionarlo a que seleccione el pais';
            }

            if (!navigator.geolocation) {
                status.textContent = 'Navegador muy viejo, actualice el navegador';
            } else {
                navigator.geolocation.getCurrentPosition(success, error);
            }

        }

        window.addEventListener('load', geoFindMe);
    </script>

    <script>
        function coordenadas(latitude, longitude) {
            // Instantiate a map and platform object:
            var platform = new H.service.Platform({
                'apikey': '<?= HERE_API_KEY ?>'
            });

            // Get an instance of the search service:
            var service = platform.getSearchService();

            // Call the reverse geocode method with the geocoding parameters,
            // the callback and an error callback function (called if a
            // communication error occurs):
            service.reverseGeocode({
                at: latitude+','+longitude
            }, (result) => {
                result.items.forEach((item) => {
                    // Encuentro la ciudad
                    console.log(item);
                    //console.log(item.address.city);
                    // Assumption: ui is instantiated
                    // Create an InfoBubble at the returned location with
                    // the address as its contents:
                    // ui.addBubble(new H.ui.InfoBubble(item.position, {
                    //     content: item.address.label
                    // }));
                });
            }, alert);
        }
    </script>
</body>

</html>