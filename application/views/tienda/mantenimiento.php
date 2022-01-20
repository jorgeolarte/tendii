<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php //$this->load->view('tienda/template/sidebar'); 
    ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php //$this->load->view('tienda/template/navbar'); 
        ?>


        <style>
            .loading:after {
                overflow: hidden;
                display: inline-block;
                vertical-align: bottom;
                -webkit-animation: ellipsis steps(4, end) 1500ms infinite;
                animation: ellipsis steps(4, end) 1500ms infinite;
                content: "\2026";
                /* ascii code for the ellipsis character */
                width: 0px;
            }

            @keyframes ellipsis {
                to {
                    width: 20px;
                }
            }

            @-webkit-keyframes ellipsis {
                to {
                    width: 20px;
                }
            }
        </style>
        <div class="container-fluid vh-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-md-6">


                    <!-- No tienes pedidos -->
                    <div class="alert alert-primary text-center p-5 " role="alert">
                        <!-- <img src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>" class="w-50"> -->
                        <h4 class="pt-3 font-weight-bold alert-heading loading">Actualizando plataforma</h4>
                        <p class="mb-2 lead">Lo sentimos, en este momento nos encontramos actualizando nuestra plataforma.</p>
                        <img class="img-fluid" src="https://media.giphy.com/media/g01ZnwAUvutuK8GIQn/source.gif">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>