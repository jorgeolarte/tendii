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
            <?php if (count($productos) == 0) { ?>
                <div class="row justify-content-md-center">
                    <div class="col-md-8 py-4">
                        <!-- No tienes pedidos -->
                        <div class="alert text-center" role="alert">
                            <h4 class="alert-heading">No tienes productos configurados! 😥</h4>
                            <p>Te invitamos a crear tu primer producto y empezar a vender a través de nuestra tienda.</p>
                            <img src="https://media.giphy.com/media/229Ozo6sMl3K69NgwE/giphy-downsized.gif">
                            <a href="<?= site_url('admin/producto/nuevo') ?>" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i>&nbsp; Oprime aquí para crear tu primer producto</a>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <h1 class="mt-4">Editar productos</h1>
                <p class="font-italic">Para editar tus productos solo debes oprimir sobre el nombre, descripción o precio; realizar el cambio y enter para guardar</p>
                <div class="row">
                    <div class="col-12">
                        <ul class="list-unstyled">
                            <?php foreach ($productos as $producto) { ?>
                                <li class="media bg-light mb-3 p-3">
                                    <img class="mr-3" src="<?= image(base_url('assets/tienda/' . $producto['imagen']), "square") ?>" class="card-img-top" alt="<?= $producto['producto'] ?> - <?= $producto['emprendimiento'] ?>">
                                    <div class="media-body">
                                        <h5 id="nombre_<?= $producto['id_producto']; ?>" data-value="<?= $producto['producto']; ?>" onclick="this.contentEditable=true; this.className='bg-white';" onblur="this.contentEditable=false; this.className='';" onkeypress="saveData(event,'<?= $producto['id_producto']; ?>', 'nombre', $(this).html() )" data-toggle="tooltip" data-placement="top" title="Oprime para editar y enter para guardar">
                                            <?= ucwords(mb_strtolower($producto['producto'])) ?>
                                        </h5>
                                        <small id="nombreError_<?= $producto['id_producto']; ?>" class="mt-0 form-text text-danger"></small>
                                        <p id="descripcion_<?= $producto['id_producto']; ?>" data-value="<?= $producto['descripcion']; ?>" onclick="this.contentEditable=true; this.className='bg-white';" onblur="this.contentEditable=false; this.className='';" onkeypress="saveData(event,'<?= $producto['id_producto']; ?>', 'descripcion', $(this).html() )" data-toggle="tooltip" data-placement="top" title="Oprime para editar y enter para guardar">
                                            <?= ucfirst(mb_strtolower($producto['descripcion'])) ?>
                                        </p>
                                        <small id="descripcionError_<?= $producto['id_producto']; ?>" class="form-text text-danger"></small>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="mb-0 font-weight-bold text-primary">
                                                    $ <span id="precio_<?= $producto['id_producto']; ?>" data-value="<?= $producto['precio']; ?>" onclick="this.contentEditable=true; this.className='bg-white';" onblur="this.contentEditable=false; this.className='';" onkeypress="saveData(event,'<?= $producto['id_producto']; ?>', 'precio', $(this).html() )" data-toggle="tooltip" data-placement="top" title="Oprime para editar y enter para guardar"><?= number_format($producto['precio'], $this->session->userdata('pais')['decimales']); ?></span>
                                                    <i class="fas fa-tag"></i>
                                                </p>
                                                <small id="precioError_<?= $producto['id_producto']; ?>" class="form-text text-danger"></small>
                                            </div>
                                            <?php
                                            // echo validation_errors();
                                            // Crear atributos
                                            $attributes = array('id' => 'form_registrar_emprendedor');
                                            // Ocultos
                                            $hidden = array('id' => $producto['id_producto']);
                                            // Pintar formulario
                                            echo form_open('admin/producto/eliminar', $attributes, $hidden); ?>
                                            <button type="submit" onclick="return confirm('¿Estas seguro de eliminar el producto?')" class="card-link btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            <?= form_close(); ?>
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
                                            url: "<?= base_url('admin/producto/actualizar') ?>",
                                            data: {
                                                'id': id,
                                                'key': key,
                                                'value': value
                                            }
                                        }).done(function(response) {
                                            console.log(response);
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
                    </div>
                </div>
            <?php } ?>

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