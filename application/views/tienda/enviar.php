<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('tienda/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('tienda/template/navbar'); ?>

        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-md-8 py-4">
                    <!-- No tienes pedidos -->
                    <div class="alert alert-info text-center" role="alert">
                        <h4 class="alert-heading">Perfecto! 👍</h4>
                        <p>Recibimos tu pedido.</p>
                        <img class="img-fluid" src="https://media.giphy.com/media/7kn27lnYSAE9O/giphy.gif">
                        <hr>
                        <p class="mb-1">Estamos notificando al emprendedor para que te haga entrega de los productos en la puerta de tu casa.</p>
                        <a href="<?= site_url() ?>" class="btn btn-lg btn-info"><i class="fas fa-store"></i> Continuar visitando la tienda</a>
                    </div>
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
    </div>
</div>
<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>