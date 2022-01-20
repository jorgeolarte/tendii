<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('tienda/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('tienda/template/navbar'); ?>

        <?php $this->load->view('genericos/slider'); ?>

        <div class="container-fluid">
            <h1 class="mt-4">Conoce sobre nuestros emprendedores</h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-columns">
                        <?php foreach ($tiendas as $tienda) { ?>
                            <div class="card text-center">
                                <img class="pt-3 img-fluid mx-auto rounded-circle" src="<?= image(base_url('assets/tienda/' . $tienda['logo']), 'perfil') ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $tienda['emprendimiento'] ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= $tienda['nombre'] ?></h6>
                                    <p class="card-text"><?= $tienda['descripcion'] ?></p>
                                    <a href="<?= site_url($tienda['slug']) ?>" class="btn btn-outline btn-success"><i class="fas fa-store"></i>&nbsp; Visitar tienda</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row pt-4">
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <?= $pagination ?>
                    </nav>
                </div>
            </div>
            <?php $this->load->view('tienda/template/footer'); ?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>