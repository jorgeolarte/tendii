<?php
// Carga el encabezado de la página
$this->load->view('admin/template/header');
?>

<!-- Modal para crear el perfil -->
<?php if (count($status) > 0) { ?>
    <?php if ($status['status'] == 'ok') { ?>

        <!-- Modal -->
        <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">¡Felicitaciones!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img class="img-fluid" src="https://media.giphy.com/media/xUKrrEnN9I5lnrcSMv/giphy-downsized.gif">
                        <p class="mt-4 mb-2">Tu tienda ya esta creada.</p>
                        <p class="mt-0">Ahora comparte el vinculo con clientes para que visiten y compren en tu tienda.</p>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-link"></i></div>
                            </div>
                            <input id="copiar" readonly value="<?= site_url($this->session->userdata('slug')) ?>" data-toggle="tooltip" data-placement="top" title="Clic para copiar" class="form-control">
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
        </div>
    <?php } ?>
<?php } ?>

<?php if ($es_perfil) { ?>
    <!-- Modal para habilitar el whatsapp -->
    <?php if ($this->session->userdata('emprendedor')['whatsapp'] == 0) { ?>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">¿Te gustaría recibir tus pedidos al Whatsapp?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img class="img-fluid" src="https://media.giphy.com/media/3og0IMVPaqrnGfBnZm/giphy.gif">
                        <p class="my-2">
                            <a href="<?= site_url('admin/whatsapp') ?>" class="btn btn-lg btn-block btn-success animated pulse delay-2s"><i class="fab fa-whatsapp"></i>&nbsp; Oprime aquí para activar notificaciones</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>

<div class="d-flex" id="wrapper">

    <?php if ($es_perfil) { ?>
        <!-- Mostrar el menu del emprendedor -->
        <?php $this->load->view('admin/template/sidebar'); ?>
    <?php  } else { ?>
        <!-- Mostrar el menu de la tienda -->
        <?php $this->load->view('tienda/template/sidebar'); ?>
    <?php } ?>


    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('admin/template/navbar'); ?>

        <div class="container-fluid">
            <?php $this->load->view('admin/template/perfil'); ?>

            <section id="productos" class="container-fluid py-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="<?= ($this->agent->is_mobile()) ? 'd-flex flex-column' : 'card-columns' ?>">
                            <?php $impression = array() ?>
                            <?php $viewcontent = array() ?>
                            <?php foreach ($productos as $pos => $producto) { ?>
                                <?php
                                // Array tag manager
                                array_push($impression, array(
                                    'name' => ucwords(mb_strtolower($producto['producto'])), // Name or ID is required.
                                    'id' => $producto['id_producto'],
                                    'price' => $producto['precio'],
                                    'brand' => ucwords(mb_strtolower($producto['emprendimiento'])),
                                    'category' => $producto['categoria'],
                                    //'list': 'Search Results',
                                    'position' => $pos + 1
                                ));
                                // Pixel
                                array_push($viewcontent, array(
                                    'content_name' =>  ucwords(mb_strtolower($producto['producto'])),
                                    'content_category' => $producto['categoria'],
                                    'content_ids' => $producto['id_producto'],
                                    'content_type' => 'product',
                                    'value' => $producto['precio'],
                                    'currency' => 'COP'
                                ));
                                ?>
                                <?php $data['producto'] = $producto; /* Asigna variable para pasar */ ?>

                                <?php if ($this->agent->is_mobile()) { ?>
                                    <!-- Vista celular -->
                                    <?php $this->load->view('tienda/template/producto-sm', $data); ?>
                                <?php } else { ?>
                                    <!-- Vista otro tamaño -->
                                    <?php $this->load->view('tienda/template/producto-md', $data); ?>
                                <?php } ?>
                            <?php } ?>
                            <script>
                                dataLayer.push({
                                    'ecommerce': {
                                        'currencyCode': 'COP', // Local currency is optional.
                                        'impressions': <?= json_encode($impression) ?>
                                    }
                                });
                                fbq('track', 'ViewContent', <?= json_encode($viewcontent) ?>);
                            </script>
                        </div>
                    </div>
                </div>
            </section>

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