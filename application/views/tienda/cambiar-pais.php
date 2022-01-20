<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/header');
?>

<style>
    .vertical-center {
        min-height: 100%;
        /* Fallback for browsers do NOT support vh unit */
        min-height: 100vh;
        /* These two lines are counted as one :-)       */

        display: flex;
        align-items: center;
    }
</style>

<div class="bg-primary vertical-center">
    <div class="container text-center">
        <div class="d-flex flex-column justify-content-center  animated fadeIn delay-1s slower">
            <div class="pb-2">
                <img class="img-fluid w-50" src="<?= base_url('assets/img/logo-emprendedores.png') ?>" alt="Tienda Emprendedores">
            </div>
            <div class="text-center text-white">
                <span class="">Cargando </span>
                <div class="spinner-grow" style="width: 1rem; height: 1rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow" style="width: 1rem; height: 1rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow" style="width: 1rem; height: 1rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function geoFindMe() {

        function success(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            // Envia las coordenadas para que ubique
            coordenadas(latitude, longitude);
        }

        function error() {
            // Enviaron la direccion
            var delay = 750;
            var url = '<?= site_url($iso) ?>';
            setTimeout(function() {
                window.location = url;
            }, delay);
            console.log('No podemos obtener su ubicación');
            // status.textContent = 'No acepto, debo direccionarlo a que seleccione el pais';
        }

        if (!navigator.geolocation) {
            status.textContent = 'Navegador muy viejo, actualiza tu versión';
        } else {
            navigator.geolocation.getCurrentPosition(success, error);
        }

    }

    window.addEventListener('load', geoFindMe);

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
            at: latitude + ',' + longitude
        }, (result) => {
            result.items.forEach((item) => {
                // Encuentro la ciudad
                $.ajax({
                    url: '<?= site_url("pais/redireccionar") ?>',
                    method: "POST",
                    data: {
                        iso2: '<?= $iso2 ?>',
                        ciudad: item.address.city
                    },
                    success: function(data) {
                        // Direccion donde se debe direccionar
                        var url = (data == '') ? '<?= site_url($iso) ?>' : data;
                        var delay = 750;
                        setTimeout(function() {
                            window.location = url;
                        }, delay);
                    }
                });
            });
        }, alert);
    }
</script>

<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/end');
?>