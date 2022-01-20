<?php
// Carga el encabezado de la página
$this->load->view('templates/tienda/header');
// Carga el menu superior de la pagina
$this->load->view('templates/tienda/navbar');
// Encabezado del perfil
$this->load->view('emprendedores/info');
?>

<div class="container py-4">
    <div class="row justify-content-md-center">
        <div class="col-md-8 order-2 order-md-1">
            <h1 class="mb-1 h3">Vamos a crear tu tienda</h1>
            <p>Para ello diligencia el siguiente formulario</p>
            <?php
            // Crear atributos
            $attributes = array('id' => 'form_perfil');
            // Pintar formulario
            echo form_open_multipart('admin/perfil/crear', $attributes); ?>
            <div class="form-group mb-2">
                <label for="imagen" class="col-form-label">Logo *</label>
                <div id="imageresult"></div>
                <input type="file" name="imagen" id="imagen" data-jfiler-showThumbs="true" aria-describedby="imagenHelpBlock" class="form-control">
                <small id="imagenHelpBlock" class="form-text text-danger">
                    <?php echo form_error('imagen'); ?>
                </small>
                <div class="alert alert-info" role="alert">
                    <ul class="list-unstyled mb-0 small">
                    <li>La imagen debe tener un tamaño de <b>5000x5000</b> pixeles</li>
                        <li>El tamaño máximo de la imagen es de <b>5 Megas</b></li>
                    </ul>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="slug" class="col-form-label">Nombre de usuario *</label>
                <div class="input-group">
                    <input type="text" name="slug" id="slug" onchange="validar()" maxlength="30" aria-describedby="slugHelpBlock" class="form-control" placeholder="Nombre de usuario" value="<?php echo set_value('slug'); ?>" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-info" type="button" onclick="validar()"><i class="fas fa-check"></i>&nbsp; ¿Disponible?</button>
                    </div>
                </div>
                <small id="slugHelpBlock" class="form-text text-danger">
                    <?php echo form_error('slug'); ?>
                </small>
                <div class="alert alert-info small" role="alert">
                    <ul class="list-unstyled text-left mb-0">
                        <li>- El nombre de usuario es como tu arroba en <b>Instagram</b> o <b>Twitter</b></li>
                        <li>- Tus clientes podrán acceder directamente a tu perfil, ingresando a <a href="#" class="font-weight-bold">tiendaemprendedores.com/p/tuemprendimiento</a></li>
                        <li>- Una vez elegido no podras cambiarlo</li>
                    </ul>
                </div>
            </div>
            <script>
                function validar() {
                    // Obtener el slug
                    validar_nombre($('#slug').val());
                }

                function validar_nombre(slug) {
                    // Validar si lo enviaron
                    if (slug != '') {
                        $.ajax({
                            url: "<?= site_url('admin/validar_nombre') ?>",
                            dataType: "json",
                            method: "GET",
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
            </script>
            <div class="form-group mb-2">
                <label for="descripcion" class="col-form-label">Describe tu emprendimiento *</label>
                <textarea name="descripcion" id="descripcion" aria-describedby="descripcionHelpBlock" class="form-control" placeholder="Describe tu emprendimiento" rows="5" onkeyup="countChar(this)" required><?php echo set_value('descripcion'); ?></textarea>
                <small id="descripcionHelpBlock" class="form-text text-danger">
                    <?php echo form_error('descripcion'); ?>
                </small>
                <div class="alert alert-info small" role="alert">
                    <ul class="list-unstyled text-left mb-0">
                        <li>- La descripción no debe superar los <span class="font-weight-bold" id="charNum">155</span> caracteres</li>
                        <li>- Este texto aparecera en tu perfil de emprendedor</li>
                        <li>- También lo utilizaremos para posicionar tu perfil en los buscadores de internet</li>
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
            <div class="row mb-2">
                <div class="col">
                    <label for="hora_inicio" class="col-form-label">Hora inicio *</label>
                </div>
                <div class="col">
                    <input type="text" name="hora_inicio" id="hora_inicio" data-mask="00:00" aria-describedby="inicioHelpBlock" class="form-control" placeholder="Inicio operaciones" value="<?php echo set_value('hora_inicio'); ?>" required>
                    <small id="inicioHelpBlock" class="form-text text-danger">
                        <?php echo form_error('hora_inicio'); ?>
                    </small>
                </div>
                <div class="col">
                    <label for="hora_cierre" class="col-form-label">Hora cierre *</label>
                </div>
                <div class="col">
                    <input type="text" name="hora_cierre" id="hora_cierre" data-mask="00:00" aria-describedby="cierreHelpBlock" class="form-control" placeholder="Cierre operaciones" value="<?php echo set_value('hora_cierre'); ?>" required>
                    <small id="cierreHelpBlock" class="form-text text-danger">
                        <?php echo form_error('hora_cierre'); ?>
                    </small>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="alert alert-info small" role="alert">
                    <ul class="list-unstyled text-left mb-0">
                        <li>- Escribe la hora en formato militar desde 00:00 hasta las 23:59</li>
                    </ul>
                </div>
            </div>
            <div class="text-right pt-2">
                <button type="submit" id="submit_producto" class="btn btn-lg btn-primary"><i class="fas fa-store"></i>&nbsp; Crear tienda</button>
            </div>
            <?= form_close(); ?>
        </div>
        <div class="col-md-4 order-1 order-md-2 pb-3">
            <div class="alert alert-light" role="alert">
                <h3 class="h4 mb-2">Al crearla podrás</h3>
                <ul class="list-group mb-0 small">
                    <li class="list-group-item">Tener tu dirección web única <span class="small font-weight-bold"><a href="#">tiendaemprendedores.com/p/tuemprendimiento</a></span></li>
                    <li class="list-group-item">Compartir tu tienda con tus clientes para que te compren directamente.</li>
                    <li class="list-group-item">Posicionar tu emprendimiento automaticamente en Internet.</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php
// Carga los pie de página
$this->load->view('templates/main/followus');
$this->load->view('templates/tienda/footer');
?>