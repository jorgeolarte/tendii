<?php
// Carga el encabezado de la página
$this->load->view('templates/tienda/header');
// Carga el menu superior de la pagina
$this->load->view('templates/tienda/navbar');
// Encabezado página
$this->load->view('templates/title');
?>

<section class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
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
                            <tr class="table-primary">
                                <?php $imagen = 'assets/tienda/' . $detalle['logo_emprendedor'] ?>
                                <td class="text-primary lead"><i class="fas fa-check"></i></td>
                                <td><img class="rounded-circle" src="<?= image(base_url($imagen), "square") ?>" alt="<?= $detalle['emprendimiento_emprendedor'] ?>" width="32px"></td>
                                <td><?= $detalle['nombre_producto'] ?> <br><span class="small"><?= $detalle['emprendimiento_emprendedor'] ?></span></td>
                                <td>
                                    <p class="mb-0 font-italic">Producto agregado al carrito</p>
                                    <p class="mb-0 font-weight-bold">Subtotal del carrito: <span class="text-danger">$<?= number_format($detalle['subtotal_detalle'], $this->session->userdata('pais')['decimales']) ?></span></p>
                                    <p class="small mb-0">
                                        <?= $detalle['cantidad_detalle'] ?> productos de $<?= number_format($detalle['valor_detalle'], $this->session->userdata('pais')['decimales']) ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">
                                    <div class="btn-group">
                                        <a href="<?= $this->session->userdata('back_url') ?>" class="btn btn-outline-info"><i class="fas fa-store-alt"></i>&nbsp; Continuar comprando</a>
                                        <a href="<?= site_url('carrito') ?>" class="btn btn-danger"> Ir al carrito ( <i class="fas fa-shopping-cart"></i>&nbsp;<span id="contador" count="<?= contar() ?>" class="badge"><?= contar() ?></span> )</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php
// Carga los pie de página
$this->load->view('templates/tienda/footer');
?>