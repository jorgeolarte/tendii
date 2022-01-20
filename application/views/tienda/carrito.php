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
            <?php if (count($compras) == 0) { ?>
                <?php $this->load->view('tienda/template/sin-productos'); ?>
            <?php } else { ?>
                <?php $products = array() ?>
                <?php $bandera = false ?>
                <?php foreach ($compras as $compra) { ?>
                    <?php if ($compra['total'] > 0) { ?>
                        <?php $bandera = true ?>
                        <h1 class="h2 mt-4">Tu carrito de compra en <mark><?= $compra['ciudad']['nombre'] ?> <img class="align-top" src="<?= base_url('assets/img/banderas/' . $compra['ciudad']['bandera']) ?>"></mark></h1>
                        <p>Aquí están los productos que vas a comprar</p>
                        <div class="row my-3">
                            <div class="col-md-9">
                                <ul class="list-group">
                                    <?php foreach ($compra['detalles'] as $pos => $detalle) { ?>

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

                                        <li class="list-group-item d-flex justify-content-start align-items-center lh-condensed bg-light">
                                            <?php $imagen = 'assets/tienda/' . $detalle['logo_emprendedor'] ?>
                                            <div>
                                                <img class="rounded-circle mr-3" src="<?= image(base_url($imagen), "perfil") ?>" alt="<?= $detalle['emprendimiento_emprendedor'] ?>">
                                            </div>
                                            <div class="flex-fill">
                                                <h2 class="h3 mb-0"><?= $detalle['nombre_producto'] ?> <br><span class="small"><?= $detalle['emprendimiento_emprendedor'] ?></span></h2>
                                                <p class="small mb-0">
                                                    <?= $detalle['cantidad_detalle'] ?> productos de $<?= number_format($detalle['valor_detalle'], $this->session->userdata('pais')['decimales']) ?>
                                                </p>
                                                <p class="mb-2 font-weight-bold">Subtotal: <span class="text-success">$<?= number_format($detalle['subtotal_detalle'], $this->session->userdata('pais')['decimales']) ?></span></p>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <?php
                                                        // Atributos para agregar al formulario
                                                        $attributes = array('class' => 'form-inline', 'id' => 'form_menos_producto', 'method' => 'post');
                                                        // Campos ocultos a enviar en el formulario
                                                        $hidden = array(
                                                            'back_url' => current_url(),
                                                            'id_detalle' => $detalle['id_detalle']
                                                        );
                                                        // Pintar formulario
                                                        echo form_open($this->session->userdata('pais')['ISO'] . '/carrito/menos', $attributes, $hidden); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-info"><i class="fas fa-minus"></i></button>
                                                        <?= form_close(); ?>

                                                        <!-- Cantidad de productos -->
                                                        <span class="font-weight-bold m-2"><?= $detalle['cantidad_detalle'] ?></span>

                                                        <?php
                                                        // Atributos para agregar al formulario
                                                        $attributes = array('class' => 'form-inline', 'id' => 'form_mas_producto', 'method' => 'post');
                                                        // Campos ocultos a enviar en el formulario
                                                        $hidden = array(
                                                            'back_url' => current_url(),
                                                            'id_detalle' => $detalle['id_detalle']
                                                        );
                                                        // Pintar formulario
                                                        echo form_open($this->session->userdata('pais')['ISO'] . '/carrito/mas', $attributes, $hidden); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-success"><i class="fas fa-plus"></i></button>
                                                        <?= form_close(); ?>
                                                    </div>
                                                    <div class="float-right">
                                                        <?php
                                                        // Atributos para agregar al formulario
                                                        $attributes = array('class' => 'form-inline', 'id' => 'form_mas_producto', 'method' => 'post');
                                                        // Campos ocultos a enviar en el formulario
                                                        $hidden = array(
                                                            'back_url' => current_url(),
                                                            'id_detalle' => $detalle['id_detalle']
                                                        );
                                                        // Pintar formulario
                                                        echo form_open($this->session->userdata('pais')['ISO'] . '/carrito/borrar', $attributes, $hidden); ?>
                                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                        <?= form_close(); ?>
                                                    </div>
                                                </div>


                                            </div>

                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <?php $tooltip = ($compra['confirmar']) ? "" : "La compra debe superar los " . $pais['simbolo'] . number_format($pais['valor_minimo'], $this->session->userdata('pais')['decimales']) ?>
                                        <h5 class="card-title">Proceder al envio</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Total a pagar (<?= contar() ?> productos)</h6>

                                        <p class="card-text lead mb-0">
                                            <span class="font-weight-bold <?= ($compra['confirmar']) ? 'text-success' : 'text-danger' ?>" data-toggle="tooltip" data-placement="top" title="<?= $tooltip ?>">
                                                <?= $pais['simbolo'] ?><?= number_format($compra['total'], $this->session->userdata('pais')['decimales']) ?>

                                            </span>

                                        </p>
                                        <?php if (!$compra['confirmar']) { ?>
                                            <small class="text-center my-1 text-danger">Compra mínima de <mark><?= $pais['simbolo'] ?><?= number_format($pais['valor_minimo'], $this->session->userdata('pais')['decimales']) ?></mark></small>
                                        <?php } ?>

                                        <?php
                                        // Atributos para agregar al formulario
                                        $attributes = array(
                                            'id' => 'form_confirmar',
                                            'method' => 'post'
                                        );
                                        // Campos ocultos a enviar en el formulario
                                        $hidden = array(
                                            'back_url' => current_url(),
                                            'id_compra' => $compra['id'],
                                            'id_pais' => $compra['id_pais'],
                                            'id_ciudad' => $compra['id_ciudad']
                                        );
                                        // Pintar formulario
                                        echo form_open($this->session->userdata('pais')['ISO'] . '/carrito/confirmar', $attributes, $hidden); ?>
                                        <button type="submit" <?= ($compra['confirmar']) ? '' : 'disabled' ?> class="btn btn-lg btn-block card-link <?= ($compra['confirmar']) ? 'btn-success' : 'btn-light' ?>" data-toggle="tooltip" data-placement="top" title="<?= $tooltip ?>"><i class="fas fa-bicycle"></i>&nbsp; Enviar</button>
                                        <?= form_close(); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if ($bandera) { ?>
                    <div class="row">
                        <div class="col-auto ml-auto">
                            <div class="card border-0">
                                <div class="card-body">
                                    <a href="<?= $this->session->userdata('back_url') ?>" class="btn btn-outline-info"><i class="fas fa-store-alt"></i>&nbsp; Continuar comprando</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <script>
                    dataLayer.push({
                        "event": "checkout",
                        "ecommerce": {
                            "checkout": {
                                "actionField": {
                                    "step": 1
                                },
                                "products": <?= json_encode($products) ?>
                            }
                        }
                    });
                </script>
            <?php }  ?>

            <?php if (!$bandera) { ?>
                <?php $this->load->view('tienda/template/sin-productos'); ?>
            <?php } ?>
        </div>

        <?php $this->load->view('admin/template/footer'); ?>
    </div>


</div>
<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>