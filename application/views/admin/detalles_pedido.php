<?php
// Carga el encabezado de la página
$this->load->view('admin/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('admin/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('admin/template/navbar'); ?>

        <div class="container-fluid">
            <h1 class="mt-4">Detalle del pedido</h1>
            <p>Te compartimos la información completa del pedido</p>
            <div class="row">
                <div class="col-md-9 order-md-2">
                    <ul class="list-group mb-3">
                        <?php $total = 0; ?>
                        <?php foreach ($detalles as $detalle) { ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="mb-0"><?= $detalle['producto'] ?></h6>
                                    <small class="text-muted">Cantidad de <?= $detalle['cantidad'] ?> por valor de $<?= number_format($detalle['valor_unitario'], $this->session->userdata('pais')['decimales']) ?></small>
                                </div>
                                <span class="font-weight-bold text-success">$<?= number_format($detalle['subtotal'], $this->session->userdata('pais')['decimales']) ?></span>
                                <?php $total += $detalle['subtotal'] ?>
                            </li>
                        <?php } ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <span class="font-weight-bold">Total</span>
                            <strong class="text-success">$<?= number_format($total, $this->session->userdata('pais')['decimales']) ?></strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 order-md-1">
                    <div class="card mb-2" id="cliente_<?= $cliente['id_cliente'] ?>">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <img class="rounded-circle w-25" src="<?= base_url('assets/tienda/default.jpg') ?>">
                                <h5 class="card-title">
                                    <?= $cliente['cliente'] ?><br>
                                    <small class="text-muted"><i class="fas fa-phone"></i> <?= $cliente['telefono'] ?></small>
                                </h5>
                            </div>

                            <p class="card-text mb-1">
                                <span class="font-weight-bold">Dirección de entrega</span>
                            </p>
                            <ul class="my-0 list-unstyled">
                                <li><i class="fas fa-map-marker-alt"></i> <?= $cliente['ciudad'] ?></li>
                                <li><i class="fas fa-road"></i> <?= $cliente['barrio'] ?></li>
                                <li><i class="fas fa-home"></i> <?= $cliente['direccion'] ?></li>
                            </ul>
                        </div>
                        <?php if (!empty($cliente['observaciones'])) { ?>
                            <div class="card-footer text-muted">
                                <p class="card-text mb-1">
                                    <span class="font-weight-bold"><i class="fas fa-user-edit"></i> Obervaciones</span>
                                </p>
                                <ul class="my-0 list-unstyled">
                                    <li><?= $cliente['observaciones'] ?></li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php $this->load->view('admin/template/footer'); ?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('admin/template/end');
?>