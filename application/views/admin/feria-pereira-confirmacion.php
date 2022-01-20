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
            <div class="row justify-content-md-center">
                <div class="col-md-7 py-4">
                    <div class="alert alert-success text-center" role="alert">
                        <img src="<?= base_url('assets/img/SENA-2020.png') ?>" class="img-fluid" alt="Feria Virtual SENA Risaralda 2020">
                        <h1 class="alert-heading mt-3 mb-3">¡Felicitaciones! 😎</h1>
                        <p class="mb-0">Tu solicitud para particiar en la Feria Virtual fue recibida.</p>
                        <p>En unos días te informaremos si eres elegido para participar.</p>
                        <img src="https://media.giphy.com/media/3oEjHI8WJv4x6UPDB6/giphy.gif">
                        <p><a href="<?= site_url('admin/index') ?>" class="mt-4 btn btn-lg btn-success font-weight-bold"><i class="fas fa-tachometer-alt"></i>&nbsp; Regresar al tablero</a></p>
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