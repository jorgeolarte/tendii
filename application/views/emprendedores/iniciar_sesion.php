<?php
// Carga el encabezado de la página
$this->load->view('emprendedores/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('emprendedores/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('emprendedores/template/navbar'); ?>

        <div class="container-fluid bg-inscripcion" style="min-height: 100vh">

            <div class="row justify-content-md-center">
                <div class="col-md-6 bg-white p-4 text-center">
                    <a href="<?= site_url($this->session->userdata('ciudad')) ?>"><img class="img-fluid w-50" src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>"></a>
                    <h1 class="h3 mt-4 text-center">Iniciar sesión</h1>
                    <?php
                    $attribute = array('method' => 'post', 'id' => 'form_iniciar_sesion');
                    // Pintar formulario
                    echo form_open('iniciar-sesion', $attribute); ?>
                    <div class="form-group">
                        <label for="inputEmail" class="sr-only">Correo electrónico</label>
                        <input type="email" name="email" id="inputEmail" class="form-control form-control-lg" placeholder="Correo electrónico" value="<?php echo set_value('email'); ?>" required>
                        <small class="form-text text-danger">
                            <?php echo form_error('email'); ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="inputTelefono" class="sr-only">Teléfono celular</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text py-0 font-weight-bold"><img id="bandera" src="<?= base_url('assets/img/colombia.png') ?>">&nbsp;+<span id="prefijo">57</span></div>
                            </div>
                            <input type="password" name="telefono" id="inputTelefono" class="form-control form-control-lg" placeholder="Teléfono celular" pattern="\d*" maxlength="14" value="<?php echo set_value('telefono'); ?>" required>
                        </div>
                        <small class="form-text text-danger">
                            <?php echo form_error('telefono'); ?>
                        </small>
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-lg btn-block btn-success"><i class="fas fa-walking"></i>&nbsp; Iniciar sesión</button>
                    </div>
                    <div class="form-group mb-2">
                        <small class="text-muted"><b>¿Aún no tienes tu tienda?</b> <a href="<?= site_url('crear-tienda-online') ?>"><i class="fas fa-store"></i> Crea la tuya</a></small>
                    </div>
                    <?= form_close(); ?>
                    <script>
                        $(document).ready(function() {

                            $('#inputEmail').on('change', function() {
                                consultar_pais();
                            }).change();

                            function consultar_pais() {
                                var email = $('#inputEmail').val();
                                if (email != '') {
                                    $.ajax({
                                        url: '<?= site_url("admin/consultar-pais") ?>',
                                        method: "POST",
                                        dataType: "json",
                                        data: {
                                            email: email
                                        },
                                        success: function(data) {
                                            if (data.success) {
                                                $('#prefijo').text(data.prefijo);
                                                $('#bandera').attr('src', data.bandera);
                                                console.log(data.prefijo);
                                            }

                                        }
                                    });
                                }
                            }

                            $("#form_iniciar_sesion").validate({
                                rules: {
                                    email: {
                                        required: true,
                                        email: true
                                    },
                                    telefono: {
                                        required: true,
                                        digits: true,
                                        maxlength: 14
                                    }
                                },
                                messages: {
                                    email: {
                                        required: "Email es obligatorio",
                                        email: "Ingrese un email valido"
                                    },
                                    telefono: {
                                        required: "Número de teléfono obligatorio",
                                        digits: "Ingresa solo números",
                                        maxlength: "El teléfono máximo de 14 digitos"
                                    }
                                },
                                validClass: "is-valid",
                                errorClass: "is-invalid",
                                errorElement: "small",
                                submitHandler: function(form) {
                                    // do other things for a valid form
                                    form.submit();
                                }
                            });

                        });
                    </script>
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

$this->load->view('emprendedores/template/end');
?>