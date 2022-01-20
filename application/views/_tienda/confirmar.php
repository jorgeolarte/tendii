<?php
// Carga el encabezado de la página
$this->load->view('templates/tienda/header');
// Carga el menu superior de la pagina
$this->load->view('templates/tienda/navbar');
// Encabezado página
$this->load->view('templates/title');
?>

<section class="container py-4">
    <?php
    // Crear atributos
    $attributes = array('id' => 'form_confirmar');
    // Pintar formulario
    echo form_open('carrito/enviar', $attributes); ?>
    <!-- Datos del cliente -->
    <div class="row">
        <div class="col-md-9 order-md-1 bg-light">
            <div class="row p-5">
                <div class="col-md-6">
                    <h2>Tus datos</h2>
                    <div class="form-group mb-2">
                        <label for="nombre" class="col-form-label">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Tu nombre completo" value="<?php echo set_value('nombre'); ?>" required>
                        <small class="form-text text-muted">
                            <?php echo form_error('nombre'); ?>
                        </small>
                    </div>
                    <div class="form-group mb-2">
                        <label for="telefono" class="col-form-label">Teléfono *</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text py-0 font-weight-bold"><img src="<?= base_url('assets/img/colombia.png') ?>">&nbsp;+57</div>
                            </div>
                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono de contacto" value="<?php echo set_value('telefono'); ?>" data-mask="000 000 0000" required>
                        </div>
                        <small class="form-text text-danger">
                            <?php echo form_error('telefono'); ?>
                        </small>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email" class="col-form-label">Correo electrónico *</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Correo electrónico" value="<?php echo set_value('email'); ?>" required>
                        <small class="form-text text-danger">
                            <?php echo form_error('email'); ?>
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>Dirección de entrega</h2>
                    <div class="form-group mb-2">
                        <label for="barrio" class="col-form-label">Barrio *</label>
                        <input type="text" name="barrio" id="barrio" class="form-control" placeholder="Barrio donde se debe entregar" value="<?php echo set_value('barrio'); ?>" required>
                        <small class="form-text text-danger">
                            <?php echo form_error('barrio'); ?>
                        </small>
                    </div>
                    <div class="form-group mb-2">
                        <label for="direccion" class="col-form-label">Dirección *</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección de entrega" value="<?php echo set_value('direccion'); ?>" required>
                        <small class="form-text text-danger">
                            <?php echo form_error('direccion'); ?>
                        </small>
                    </div>
                    <div class="form-group mb-2">
                        <label for="observaciones" class="col-form-label">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" placeholder="¿Tienes alguna observación acerca de la entrega?" rows="5" value="<?php echo set_value('observaciones'); ?>"></textarea>
                    </div>
                    <div class="text-right pt-2">
                        <button type="submit" id="submit_confirmar" class="btn btn-lg btn-danger"><i class="fas fa-shopping-basket"></i>&nbsp; Confirmar pedido</button>
                        <small class="form-text text-muted">
                            <ul class="list-unstyled pt-2">
                                <li>Los campos con asterisco (*) son obligatorios</li>
                                <li>No compartimos tu información con terceros</li>
                                <li>Tus datos están ha salvo con nosotros</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 order-md-2 p-5">
            <h3>Tu carrito</h3>
            <ul class="list-group">
                <?php $products = array() ?>
                <?php foreach ($detalles as $pos => $detalle) { ?>
                    <?php
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
                    ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="mb-0"><?= ucfirst(mb_strtolower($detalle['nombre_producto'])); ?></h6>
                            <small class="text-muted"><?= ucwords(mb_strtolower($detalle['emprendimiento_emprendedor'])); ?></small>
                        </div>
                        <span class="text-muted">$<?= number_format($detalle['subtotal_detalle'], $this->session->userdata('pais')['decimales']); ?></span>
                    </li>
                <?php } ?>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <span>Total</span>
                    <strong class="text-success">$<?= number_format($detalles[0]['total_compra'], $this->session->userdata('pais')['decimales']) ?></strong>
                </li>
            </ul>
            <script>
                dataLayer.push({
                    "event": "checkout",
                    "ecommerce": {
                        "checkout": {
                            "actionField": {
                                "step": 2
                            },
                            "products": <?= json_encode($products) ?>
                        }
                    }
                });
            </script>
        </div>
    </div>
    <?= form_close(); ?>
</section>

<?php
// Carga los pie de página
$this->load->view('templates/tienda/footer');
?>