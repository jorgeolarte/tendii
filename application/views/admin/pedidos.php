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
            <?php if (count($pedidos) == 0) { ?>
                <div class="row justify-content-md-center">
                    <div class="col-md-8 py-4">
                        <!-- No tienes pedidos -->
                        <div class="alert alert-danger text-center" role="alert">
                            <h4 class="alert-heading">Oops! 🙈</h4>
                            <p>Aún no recibes pedidos en la tienda.</p>
                            <img src="https://media.giphy.com/media/K1QnLV1caRpuw/giphy-downsized.gif">
                            <hr>
                            <p class="mb-1">Te invitamos a compartir tu tienda con tus clientes.</p>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-link"></i></div>
                                </div>
                                <input id="copiar" readonly value="<?= site_url($this->session->userdata('emprendedor')['slug']) ?>" data-toggle="tooltip" data-placement="top" title="Clic para copiar" class="form-control">
                            </div>
                            <script>
                                $("#copiar").click(function() {
                                    $(this).focus();
                                    $(this).select();
                                    /* Copy the text inside the text field */
                                    document.execCommand("copy");
                                    /* Alert the copied text */
                                    alert("URL copiada: " + $(this).attr("value"));
                                });
                            </script>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <!-- tienes pedidos -->
                <h1 class="mt-4">Listado de pedidos</h1>
                <p>Aquí estan los clientes que te han pedido</p>
                <div class="row">
                    <div class="col-12">
                        <div class="card-columns">
                            <?php foreach ($pedidos as $pedido) { ?>
                                <div class="card" id="cliente_<?= $pedido['id_cliente'] ?>">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <img class="rounded-circle w-25" src="<?= base_url('assets/tienda/default.jpg') ?>">
                                            <h5 class="card-title">
                                                <?= $pedido['cliente'] ?><br>
                                                <small class="text-muted"><i class="fas fa-phone"></i> <?= $pedido['telefono'] ?></small>
                                            </h5>
                                        </div>

                                        <p class="card-text mb-1">
                                            <span class="font-weight-bold">Dirección de entrega</span>
                                        </p>
                                        <ul class="mt-0 list-unstyled">
                                            <li><i class="fas fa-map-marker-alt"></i> <?= $pedido['ciudad'] ?></li>
                                            <li><i class="fas fa-road"></i> <?= $pedido['barrio'] ?></li>
                                            <li><i class="fas fa-home"></i> <?= $pedido['direccion'] ?></li>
                                        </ul>
                                        <a href="<?= site_url('admin/pedido/' . $pedido['id_compra']) ?>" class="btn btn-block btn-primary"><i class="fas fa-box-open"></i> Abrir pedido</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
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