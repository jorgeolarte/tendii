<?php
// Carga el encabezado de la página
$this->load->view('templates/tienda/header');
// Carga el menu superior de la pagina
$this->load->view('templates/tienda/navbar');
// Encabezado página
//$this->load->view('templates/title');
?>

<section class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1>¡Pedido recibido!</h1>
                <p class="lead">Estamos notificando a los emprendedores sobre tu pedido.</p>
                <hr class="my-4">
                <p>Pronto se comunicaran contigo para entregarte el pedido de acuerdo a la dirección que indicaste.</p>
                <p class="lead">
                    <a class="btn btn-info btn-lg" href="<?= site_url($this->session->userdata('ciudad')) ?>" role="button"><i class="fas fa-store-alt"></i>&nbsp; Regresa a la tienda</a>
                </p>
            </div>
        </div>
    </div>
    <?php $products = array() ?>
    <?php foreach ($detalles as $pos => $detalle) {
        // Array tag manager
        $data = array(
            "id" => $detalle['id_producto'],
            "name" => ucwords(mb_strtolower($detalle['nombre_producto'])),
            "price" => $detalle['valor_detalle'],
            "brand" => ucwords(mb_strtolower($detalle['emprendimiento_emprendedor'])),
            "category" => $detalle['nombre_categoria'],
            'position' => $pos + 1,
            "quantity" => $detalle['cantidad_detalle']
        );
        array_push($products, $data);
    } ?>

    <script>
        dataLayer.push({
            "event": "transaction",
            "ecommerce": {
                "purchase": {
                    "actionField": {
                        "id": "<?= $detalles[0]['id_compra'] ?>",
                        "affiliation": "Tienda Emprendedores",
                        "revenue": <?= $detalles[0]['total_compra'] ?>,
                        "tax": 0,
                        "shipping": 0
                    },
                    "products": <?= json_encode($products) ?>
                }
            }
        });
    </script>
</section>

<?php
// Carga los pie de página
$this->load->view('templates/tienda/footer');
?>