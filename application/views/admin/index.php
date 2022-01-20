<?php
// Carga el encabezado de la página
$this->load->view('admin/template/header');
?>

<!-- Modal para crear el perfil -->
<?php if (!is_null($this->session->userdata('slug'))) { ?>
    <!-- Modal -->
    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">¿Deseas abrir tu propia tienda?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Al crearla podrás:</p>
                    <ul class="list-unstyled">
                        <li>- Tener tu dirección web única <span class="small font-weight-bold"><a href="#">tiendaemprendedores.com/p/tuemprendimiento</a></span></li>
                        <li>- Compartir tu tienda con tus clientes para que te compren directamente.</li>
                        <li>- Posicionar tu emprendimiento automaticamente en Internet.</li>
                    </ul>
                    <div class="text-right">
                        <a href="<?= site_url('admin/tienda/nueva'); ?>" class="btn btn-lg btn-block btn-danger"><i class="fas fa-store"></i>&nbsp; Clic para crear</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="d-flex" id="wrapper">

    <?php $this->load->view('admin/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('admin/template/navbar'); ?>

        <div class="container-fluid">
            <h1 class="mt-4">Activa todas las funciones que tenemos para ti</h1>
            <p class="mb-0">Sigue los pasos para activar tu cuenta.</p>
            <div class="py-4">
                <div class="row pt-2 align-items-center">
                    <div class="col-md-4">
                        <?php $total = $porcentajes['tienda'] + $porcentajes['ciudad'] + $porcentajes['whatsapp'] + $porcentajes['producto'] ?>
                        <div class="my-3">
                            <div class="progress mx-auto" data-value='<?= $total ?>'>
                                <span class="progress-left">
                                    <span class="progress-bar border-primary"></span>
                                </span>
                                <span class="progress-right">
                                    <span class="progress-bar border-primary"></span>
                                </span>
                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                    <div class="h2 font-weight-bold"><?= $total ?>%</div>
                                </div>
                            </div>
                            <div class="text-center pt-3 font-weight-bold">
                                Pasos para la activación
                            </div>
                        </div>
                        <script>
                            $(function() {
                                $(".progress").each(function() {
                                    var value = $(this).attr('data-value');
                                    var left = $(this).find('.progress-left .progress-bar');
                                    var right = $(this).find('.progress-right .progress-bar');

                                    if (value > 0) {
                                        if (value <= 50) {
                                            right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                                        } else {
                                            right.css('transform', 'rotate(180deg)')
                                            left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                                        }
                                    }

                                })

                                function percentageToDegrees(percentage) {
                                    return percentage / 100 * 360
                                }
                            });
                        </script>
                    </div>
                    <div class="col-md-8 pr-md-5">

                        <ul class="list-group list-group-flush">

                            <?php $class = '';
                            $link = ''; ?>
                            <?php if ($porcentajes['tienda'] == 25) {
                                $class = "disabled";
                                $link = 'text-secondary';
                            } ?>
                            <li class="lead list-group-item list-group-item-action <?= $class ?>">
                                <a href="<?= site_url('admin/tienda/nueva') ?>" class="text-decoration-none  <?= $link ?>">
                                    <div class="d-flex">
                                        <div>
                                            <span class="fa-stack fa-lg">
                                                <i class="far fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-store fa-stack-1x"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="h5 mb-0 font-weight-bold">Tu tienda en Internet</h3>
                                            <small>Crea tu tienda y empieza a vender a través de Internet</small>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php $class = '';
                            $link = ''; ?>
                            <?php if ($porcentajes['ciudad'] == 25) {
                                $class = "disabled";
                                $link = 'text-secondary';
                            } ?>
                            <li class="lead list-group-item list-group-item-action <?= $class ?>">
                                <a href="<?= site_url('admin/ciudades') ?>" class="text-decoration-none  <?= $link ?>">
                                    <div class="d-flex">
                                        <div>
                                            <span class="fa-stack fa-lg">
                                                <i class="far fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-truck-loading fa-stack-1x"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="h5 mb-0 font-weight-bold">Zona distribución</h3>
                                            <small>Configura las ciudades en las cuales puedes distribuir</small>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php $class = '';
                            $link = ''; ?>
                            <?php if ($porcentajes['whatsapp'] == 25) {
                                $class = "disabled";
                                $link = 'text-secondary';
                            } ?>
                            <li class="lead list-group-item list-group-item-action <?= $class ?>">
                                <a href="<?= site_url('admin/whatsapp') ?>" class="text-decoration-none <?= $link ?>">
                                    <div class="d-flex">
                                        <div>
                                            <span class="fa-stack fa-lg">
                                                <i class="far fa-circle fa-stack-2x"></i>
                                                <i class="fab fa-whatsapp fa-stack-1x"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="h5 mb-0 font-weight-bold">Notificaciones Whatsapp</h3>
                                            <small>Habilita las notificaciones vía Whatsapp, recibe tus pedidos inmediatamente</small>
                                            <a name="whatsapp"></a>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php $class = '';
                            $link = ''; ?>
                            <?php if ($porcentajes['producto'] == 25) {
                                $class = "disabled";
                                $link = 'text-secondary';
                            } ?>
                            <li class="lead list-group-item list-group-item-action <?= $class ?>">
                                <a href="<?= site_url('admin/producto/nuevo') ?>" class="text-decoration-none <?= $link ?>">
                                    <div class="d-flex">
                                        <div>
                                            <span class="fa-stack fa-lg">
                                                <i class="far fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-shopping-basket fa-stack-1x"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="h5 mb-0 font-weight-bold">Publicar tu primer producto</h3>
                                            <small>Publica tu primer producto</small>
                                        </div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <?php $this->load->view('admin/template/footer'); ?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php $this->load->view('admin/template/end'); // Carga el encabezado de la página 
?>