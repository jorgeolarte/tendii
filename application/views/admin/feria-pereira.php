<?php
// Carga el encabezado de la página
$this->load->view('admin/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('admin/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('admin/template/navbar'); ?>

        <img src="<?= base_url('assets/img/banner-feria-virtual-sena.png') ?>" class="img-fluid" alt="Feria Virtual de Emprendimiento SENA Risaralda 2020">
        <div class="container-fluid">
            <h1 class="mt-4">Feria Virtual de Negocios <br><small>Centro De Desarrollo Empresarial Sena (Risaralda)</small></h1>
            <p>Solicitamos tu amable colaboración indicando en el siguiente formulario su interés participar en la <mark>Feria Virtual de Negocios y Emprendimiento</mark> organizada por el <b>Centro de Desarrollo Empresarial SBDC del Sena Regional Risaralda</b> con el apoyo de nuestra la plataforma <b>Tienda Emprendedores</b>.</p>
            <p>La feria virtual de negocios se realizará durante los dias: 30 de junio y 1 ,2 3 de julio de 2020. Al participar en la feria virtual tendrás acceso a la vitrina virtual para ofertar y promocionar sus productos o servicios, podrás asistir a la rueda de negocios y acceder a mentorias individuales con profesionales de la red de emprendimiento de Risaralda.</p>
            <p>Mediante el diligenciamiento del presente formulario se autoriza de manera libre, previa, expresa y voluntaria el tratamiento de datos personales al Centro de Desarrollo Empresarial del Sena, Regional Risaralda en concordancia con lo dispuesto en la Ley 1581 de 2012 y el Decreto 1377 de 2013.</p>

            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="px-5 py-2 bg-light">
                        <?php
                        // Crear atributos
                        $attributes = array('id' => 'form_feria_virtual', 'method' => 'post');
                        // Pintar formulario
                        echo form_open('admin/feria-virtual/registrar', $attributes); ?>

                        <!-- Actividades -->
                        <div class="form-group my-5">
                            <label for="actividades "><b>¿En cuál de las actividades de la Feria Virtual Negocios y Emprendimiento te interesa participar?</b></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="actividades" value="1" <?= set_radio('actividades', '1'); ?>>
                                <label class="form-check-label" for="actividades1">
                                    Rueda de negocios
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="actividades" value="2" <?= set_radio('actividades', '2'); ?>>
                                <label class="form-check-label" for="actividades2">
                                    Mentorias personalizadas (30 minutos por emprendedor)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="actividades" value="3" <?= set_radio('actividades', '3'); ?>>
                                <label class="form-check-label" for="actividades3">
                                    Ambas
                                </label>
                            </div>
                            <small id="actividadesHelpBlock" class="form-text text-danger">
                                <?php echo form_error('actividades'); ?>
                            </small>
                        </div>

                        <!-- Permisos -->
                        <div class="form-group my-5">
                            <label for="permisos"><b>En caso de estar interesado en la rueda de negocios, por favor confirma qué tipo de registros, licencias o permisos dispones actualmente (puedes seleccionar varias opciones)</b></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permisos[]" value="1" <?= set_checkbox('permisos', '1'); ?>>
                                <label class="form-check-label" for="permisos1">
                                    Registro en Cámara de Comercio
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permisos[]" value="2" <?= set_checkbox('permisos', '2'); ?>>
                                <label class="form-check-label" for="permisos2">
                                    Registro Invima
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permisos[]" value="3" <?= set_checkbox('permisos', '3'); ?>>
                                <label class="form-check-label" for="permisos3">
                                    Registro ICA
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permisos[]" value="4" <?= set_checkbox('permisos', '4'); ?>>
                                <label class="form-check-label" for="permisos4">
                                    Registro de Marca
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permisos[]" value="5" <?= set_checkbox('permisos', '5'); ?>>
                                <label class="form-check-label" for="permisos5">
                                    Código de Barras
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permisos[]" value="6" <?= set_checkbox('permisos', '6'); ?>>
                                <label class="form-check-label" for="permisos5">
                                    Ninguno
                                </label>
                            </div>
                            <small id="permisosHelpBlock" class="form-text text-danger">
                                <?php echo form_error('permisos'); ?>
                            </small>
                        </div>

                        <!-- Productos / Servicios -->
                        <div class="form-group my-5">
                            <label for="productos"><b>En caso de estar interesado en la rueda de negocios, por favor indicanos: ¿Cuáles son los productos o servicios que puedes ofrecer en este momento? Por favor relacione aquellos que estén listos para comercializar y que ya estén cumpliendo con la normatividad legal vigente</b></label>
                            <input type="text" name="productos" id="productos" class="form-control" placeholder="Escribe tu respuesta" value="<?php echo set_value('productos'); ?>">
                            <small id="productosHelpBlock" class="form-text text-danger">
                                <?php echo form_error('productos'); ?>
                            </small>
                        </div>

                        <!-- Tipo cliente -->
                        <div class="form-group my-5">
                            <label for="cliente"><b>Si estás interesado en la rueda de negocios, por favor indica el tipo de cliente con el que le gustaria realizar negociaciones, por ejemplo: Empresas mayoristas, distribuidoras de la region, empresas manufactureras de la ciudad, etc. Nota: Esta información es de referencia y como apoyo a la gestión, pero no obliga al Sena a vincular proveedores específicos en la rueda de negocios, ya que el contacto depende del cumplimiento de los requisitos que exija cada cliente sobre el producto o servicio a comprar.</b></label>
                            <textarea name="cliente" rows="7" id="cliente" class="form-control" placeholder="Escribe tu respuesta" value="<?php echo set_value('cliente'); ?>" required></textarea>
                            <small id="clienteHelpBlock" class="form-text text-danger">
                                <?php echo form_error('cliente'); ?>
                            </small>
                        </div>

                        <!-- Mentorias -->
                        <div class="form-group my-5">
                            <label for="mentorias"><b>Si estás interesado en participar en las mentorias personalizadas por favor indicar cuales de los siguientes temas son de tu interes (seleccionar un máximo de tres temas)</b></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="1" <?= set_checkbox('mentorias', '1'); ?>>
                                <label class="form-check-label" for="mentorias1">
                                    Bioseguridad
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="2" <?= set_checkbox('mentorias', '2'); ?>>
                                <label class="form-check-label" for="mentorias2">
                                    Obtener clientes digitales
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="3" <?= set_checkbox('mentorias', '3'); ?>>
                                <label class="form-check-label" for="mentorias3">
                                    Técnicas de negociación (cierre de negocios)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="4" <?= set_checkbox('mentorias', '4'); ?>>
                                <label class="form-check-label" for="mentorias4">
                                    Asesoría empresarial
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="5" <?= set_checkbox('mentorias', '5'); ?>>
                                <label class="form-check-label" for="mentorias5">
                                    Asesoría Laboral
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="6" <?= set_checkbox('mentorias', '6'); ?>>
                                <label class="form-check-label" for="mentorias6">
                                    Asesoría Financiera
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="7" <?= set_checkbox('mentorias', '7'); ?>>
                                <label class="form-check-label" for="mentorias7">
                                    Decretos del gobierno
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="8" <?= set_checkbox('mentorias', '8'); ?>>
                                <label class="form-check-label" for="mentorias8">
                                    INVIMA
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="9" <?= set_checkbox('mentorias', '9'); ?>>
                                <label class="form-check-label" for="mentorias9">
                                    ICA
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mentorias[]" value="10" <?= set_checkbox('mentorias', '10'); ?>>
                                <label class="form-check-label" for="mentorias10">
                                    Propiedad Industrial (Registro de Marca, Derechos de Autor y Patentes)
                                </label>
                            </div>
                            <small id="mentoriasHelpBlock" class="form-text text-danger">
                                <?php echo form_error('mentorias'); ?>
                            </small>
                        </div>

                        <!-- Dudas -->
                        <div class="form-group my-5">
                            <label for="dudas"><b>Si tienes interés en los temas de mentoria personalizadas, por favor escribe las dudas concretas que tiene en los temas señalados anteriormente.</b></label>
                            <textarea name="dudas" id="dudas" rows="7" class="form-control" placeholder="Escribe tu respuesta" value="<?php echo set_value('dudas'); ?>" required></textarea>
                            <small id="dudasHelpBlock" class="form-text text-danger">
                                <?php echo form_error('dudas'); ?>
                            </small>
                        </div>

                        <!-- Boton de enviar -->
                        <div class="form-group my-5">
                            <button type="submit" id="submit_participar" class="btn btn-lg btn-success"><i class="fas fa-fire-alt"></i>&nbsp; Participar</button>
                        </div>

                        <?= form_close(); ?>

                        <script>
                            $(document).ready(function() {
                                // Validar formulario
                                $("#form_feria_virtual").validate({
                                    rules: {
                                        actividades: {
                                            required: true
                                        },
                                        permisos: {
                                            required: function() {
                                                if ($("input[name='actividades']:checked").val() != 2) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            },
                                        },
                                        productos: {
                                            required: function() {
                                                if ($("input[name='actividades']:checked").val() != 2) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            },
                                        },
                                        cliente: {
                                            required: function() {
                                                if ($("input[name='actividades']:checked").val() != 2) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            },
                                        },
                                        mentorias: {
                                            required: function() {
                                                if ($("input[name='actividades']:checked").val() != 1) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            },
                                            maxlength: 3
                                        },
                                        dudas: {
                                            required: function() {
                                                if ($("input[name='actividades']:checked").val() != 1) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            }
                                        },
                                    },
                                    messages: {
                                        actividades: {
                                            required: 'Seleccione al menos una actividad en que desea participar'
                                        },
                                        permisos: {
                                            required: 'Indica cuales registros, licencias o permisos dispones'
                                        },
                                        productos: {
                                            required: 'Ingresa el nombre de los productos'
                                        },
                                        cliente: {
                                            required: 'Indicanos cual es el tipo de cliente con quién te gustaría realizar negociaciones'
                                        },
                                        mentorias: {
                                            required: 'Elige las mentorias que te gustaría recibir',
                                            maxlength: 'Puedes seleccionar máximo {0} mentorias'
                                        },
                                        dudas: {
                                            required: '¿Qué dudas tienes sobre los temas seleccionados con anterioridad?'
                                        },
                                    },
                                    validClass: "is-valid",
                                    errorClass: "is-invalid",
                                    errorElement: "small",
                                    errorPlacement: function(error, element) {
                                        var input = document.querySelector('#' + element.attr('name') + 'HelpBlock');
                                        error.insertAfter(input);
                                    },
                                    submitHandler: function(form) {
                                        // do other things for a valid form
                                        //$('#telefono').unmask();
                                        form.submit();
                                    }
                                });
                            });
                        </script>
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