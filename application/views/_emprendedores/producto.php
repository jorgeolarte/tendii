<?php
// Carga el encabezado de la página
$this->load->view('templates/emprendedores/header');
// Carga el menu superior de la pagina
$this->load->view('templates/tienda/navbar');
// Encabezado página
//$this->load->view('templates/title');
// Encabezado del perfil
$this->load->view('emprendedores/info');
?>

<section class="container py-4">
    <div class="row justify-content-md-center">
        <div class="col-md-4 order-1 order-md-2 pb-3">
            <div class="alert alert-light" role="alert">
                <h3 class="h4 mb-2">Recomendaciones antes de crear un producto</h3>
                <ul class="list-group mb-0 small">
                    <li class="list-group-item list-group-item-success">Sube una imagen ganadora y provocativa de tu producto.</li>
                    <li class="list-group-item list-group-item-danger">
                        Se eliminaran los productos que publiquen información de contacto como <strong>teléfono o email.</strong>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-8 order-2 order-md-1">
            <?php
            // Crear atributos
            $attributes = array('id' => 'form_producto', 'class' => "");
            // Pintar formulario
            echo form_open_multipart('admin/producto/crear', $attributes); ?>
            <h2 class="h3">Información del producto</h2>
            <div class="form-group mb-2">
                <label for="nombre" class="col-form-label">Nombre *</label>
                <input type="text" name="nombre" id="nombre" aria-describedby="nombreHelpBlock" class="form-control" placeholder="Nombre del producto" value="<?php echo set_value('nombre'); ?>" required>
                <small id="nombreHelpBlock" class="form-text text-danger">
                    <?php echo form_error('nombre'); ?>
                </small>
            </div>
            <div class="form-row mb-2">
                <div class="col">
                    <div class="form-group mb-0">
                        <label for="categoria" class="col-form-label">Categoria *</label>
                        <select name="categoria" id="categoria" class="custom-select" aria-describedby="categoriaHelpBlock" required>
                            <option value="0" selected>Selecciona una categoria</option>
                            <?php foreach ($categorias as $categoria) { ?>
                                <option value="<?= $categoria['id'] ?>" <?= set_select('categoria', $categoria['id']); ?>><?= $categoria['nombre'] ?></option>
                            <?php } ?>
                        </select>
                        <small id="categoriaHelpBlock" class="form-text text-danger">
                            <?php echo form_error('categoria'); ?>
                        </small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-0">
                        <label for="precio" class="col-form-label">Precio *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="precioHelpBlock"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input type="text" name="precio" id="precio" aria-describedby="precioHelpBlock" class="form-control" placeholder="Precio unitario" value="<?php echo set_value('precio'); ?>" required>
                        </div>
                        <small id="precioHelpBlock" class="form-text text-danger">
                            <?php echo form_error('precio'); ?>
                        </small>
                    </div>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="imagen" class="col-form-label">Imagen *</label>
                <div id="imageresult"></div>
                <input type="file" name="imagen" id="imagen" data-jfiler-showThumbs="true" aria-describedby="imagenHelpBlock" class="form-control">
                <small id="imagenHelpBlock" class="form-text text-danger">
                    <?php echo form_error('imagen'); ?>
                </small>
                <div class="alert alert-info" role="alert">
                    <ul class="list-unstyled mb-0 small">
                        <li>La imagen debe tener un tamaño maximo de <b>5000x5000</b> pixeles</li>
                        <li>El tamaño minimo debe ser de <b>500x500</b> pixeles</li>
                    </ul>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="descripcion" class="col-form-label">Descripción del producto *</label>
                <textarea name="descripcion" id="descripcion" aria-describedby="descripcionHelpBlock" class="form-control" placeholder="Describe tu producto" rows="5" onkeyup="countChar(this)" required><?php echo set_value('descripcion'); ?></textarea>
                <small id="descripcionHelpBlock" class="form-text text-danger">

                    <?php echo form_error('descripcion'); ?>
                </small>
                <div class="alert alert-info small" role="alert">
                    La descripción no debe superar los <span id="charNum">240</span> caracteres
                </div>
            </div>
            <script>
                function countChar(val) {
                    var len = val.value.length;
                    if (len >= 240) {
                        val.value = val.value.substring(0, 240);
                    } else {
                        $('#charNum').text(240 - len);
                    }
                };
            </script>
            <div class="text-right pt-2">
                <button type="submit" id="submit_producto" class="btn btn-lg btn-primary"><i class="fas fa-plus"></i>&nbsp; Agregar producto</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- Tarjeta con información del cliente 
        <div class="col-md-3">
            <?php $this->load->view('emprendedores/info'); ?>
        </div>-->
    </div>
</section>

<?php
// Carga los pie de página
$this->load->view('templates/main/followus');
$this->load->view('templates/tienda/footer');
?>
<script>
    $(document).ready(function() {
        $("#submit_producto").click(function(e) {
            $('#precio').unmask();
            $("#form_producto").submit(); // jQuey's submit function applied on form.
        });
    });
</script>