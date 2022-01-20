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
            <h1 class="mt-4">Vamos a crear tu tienda</h1>
            <p>Para ello diligencia el siguiente formulario</p>
            <div class="row mb-3 justify-content-md-center">
                <div class="col-md-8">
                    <?php
                    // Crear atributos
                    $attributes = array('id' => 'form_perfil');
                    // Pintar formulario
                    echo form_open_multipart('admin/tienda/crear', $attributes); ?>
                    <div class="form-group mb-2">
                        <label for="slug" class="col-form-label font-weight-bold">Nombre de usuario *</label>
                        <div class="input-group">
                            <input type="text" name="slug" id="slug" maxlength="30" aria-describedby="slugHelpBlock" class="form-control" placeholder="Nombre de usuario" value="<?php echo set_value('slug'); ?>" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-info" id="btn-slug" type="button"><i class="fas fa-check"></i>&nbsp; ¿Disponible?</button>
                            </div>
                        </div>
                        <small id="slugHelpBlock" class="form-text text-danger">
                            <?php echo form_error('slug'); ?>
                        </small>
                    </div>

                    <div class="form-group mb-2">
                        <label for="imagen" class="col-form-label font-weight-bold">Logo *</label>
                        <div id="imageresult"></div>
                        <input type="file" name="imagen" id="imagen" aria-describedby="imagenHelpBlock" class="form-control">
                        <!-- <input type="file" name="imagen" id="imagen" data-jfiler-showThumbs="true" aria-describedby="imagenHelpBlock" class="form-control"> -->
                        <small id="imagenHelpBlock" class="form-text text-danger">
                            <?php echo form_error('imagen'); ?>
                        </small>
                        <div class="alert alert-info" role="alert">
                            <ul class="list-unstyled mb-0 small">
                                <li>El tamaño del archivo debe ser inferior a <mark>5MB</mark></li>
                                <li>La extensión de la imagen debe ser <mark>jpg</mark> o <mark>png</mark></li>
                                <li>El tamaño minimo debe ser de <mark>500x500</mark> pixeles</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="descripcion" class="col-form-label font-weight-bold">Describe tu emprendimiento *</label>
                        <textarea name="descripcion" id="descripcion" aria-describedby="descripcionHelpBlock" class="form-control" placeholder="Describe tu emprendimiento" rows="5" onkeyup="countChar(this)" required><?php echo set_value('descripcion'); ?></textarea>
                        <small id="descripcionHelpBlock" class="form-text text-danger">
                            <?php echo form_error('descripcion'); ?>
                        </small>
                        <div class="alert alert-info small" role="alert">
                            <ul class="list-unstyled text-left mb-0">
                                <li>La descripción no debe superar los <mark><span class="font-weight-bold" id="charNum">155</span></mark> caracteres</li>
                            </ul>
                        </div>
                    </div>
                    <script>
                        function countChar(val) {
                            var len = val.value.length;
                            if (len >= 155) {
                                val.value = val.value.substring(0, 155);
                            } else {
                                $('#charNum').text(155 - len);
                            }
                        };
                    </script>

                    <div class="d-flex">
                        <div class="form-group mb-0 flex-fill">
                            <label for="hora_inicio" class="col-form-label font-weight-bold">Hora inicio *</label>
                            <select name="hora_inicio" id="hora_inicio" class="form-control">
                                <?php $horas = array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"); ?>
                                <?php $minutos = array("00", "15", "30", "45"); ?>
                                <?php foreach ($horas as $hora) { ?>
                                    <?php foreach ($minutos as $minuto) { ?>
                                        <option value="<?= $hora ?>:<?= $minuto ?>"><?= $hora ?>:<?= $minuto ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="form-group mb-0 flex-fill">
                            <label for="hora_cierre" class="col-form-label font-weight-bold">Hora cierre *</label>
                            <select name="hora_cierre" id="hora_cierre" class="form-control">
                                <?php foreach ($horas as $hora) { ?>
                                    <?php foreach ($minutos as $minuto) { ?>
                                        <option value="<?= $hora ?>:<?= $minuto ?>"><?= $hora ?>:<?= $minuto ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                    <div>
                        <small id="inicioHelpBlock" class="form-text text-danger">
                            <?php echo form_error('hora_inicio'); ?>
                        </small>
                        <small id="cierreHelpBlock" class="form-text text-danger">
                            <?php echo form_error('hora_cierre'); ?>
                        </small>
                    </div>
                    <div class="form-group mb-2">
                        <div class="alert alert-info small" role="alert">
                            <ul class="list-unstyled text-left mb-0">
                                <li>Selecciona la hora en formato militar desde 00:00 hasta las 23:59</li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-right pt-2">
                        <button type="submit" id="submit_producto" class="btn btn-lg btn-primary"><i class="fas fa-store"></i>&nbsp; Crear tienda</button>
                    </div>
                    <?= form_close(); ?>
                    <script>
                        $(document).ready(function() {

                            jQuery.validator.addMethod("filesize", function(value, element, param) {
                                return this.optional(element) || (element.files[0].size <= param)
                            }, 'El tamaño del archivo debe ser inferior a 5MB');

                            jQuery.validator.addMethod('dimention', function(value, element, param) {
                                if (element.files.length == 0) {
                                    return true;
                                }
                                var width = $(element).data('imageWidth');
                                var height = $(element).data('imageHeight');
                                if (width >= param[0] && height >= param[1]) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }, 'Cargue una imagen con una dimensión mínima de {0} x {1} píxeles');

                            $('#imagen').change(function() {
                                $('#imagen').removeData('imageWidth');
                                $('#imagen').removeData('imageHeight');
                                var file = this.files[0];
                                var tmpImg = new Image();
                                tmpImg.src = window.URL.createObjectURL(file);
                                tmpImg.onload = function() {
                                    width = tmpImg.naturalWidth,
                                        height = tmpImg.naturalHeight;
                                    $('#imagen').data('imageWidth', width);
                                    $('#imagen').data('imageHeight', height);
                                }
                            });

                            $('#btn-slug').on('click', function() {
                                validar_nombre();
                            });

                            $('#slug').on('change', function() {
                                validar_nombre();
                            }).change();

                            function validar_nombre() {
                                var slug = $('#slug').val();
                                if (slug != '') {
                                    $.ajax({
                                        url: "<?= site_url('admin/validar_nombre') ?>",
                                        dataType: "json",
                                        method: "POST",
                                        data: {
                                            slug: slug
                                        }
                                    }).done(function(response) {
                                        if (response.success) {
                                            $('#slug').removeClass("is-invalid");
                                            $('#slug').addClass("is-valid");
                                            $('#slugHelpBlock').addClass("text-success");
                                            $('#slugHelpBlock').removeClass("text-danger");
                                            $('#slugHelpBlock').text(response.message);
                                        } else {
                                            $('#slug').removeClass("is-valid");
                                            $('#slug').addClass("is-invalid");
                                            $('#slugHelpBlock').removeClass("text-success");
                                            $('#slugHelpBlock').addClass("text-danger");
                                            $("#slugHelpBlock").text(response.message);
                                        }
                                    });
                                }
                            }

                            $("#form_perfil").validate({
                                rules: {
                                    imagen: {
                                        required: true,
                                        extension: "jpg|jpeg|png",
                                        filesize: 5000000,
                                        dimention: [500, 500]
                                    },
                                    slug: {
                                        required: true,
                                    },
                                    descripcion: {
                                        required: true,
                                        minlength: 50,
                                        maxlength: 155
                                    },
                                    hora_inicio: {
                                        required: true
                                    },
                                    hora_cierre: {
                                        required: true
                                    },
                                },
                                messages: {
                                    imagen: {
                                        required: "Selecciona una imagen",
                                        extension: "La extensión de la imagen debe ser jpg o png",
                                        filesize: "El tamaño del archivo debe ser inferior a 5MB",
                                        dimention: "Cargue una imagen con una dimensión mínima de {0} x {1} píxeles"
                                    },
                                    slug: {
                                        required: "Nombre de usuario es obligatorio"
                                    },
                                    descripcion: {
                                        required: "La descripción es obligatoria",
                                        minlength: jQuery.validator.format("Al menos debe tener {0} caracteres"),
                                        maxlength: jQuery.validator.format("No debe pasar de {0} caracteres")
                                    },
                                    hora_inicio: {
                                        required: "Ingresa la hora de inicio"
                                    },
                                    hora_cierre: {
                                        required: "¿Hasta que hora entregas domicilios?"
                                    },
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