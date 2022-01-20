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
            <h1 class="mt-4">Producto agregado</h1>
            <p>Felicitaciones, has agregado este producto a tu carrito de compras</p>
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <?php foreach ($detalles as $detalle) { ?>
                        <script>
                            // Measure adding a product to a shopping cart by using an 'add' actionFieldObject
                            // and a list of productFieldObjects.
                            dataLayer.push({
                                'event': 'addToCart',
                                'ecommerce': {
                                    'currencyCode': 'COP',
                                    'add': { // 'add' actionFieldObject measures.
                                        'products': [{ //  adding a product to a shopping cart.
                                            'name': '<?= ucwords(mb_strtolower($detalle['nombre_producto'])) ?>',
                                            'id': <?= $detalle['id_producto'] ?>,
                                            'price': '<?= $detalle['valor_detalle'] ?>',
                                            'brand': '<?= ucwords(mb_strtolower($detalle['emprendimiento_emprendedor'])) ?>',
                                            'category': '<?= $detalle['nombre_categoria'] ?>',
                                            'quantity': <?= $detalle['cantidad_detalle'] ?>
                                        }]
                                    }
                                }
                            });
                            fbq('track', 'AddToCart', {
                                content_name: '<?= ucwords(mb_strtolower($detalle['nombre_producto'])) ?>',
                                content_category: '<?= $detalle['nombre_categoria'] ?>',
                                content_ids: ['<?= $detalle['id_producto'] ?>'],
                                content_type: 'product',
                                value: <?= $detalle['valor_detalle'] ?>,
                                currency: 'COP'
                            });
                        </script>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-start align-items-center lh-condensed bg-light">
                                <?php $imagen = 'assets/tienda/' . $detalle['logo_emprendedor'] ?>
                                <div>
                                    <img class="rounded-circle mr-3" src="<?= image(base_url($imagen), "perfil") ?>" alt="<?= $detalle['emprendimiento_emprendedor'] ?>">
                                </div>
                                <div>
                                    <h2 class="h3 mb-0"><?= $detalle['nombre_producto'] ?> <br><span class="small"><?= $detalle['emprendimiento_emprendedor'] ?></span></h2>
                                    <p class="small mb-0">
                                        <?= $detalle['cantidad_detalle'] ?> productos de $<?= number_format($detalle['valor_detalle'], $this->session->userdata('pais')['decimales']) ?>
                                    </p>
                                    <p class="mb-2 font-weight-bold">Subtotal del carrito: <span class="text-success">$<?= number_format($detalle['subtotal_detalle'], $this->session->userdata('pais')['decimales']) ?></span></p>
                                    <a href="<?= site_url($this->session->userdata('pais')['ISO'] . '/carrito') ?>" class="btn btn-danger">Ir al carrito ( <i class="fas fa-shopping-cart"></i>&nbsp;<span id="contador" count="<?= contar() ?>" class="badge"><?= contar() ?></span> )</a>
                                    <a href="<?= $this->session->userdata('back_url') ?>" class="btn btn-outline-info"><i class="fas fa-store-alt"></i>&nbsp; Continuar comprando</a>
                                </div>
                                <div>

                                </div>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
            <?php $this->load->view('admin/template/footer'); ?>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>