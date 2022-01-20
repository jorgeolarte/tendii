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

<!-- Modal para crear el perfil -->
<?php if (is_null($this->session->userdata('slug'))) { ?>
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
                        <a href="<?= site_url('admin/perfil'); ?>" class="btn btn-lg btn-block btn-danger"><i class="fas fa-store"></i>&nbsp; Clic para crear</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Section principal -->
<div class="bg-white">
    <section class="container py-4">
        <div class="row justify-content-md-center">
            <div class="col-md-4 order-2 order-md-1 pb-3  sticky-top">
                <?php $this->load->view('emprendedores/left'); ?>
            </div>

            <div class="col-md-8 order-1 order-md-2">

                <?php if (count($productos) == 0) { ?>
                    <div class="jumbotron">
                        <h1 class="h2">Bienvenido emprendedor</h1>
                        <p class="lead">Para empezar a vender a través de la tienda es necesario que publiques tus productos.</p>
                        <a href="<?= site_url('admin/nuevo_producto') ?>" class="btn btn-lg btn-primary"><i class="fas fa-plus"></i>&nbsp; Nuevo producto</a>
                    </div>
                <?php } else { ?>
                    <div class="d-flex align-items-center justify-content-end mb-3">
                        <a href="<?= site_url('admin/nuevo_producto') ?>" class="btn btn-outline-primary animated infinite flash"><i class="fas fa-plus"></i>&nbsp; Nuevo producto</a>
                    </div>
                    <ul class="list-unstyled">
                        <?php foreach ($productos as $producto) { ?>
                            <li class="media bg-light mb-3 p-3">
                                <img class="mr-3" src="<?= image(base_url('assets/tienda/' . $producto['imagen']), "square") ?>" class="card-img-top" alt="<?= $producto['producto'] ?> - <?= $producto['emprendimiento'] ?>">
                                <div class="media-body">
                                    <h5 id="nombre_<?= $producto['id_producto']; ?>" data-value="<?= $producto['producto']; ?>" onclick="this.contentEditable=true; this.className='bg-white';" onblur="this.contentEditable=false; this.className='';" onkeypress="saveData(event,'<?= $producto['id_producto']; ?>', 'nombre', $(this).html() )">
                                        <?= ucwords(mb_strtolower($producto['producto'])) ?>
                                    </h5>
                                    <small id="nombreError_<?= $producto['id_producto']; ?>" class="mt-0 form-text text-danger"></small>
                                    <p id="descripcion_<?= $producto['id_producto']; ?>" data-value="<?= $producto['descripcion']; ?>" onclick="this.contentEditable=true; this.className='bg-white';" onblur="this.contentEditable=false; this.className='';" onkeypress="saveData(event,'<?= $producto['id_producto']; ?>', 'descripcion', $(this).html() )">
                                        <?= ucfirst(mb_strtolower($producto['descripcion'])) ?>
                                    </p>
                                    <small id="descripcionError_<?= $producto['id_producto']; ?>" class="form-text text-danger"></small>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 font-weight-bold text-primary">
                                                $ <span id="precio_<?= $producto['id_producto']; ?>" data-value="<?= $producto['precio']; ?>" onclick="this.contentEditable=true; this.className='bg-white';" onblur="this.contentEditable=false; this.className='';" onkeypress="saveData(event,'<?= $producto['id_producto']; ?>', 'precio', $(this).html() )"><?= number_format($producto['precio'], $this->session->userdata('pais')['decimales']); ?></span>
                                                <i class="fas fa-tag"></i>
                                            </p>
                                            <small id="precioError_<?= $producto['id_producto']; ?>" class="form-text text-danger"></small>
                                        </div>
                                        <a onclick="return confirm('¿Estas seguro de eliminar el producto?')" href="<?= site_url('zona/eliminar_producto/' . $producto['id_producto']) ?>" class="card-link btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            </li>

                        <?php } ?>
                    </ul>
                    <script>
                        function saveData(e, id, key, value) {
                            if (e.keyCode === 13) {
                                if (confirm('Desear realizar los cambios?')) {
                                    e.preventDefault();

                                    $.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: "<?= base_url('zona/actualizar_producto') ?>",
                                        data: {
                                            'id': id,
                                            'key': key,
                                            'value': value
                                        }
                                    }).done(function(response) {
                                        respuesta(id, key, value, response.success, response.message);
                                    });
                                }
                            }
                        }

                        function respuesta(id, key, value, estado, res) {
                            // Todo bien?
                            if (estado) {
                                // Desactivar los textos de ayuda
                                $("#" + key + "Error_" + id).text("");
                            } else {
                                // Validar si el valor esta vacio
                                if (value == "") {
                                    // Reemplazar el valor por el nombre original
                                    value = $("#" + key + "_" + id).attr("data-value");
                                }
                                // Reemplazar el nombre
                                $("#" + key + "_" + id).text(value);
                                // Mostar el error
                                $("#" + key + "Error_" + id).text(res);
                            }

                        }
                    </script>
                <?php } ?>
            </div>
        </div>
    </section>
</div>

<?php
// Carga los pie de página
$this->load->view('templates/main/followus');
$this->load->view('templates/tienda/footer');
?>