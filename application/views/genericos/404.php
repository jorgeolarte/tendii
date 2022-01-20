<?php
// Carga el encabezado de la página
$this->load->view('admin/template/header');
?>

<style>
    #notfound {
        position: relative;
        height: 100vh;
    }

    #notfound .notfound {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .notfound {
        max-width: 520px;
        width: 100%;
        line-height: 1.4;
        text-align: center;
    }

    .notfound .notfound-404 {
        position: relative;
        height: 200px;
        margin: 0px auto 20px;
        z-index: -1;
    }

    .notfound .notfound-404 h1 {
        font-size: 236px;
        font-weight: 200;
        margin: 0px;
        color: #211b19;
        text-transform: uppercase;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .notfound .notfound-404 h2 {
        font-size: 28px;
        font-weight: 400;
        text-transform: uppercase;
        color: #211b19;
        background: #fff;
        padding: 10px 5px;
        margin: auto;
        display: inline-block;
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
    }

    @media only screen and (max-width: 767px) {
        .notfound .notfound-404 h1 {
            font-size: 148px;
        }
    }

    @media only screen and (max-width: 480px) {
        .notfound .notfound-404 {
            height: 148px;
            margin: 0px auto 10px;
        }

        .notfound .notfound-404 h1 {
            font-size: 86px;
        }

        .notfound .notfound-404 h2 {
            font-size: 16px;
        }
    }
</style>

<div class="d-flex" id="wrapper">

    <?php $this->load->view('admin/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('admin/template/navbar'); ?>

        <div class="container-fluid">
            <div id="notfound">
                <div class="notfound">
                    <div class="notfound-404">
                        <h1>Oops!</h1>
                        <h2>404 - Página no encontrada</h2>
                    </div>
                    <a href="<?= site_url($this->session->userdata('pais')['ISO']) ?>" class="btn btn-primary btn-lg">
                        <img src="<?= base_url('assets/img/isotipo.png'); ?>" width="25px">&nbsp; Regresar a la tienda
                    </a>
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