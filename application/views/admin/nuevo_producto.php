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
            <h1 class="mt-4">Vamos a crear un producto</h1>
            <p class="font-italic">Lee atentamente las recomendaciones que te damos despues de cada campo del formulario</p>
            <div class="row mb-3 justify-content-md-center">
                <div class="col-md-8">
                    <?php
                    // Crear atributos
                    $attributes = array('id' => 'form_producto', 'method' => 'post');
                    // Pintar formulario
                    echo form_open_multipart('admin/producto/crear', $attributes); ?>
                    <div class="form-group mb-2">
                        <label for="nombre" class="col-form-label font-weight-bold">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" aria-describedby="nombreHelpBlock" class="form-control" placeholder="Nombre del producto" value="<?php echo set_value('nombre'); ?>" required>
                        <small id="nombreHelpBlock" class="form-text text-danger">
                            <?php echo form_error('nombre'); ?>
                        </small>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col">
                            <div class="form-group mb-0">
                                <label for="categoria" class="col-form-label font-weight-bold">Categoria *</label>
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
                                <label for="precio" class="col-form-label font-weight-bold">Precio *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="precioHelpBlock"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="number" name="precio" id="precio" step="<?= $step ?>" aria-describedby="precioHelpBlock" class="form-control" placeholder="Precio unitario" value="<?php echo set_value('precio'); ?>" required>
                                </div>
                                <small id="precioHelpBlock" class="form-text text-danger">
                                    <?php echo form_error('precio'); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="imagen" class="col-form-label font-weight-bold">Imagen *</label>
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
                        <label for="descripcion" class="col-form-label font-weight-bold">Descripción del producto *</label>
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
                        <button type="submit" id="submit_producto" class="btn btn-lg btn-primary font-weight-bold"><i class="far fa-save"></i>&nbsp; Guardar producto</button>
                    </div>
                    <?= form_close(); ?>
                    <script>
                        $(document).ready(function() {
                            jQuery.validator.addMethod("currency", function(value, element, param) {
                                var isParamString = typeof param === "string",
                                    symbol = isParamString ? param : param[0],
                                    soft = isParamString ? true : param[1],
                                    regex;

                                symbol = symbol.replace(/,/g, "");
                                symbol = soft ? symbol + "]" : symbol + "]?";
                                regex = "^[" + symbol + "([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*(\\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,2})?|0(\\.[0-9]{0,2})?|(\\.[0-9]{1,2})?)$";
                                regex = new RegExp(regex);
                                return this.optional(element) || regex.test(value);

                            }, "Please specify a valid currency");

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
                        });

                        $("#form_producto").validate({
                            rules: {
                                nombre: {
                                    required: true,
                                    minlength: 10,
                                    maxlength: 50,
                                },
                                categoria: {
                                    min: 1
                                },
                                imagen: {
                                    required: true,
                                    extension: "jpg|jpeg|png",
                                    filesize: 5000000,
                                    dimention: [500, 500]
                                },
                                descripcion: {
                                    required: true,
                                    minlength: 50,
                                    maxlength: 240
                                },
                                precio: {
                                    required: true,
                                    min: <?= $precio_minimo ?>,
                                    currency: ["$", false],
                                }
                            },
                            messages: {
                                nombre: {
                                    required: "Nombre es obligatorio",
                                    minlength: jQuery.validator.format("Al menos debe tener {0} caracteres"),
                                    maxlength: jQuery.validator.format("No debe pasar de {0} caracteres")
                                },
                                categoria: {
                                    min: "Seleccione una categoria"
                                },
                                imagen: {
                                    required: "Selecciona una imagen",
                                    extension: "La extensión de la imagen debe ser jpg o png",
                                    filesize: "El tamaño del archivo debe ser inferior a 5MB",
                                    dimention: "Cargue una imagen con una dimensión mínima de {0} x {1} píxeles"
                                },
                                descripcion: {
                                    required: "La descripción es obligatoria",
                                    minlength: jQuery.validator.format("Al menos debe tener {0} caracteres"),
                                    maxlength: jQuery.validator.format("No debe pasar de {0} caracteres")
                                },
                                precio: {
                                    required: "El precio es obligatorio",
                                    min: "El precio minimo es de $<?= number_format($precio_minimo, $this->session->userdata('pais')['decimales']) ?>"
                                }
                            },
                            validClass: "is-valid",
                            errorClass: "is-invalid",
                            errorElement: "small",
                            submitHandler: function(form) {
                                // do other things for a valid form
                                // $('#precio').unmask();
                                form.submit();
                            }
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