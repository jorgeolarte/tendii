<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('tienda/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('tienda/template/navbar'); ?>

        <div class="container-fluid bg-inscripcion">

            <div class="row justify-content-md-center">
                <div class="col-md-6 bg-white p-4 text-center">
                    <a href="<?= site_url($this->session->userdata('ciudad')) ?>"><img class="img-fluid w-50" src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>"></a>
                    <h1 class="h3 mt-4 text-center">Elije tu ciudad</h1>
                    <div class="list-group text-left">
                        <?php foreach ($ciudades as $pos => $ciudad) { ?>
                            <a href="<?= site_url($this->session->userdata('pais')['ISO'] . '/' .$ciudad['slug']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
                                <div>
                                    <img src="<?= base_url('assets/img/banderas/' . $ciudad['bandera']) ?>" alt="<?= $ciudad['nombre'] ?>">&nbsp; <?= $ciudad['nombre'] ?>
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php //$this->load->view('tienda/template/footer'); 
            ?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>