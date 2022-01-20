<?php
// Carga el encabezado de la página
$this->load->view('templates/tienda/header');
// Carga el menu superior de la pagina
$this->load->view('templates/tienda/navbar');
// Encabezado página
$this->load->view('templates/title');
?>

<section class="container py-4">

    <?php if (count($detalles) == 0) { ?>
        <div class="row">
            <div class="col-md-12">
                <p class="lead">No tienes productos en el carrito.</p>
                <p class="lead">Ve a la tienda para realizar tu compra</p>
                <p><a href="<?= site_url($this->session->userdata('ciudad')); ?>" class="btn btn-primary">Ir a la tienda</a></p>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-md-9 pt-2">
                <div class="table-responsive">
                    <?php $products = array() ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Producto</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Unidad</th>
                                <th scope="col">Precio</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
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
                                <tr>
                                    <?php $imagen = 'assets/tienda/' . $detalle['logo_emprendedor'] ?>
                                    <td><img class="rounded-circle" src="<?= image(base_url($imagen), "square") ?>" alt="<?= $detalle['emprendimiento_emprendedor'] ?>" width="32px"></td>
                                    <td><?= $detalle['nombre_producto'] ?> <br><span class="small"><?= $detalle['emprendimiento_emprendedor'] ?></span></td>
                                    <td>
                                        <a href="<?= site_url('carrito/menos/' . $detalle['id_detalle']) ?>" class="btn btn-outline-info"><i class="fas fa-minus"></i></a>
                                        <span class="font-weight-bold m-3"><?= $detalle['cantidad_detalle'] ?></span>
                                        <a href="<?= site_url('carrito/mas/' . $detalle['id_detalle']) ?>" class="btn btn-outline-success"><i class="fas fa-plus"></i></a>
                                    </td>
                                    <td>$<?= number_format($detalle['valor_detalle'], $this->session->userdata('pais')['decimales']) ?></td>
                                    <td class="font-weight-bold">$<?= number_format($detalle['subtotal_detalle'], $this->session->userdata('pais')['decimales']) ?></td>
                                    <th scope="row"><a href="<?= site_url('carrito/borrar/' . $detalle['id_detalle']) ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a></th>
                                </tr>
                            <?php } ?>
                            <tr class="table-success font-weight-bold">
                                <td colspan="3">&nbsp;</td>
                                <td class="font-italic">Total a pagar</td>
                                <td>$<?= number_format($compra['total'], $this->session->userdata('pais')['decimales']) ?></td>
                                <th scope="row"></th>
                            </tr>
                        </tbody>
                    </table>
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
                </div>
            </div>
            <div class="col-md-3 pt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Proceder al envio</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Subtotal (<?= contar() ?> productos)</h6>
                        <p class="card-text lead"><span class="font-weight-bold text-danger">$<?= number_format($compra['total'], $this->session->userdata('pais')['decimales']) ?></span></p>
                        <a href="<?= site_url('carrito/confirmar') ?>" class="btn btn-lg btn-warning btn-block card-link"><i class="fas fa-bicycle"></i>&nbsp; Enviar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-md-12">
                <a href="<?= $this->session->userdata('back_url') ?>" class="btn btn-outline-info"><i class="fas fa-store-alt"></i>&nbsp; Regresar a la tienda</a>
            </div>
        </div>
    <?php } ?>
</section>

<?php
// Carga los pie de página
$this->load->view('templates/tienda/footer');
?>