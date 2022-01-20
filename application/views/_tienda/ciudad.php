<?php
// Carga el encabezado de la página
$this->load->view('templates/emprendedores/header-nuevo');
?>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6 p-5 bg-white text-center">
            <a href="<?= site_url($this->session->userdata('ciudad')) ?>"><img class="mb-4 img-fluid w-75" src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>"></a>
            <h1 class="mb-3 h4">En que ciudad te encuentras</h1>
            <div class="list-group text-left">
                <?php foreach ($ciudades as $pos => $ciudad) { ?>
                    <a href="<?= site_url($ciudad['slug']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <img src="<?= base_url('assets/img/banderas/' . $ciudad['bandera']) ?>" alt="<?= $ciudad['nombre'] ?>">&nbsp; <?= $ciudad['nombre'] ?>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php } ?>
            </div>
            <p class="pt-3 mb-0">¿No encuentras tu ciudad?</p>
            <p class="mb-2">Se el primer emprendedor de ella</p>
            <a href="<?= site_url('/crear-tienda-online') ?>" class="btn btn-lg btn-danger"><i class="fa fa-user fa-fw"></i>&nbsp; Regístrate</a>
        </div>
    </div>
</div>

<?php
// Carga los pie de página
$this->load->view('templates/tienda/footer-login');
?>